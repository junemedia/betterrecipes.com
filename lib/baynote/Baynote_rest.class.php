<?php

require_once 'curl_cache.inc.php';

class Baynote_rest
{
  // define properties
  protected $baynote;
  protected $apiUrl;
  protected $cn;
  protected $cc;
  protected $cacheTime;
  protected $timeout;
  protected $user_agent = 'curl/7.15.5 (x86_64-redhat-linux-gnu) libcurl/7.15.5 OpenSSL/0.9.8b zlib/1.2.3 libidn/0.6.5 PHP/5.3.6';
  protected $redirect_count = 0;
//    protected $handle_cookies = false; // DO NOT enable unless you have pecl_http already installed in your server
  protected $last_error;
  protected $last_response;
  protected $last_effective_url;
  protected $serializer;

  public function __construct()
  {
    //$this->baynote = $baynote;
    ;
    $this->cn = sfConfig::get('app_baynote_cn');
    $this->cc = sfConfig::get('app_baynote_cc');
    $this->timeout = sfConfig::get('app_baynote_timeout');
    $this->cacheTime = sfConfig::get('app_cache_time');
    $this->apiUrl = sfConfig::get('app_baynote_apiurl') . 'cn=' . $this->cn . '&cc=' . $this->cc . '&mode=live&outputFormat=XML';
    $this->default_params = array(
    );
  }

  /**
   * Execute the cURL request
   * 
   * @see https://github.com/resolutedigital/srv/blob/master/lib/curl_cache.inc.php
   * @param string $url
   * @param array $params key/value parameters
   * @param boolean $post send a POST request if true
   * @param integer $cache_ttl the amount of time in seconds to cache, if null use the defaults. Set to false or 0 to disable caching
   * @param integer $timeout Connection timeout, if null use the defaults
   * @return string 
   */
  protected function initApi($url, array $params = array(), $post = false, $cache_ttl = null, $timeout = null)
  {
    //echo $url;
    if ($this->redirect_count > 10) {
      $this->last_error = 'Max redirection reached';
      return false;
    }

    $this->last_error = null;

    if (is_null($cache_ttl)) {
      $cache_ttl = $this->cacheTime;
    }

    if (is_null($timeout)) {
      $timeout = $this->timeout;
    }

    $url = rtrim($url, '?');
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, $this->getUserAgent($this->user_agent));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: */*'));
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false); // need to disable this and manually follow. This avoids lots of headers to read
//      curl_setopt($curl, CURLOPT_MAXREDIRS, 10);

    $params = $params + $this->default_params;

    if ($post) {
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
    } else {
//      $url .= http_build_query($params, '', '&', PHP_QUERY_RFC3986); // PHP5.4
      $url .= $this->paramToQueryString($params);
    }
    //echo '<br><br>'.$url.'<br><br>';
    curl_setopt($curl, CURLOPT_URL, $url);

//      if ($this->handle_cookies) {
////        curl_setopt($curl, CURLOPT_COOKIE, $_SERVER['HTTP_COOKIE']);
//        curl_setopt($curl, CURLOPT_COOKIEFILE, sfConfig::get('sf_cache_dir').'/cookiejar');
//        curl_setopt($curl, CURLOPT_COOKIEJAR, sfConfig::get('sf_cache_dir').'/cookiejar');
//      }

    $this->last_effective_url = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);

    if (!$cache_ttl) {
      if ($timeout) {
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
      }
      $response = curl_exec($curl);
    } else {
      $response = curl_cache($curl, $cache_ttl, $timeout);
    }

    if (!$response) {
      $this->last_error = curl_error($curl);
      return false;
    }

    curl_close($curl);

    $headers = array();
    list($raw_headers, $body) = explode("\r\n\r\n", $response, 2);

//      echo 'Redirect count = '.$this->redirect_count.PHP_EOL
//              .'URL = '.$url.PHP_EOL.PHP_EOL
//              .'POST = '.json_encode($params).PHP_EOL.PHP_EOL
//              .$raw_headers.PHP_EOL.PHP_EOL.str_repeat('=', 80).PHP_EOL.PHP_EOL;

    $header_lines = explode("\r\n", $raw_headers);
    foreach ($header_lines as $value) {
      $kvp = explode(":", $value, 2);
      if (isset($kvp[1])) {
        $headers[$kvp[0]] = trim($kvp[1]);
      } else {
        $headers[] = $kvp[0];
      }
    }

//      if ($this->handle_cookies) {
//        foreach ($headers as $k => $v) {
//          if ($k === 'Set-Cookie') {
//            $cookie = http_parse_cookie($v);
//            $domain = $cookie->domain == '.betterrecipes.com' ? '.'.UrlToolkit::getDomain() : $cookie->domain;
//            foreach ($cookie->cookies as $cookie_name => $cookie_value) {
//              setcookie($cookie_name, $cookie_value, $cookie->expires, $cookie->path, $domain);
//            }
//          }
//        }
//      }

    if ($this->redirect_count == 0) {
      $this->last_response = array();
    }

    $this->last_response['headers'][$this->redirect_count] = $headers;
    $this->last_response['body'] = $body;

    //$this->baynote->log(__METHOD__, $this->last_response);


    if (isset($headers['Location'])) {
      $this->redirect_count += 1;
      $body = $this->initApi($headers['Location'], $params, $post, $cache_ttl, $timeout);
    }

    return $body;
  }

  /**
   * @param array $params
   * @param string $array_key
   * @return string 
   */
  public function paramToQueryString(array $params, $array_key = null)
  {
    $query = '';
    foreach ($params as $key => $value) {
      if (is_array($value)) {
        $query .= $this->paramToQueryString($value, $key);
      } else {
        if ($array_key) {
          $key = $array_key . '[' . $key . ']';
        }
        $query .= '&' . $key . '=' . rawurlencode($value);
      }
    }
    return $query;
  }

  /**
   * Sends a GET request
   * 
   * @param string $url
   * @param array $params
   * @param integer $cache_ttl
   * @param integer $timeout
   * @return string 
   */
  protected function get($url, array $params = array(), $cache_ttl = null, $timeout = null)
  {
    return $this->initApi($url, $params, false, $cache_ttl, $timeout);
  }

  /**
   * Sends a POST request
   * 
   * @param string $url
   * @param array $params
   * @param integer $cache_ttl
   * @param integer $timeout
   * @return string 
   */
  protected function post($url, array $params = array(), $cache_ttl = null, $timeout = null)
  {
    return $this->initApi($url, $params, true, $cache_ttl, $timeout);
  }

  /**
   * Last cURL URL.
   * 
   * @return string 
   */
  public function getLastEffectiveUrl()
  {
    return $this->last_effective_url;
  }

  /**
   * Last cURL response. Includes headers and body
   * 
   * @return array 
   */
  public function getLastResponse()
  {
    return $this->last_response;
  }

  /**
   * Return last cURL response headers
   * 
   * @return array
   */
  public function getLastResponseHeaders()
  {
    return isset($this->last_response['headers']) ? $this->last_response['headers'] : null;
  }

  /**
   * Return last cURL response body
   * 
   * @return string
   */
  public function getLastResponseBody()
  {
    return isset($this->last_response['body']) ? $this->last_response['body'] : null;
  }

  /**
   * Whether the last cURL request had an error
   * 
   * @return boolean
   */
  public function isError()
  {
    return ($this->last_error instanceof Exception) ? true : false;
  }

  /**
   * The last cURL request error if any
   * 
   * @return Exception
   */
  public function getLastError()
  {
    return $this->last_error;
  }

  /**
   * Reads client's UserAgent or use default
   * 
   * @param string $default the default string to use if can't detect one
   * @return string
   */
  public function getUserAgent($default = null)
  {
    return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ($default ? $default : $this->user_agent);
  }

  public function search($query, $startingDocNum, $resultsPerPage, $PageType, $Rating = null, $CategoryName = array(), $withParam = array(), $withoutParam = array(), $recipeOwner = array(), $attrList = null, $SubcategoryName = array(), $attrSort = null, $cache_ttl = null)
  {
    $data = array();
    $items = array();
    $att = (isset($attrList)) ? $attrList : '*';
    $attSort = (isset($attrSort)) ? $attrSort.',ImageExist:desc' : 'ImageExist:desc';
    $page = 'PageType:' . $PageType;
    $result = $PageType;


    // revising rating so that it passes a range
    if (isset($Rating)) {
      switch ($Rating) {
        case '1' :
        case '2' :
        case '3' :
        case '4' :
          $r = $Rating . '.0000..5.0000';
          break;
        case '5' :
          $r = $Rating . '.0000';
          break;
        default :
          $r = $Rating . '.0000';
      }
      $rate = ',Rating:' . $r;
    } else {
      $rate = '';
    }
    //$rate = (isset($Rating)) ? ',Rating:' . $Rating . '.0000' : '';
    //$cat = (isset($CategoryName)) ? ',SubCategoryName:'.$CategoryName : '';

    $cat = '';
    if (sizeof($CategoryName) > 0) {
      $cat .= ',';
      $parts = explode(',', $CategoryName);
      foreach ($parts as $v) {
        if ($v != '') {
          $cat .= 'SubCategoryName:' . $v . '|';
        }
      }
      $cat = substr($cat, 0, -1);
    }
    //echo $cat.'<br><br>';

    $subcat = '';
    if (sizeof($SubcategoryName) > 0) {
      $subcat .= ',';
      $parts = explode(',', $SubcategoryName);
      foreach ($parts as $v) {
        if ($v != '') {
          $subcat .= 'CategoryName:' . $v . '|';
        }
      }
      $subcat = substr($subcat, 0, -1);
    }

    $with = '';
    $without = '';
    $recipe_owner = '';

    if (sizeof($withParam) > 0) {
      $w = '';
      foreach ($withParam as $v) {
        $w .= 'RootIngredients:' . $v . ',';
      }
      //$with = substr($w, 0, -1);
      $with = $w;
    }

    if (sizeof($withoutParam) > 0) {
      $w = '';
      foreach ($withoutParam as $v) {
        $w .= '-RootIngredients:' . $v . ',';
      }
      $without = $w;
    }

    if (sizeof($recipeOwner) > 0) {
      $w = '';
      foreach ($recipeOwner as $v) {
        $w .= 'AuthorName:' . $v . ',';
      }
      $recipe_owner = $w;
    }

    /* if (isset($filter)) {
      switch($filter) {
      case 'PageType' :
      $facet = 'PageType:'.$filterVal;
      $result = $filterVal;
      break;
      case 'Course' :
      $facet = 'Course:'.$filterVal;
      $result = 'recipe';
      break;
      case 'MainIngredient' :
      $facet = 'MainIngredient:'.$filterVal;
      $result = 'recipe';
      break;
      case 'Rating' :
      $facet = 'Rating:'.$filterVal.'.0000';
      $result = 'recipe';
      break;
      default :
      $facet = '';
      $result = 'recipe';
      }
      } else {
      $facet = '';
      $result = 'recipe';
      } */
    $response = $this->get($this->apiUrl, array(
      'q' => $query,
      'startingDocNum' => $startingDocNum,
      'resultsPerPage' => $resultsPerPage,
      'attrList' => $att,
      'attrSort' => $attSort,
      'facetFilter' => $page . $rate . $cat . $subcat,
      'qa' => $with . $without . $recipe_owner
      ), $cache_ttl);
    $xml = @simplexml_load_string($response);
    //print_r($xml);
    if ($xml) {
      if (isset($xml->attributes()->tot) && (int) $xml->attributes()->tot > 0) {
        switch ($result) {
          case 'Recipe' :
            for ($i = 0; $i < count($xml->r); $i++) {
              $subdir = '';
              $display_name = '';
              $items[] = array(
                'subdir' => $subdir,
                'display_name' => $display_name,
                'date' => (string) date('F j, Y, g:i A', strtotime($xml->r[$i]->attributes()->PubDate)),
                'title' => (string) $xml->r[$i]->attributes()->Title,
                'description' => (string) $xml->r[$i]->attributes()->Description,
                'image' => (string) $xml->r[$i]->attributes()->Image,
                'rating' => (string) ceil($xml->r[$i]->attributes()->Rating),
                'url' => (string) $xml->r[$i]->attributes()->u,
                'baynote_bnrank' => (string) $xml->r[$i]->attributes()->baynote_bnrank,
                'baynote_irrank' => (string) $xml->r[$i]->attributes()->baynote_irrank
              );
            }
            break;

          case 'member' :
            for ($i = 0; $i < count($xml->r); $i++) {
              $items[] = array(
                'subdir' => (string) $xml->r[$i]->attributes()->Subdir,
                'display_name' => (string) $xml->r[$i]->attributes()->DisplayName,
                'avatar' => (string) $xml->r[$i]->attributes()->Avatar,
                'url' => (string) $xml->r[$i]->attributes()->u,
                'baynote_bnrank' => (string) $xml->r[$i]->attributes()->baynote_bnrank,
                'baynote_irrank' => (string) $xml->r[$i]->attributes()->baynote_irrank
              );
            }
            break;

          case 'group' :
            for ($i = 0; $i < count($xml->r); $i++) {
              $items[] = array(
                'title' => (string) $xml->r[$i]->attributes()->Title,
                'description' => (string) $xml->r[$i]->attributes()->Description,
                'url' => (string) $xml->r[$i]->attributes()->u,
                'avatar' => (string) $xml->r[$i]->attributes()->Avatar,
                'baynote_bnrank' => (string) $xml->r[$i]->attributes()->baynote_bnrank,
                'baynote_irrank' => (string) $xml->r[$i]->attributes()->baynote_irrank
              );
            }
            break;

          case 'photo' :
            for ($i = 0; $i < count($xml->r); $i++) {
              $items[] = array(
                'title' => (string) $xml->r[$i]->attributes()->Caption,
                'url' => (string) $xml->r[$i]->attributes()->u,
                'baynote_bnrank' => (string) $xml->r[$i]->attributes()->baynote_bnrank,
                'baynote_irrank' => (string) $xml->r[$i]->attributes()->baynote_irrank
              );
            }
            break;

          case 'discussion' :
            for ($i = 0; $i < count($xml->r); $i++) {
              $items[] = array(
                'title' => (string) $xml->r[$i]->attributes()->Title,
                'url' => (string) $xml->r[$i]->attributes()->u,
                'baynote_bnrank' => (string) $xml->r[$i]->attributes()->baynote_bnrank,
                'baynote_irrank' => (string) $xml->r[$i]->attributes()->baynote_irrank
              );
            }
            break;

          case 'video' :
            for ($i = 0; $i < count($xml->r); $i++) {
              $items[] = array(
                'title' => (string) $xml->r[$i]->attributes()->Caption,
                'url' => (string) $xml->r[$i]->attributes()->u,
                'baynote_bnrank' => (string) $xml->r[$i]->attributes()->baynote_bnrank,
                'baynote_irrank' => (string) $xml->r[$i]->attributes()->baynote_irrank
              );
            }
            break;

          case 'journals' :
            for ($i = 0; $i < count($xml->r); $i++) {
              $items[] = array(
                'title' => (string) $xml->r[$i]->attributes()->Title,
                'url' => (string) $xml->r[$i]->attributes()->u,
                'baynote_bnrank' => (string) $xml->r[$i]->attributes()->baynote_bnrank,
                'baynote_irrank' => (string) $xml->r[$i]->attributes()->baynote_irrank
              );
            }
            break;

          case 'poll' :
            for ($i = 0; $i < count($xml->r); $i++) {
              $items[] = array(
                'title' => (string) $xml->r[$i]->attributes()->Title,
                'url' => (string) $xml->r[$i]->attributes()->u,
                'baynote_bnrank' => (string) $xml->r[$i]->attributes()->baynote_bnrank,
                'baynote_irrank' => (string) $xml->r[$i]->attributes()->baynote_irrank
              );
            }
            break;

          case 'blogs' :
            for ($i = 0; $i < count($xml->r); $i++) {
              $items[] = array(
                'title' => (string) $xml->r[$i]->attributes()->Title,
                'url' => (string) $xml->r[$i]->attributes()->u,
                'description' => (string) $xml->r[$i]->attributes()->Description,
                'date' => (string) $xml->r[$i]->attributes()->PubDate,
                'baynote_bnrank' => (string) $xml->r[$i]->attributes()->baynote_bnrank,
                'baynote_irrank' => (string) $xml->r[$i]->attributes()->baynote_irrank
              );
            }
            break;
        }
        $data = array(
          'total' => (string) $xml->attributes()->tot,
          'items' => $items,
          'type' => $result
        );
      }
    }
    //print_r($data);
    return $data;
  }

}