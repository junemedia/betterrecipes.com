<?php

/**
 * Url functions
 */
class UrlToolkit
{
  private static $routing_exceptions = array('recipes' => 'groups');

  /**
   * Wrapper for getRoute
   * 
   * @param Object $type or string
   * @param array  $params
   * @return string 
   */
  public static function getUrl($type, $params = null)
  {
    return self::getRoute($type, $params);
  }

  public static function getRoute($type, $params = null)
  {
    if (!function_exists('url_for')) {
      // calling outside of a view context
      sfContext::getInstance()->getConfiguration()->loadHelpers('Url');
    }

    if (is_object($type)) {
      switch (get_class($type)) {
        case 'Category':
          if ($type->isMainCategory()) {
            // Get main-category url
            $url = self::getProtocol() . $type->getSlug() . '.' . self::getDomain() . (isset($params['mode']) && $params['mode'] == 'preview' ? '?mode=preview' : '');
          } else {
            // Get sub-category url
            $url = self::getProtocol() . $type->getParent()->getSlug() . '.' . self::getDomain() . '/' . $type->getSlug() . '.html' . (isset($params['mode']) && $params['mode'] == 'preview' ? '/preview' : '');
          }
          break;
        case 'Recipe':
          if ($type->hasCategory()) {
            $url = self::getProtocol() . $type->getFirstCategory()->getParent()->getSlug() . '.' . self::getDomain() . '/' . $type->getSlug() . '.html' . (isset($params['mode']) && $params['mode'] == 'preview' ? '/preview' : '');
          } else {
            // This part is for handling bad urls. The following link will lead the request to the 404 page gracefully
            $url = self::getProtocol() . self::getDomain() . '/' . $type->getSlug() . '.html' . (isset($params['mode']) && $params['mode'] == 'preview' ? '/preview' : '');
          }
          break;
        case 'Article':
          $url = self::getProtocol() . $type->getCategory()->getSlug() . '.' . self::getDomain() . '/' . $type->getSlug() . '.html' . (isset($params['mode']) && $params['mode'] == 'preview' ? '/preview' : '');
          break;
        case 'Slideshow':
          if (isset($params['mode']) && $params['mode'] == 'preview') {
            $url = self::getProtocol() . $type->getCategory()->getSlug() . '.' . self::getDomain() . sfContext::getInstance()->getConfiguration()->generateFrontendUrl('slideshow_detail', array('slug' => $type->getSlug(), 'mode' => 'preview'));
          } else {
            $url = self::getProtocol() . $type->getCategory()->getSlug() . '.' . self::getDomain() . url_for('@slideshow_detail?slug=' . $type->getSlug());
          }
          break;
        default:
        // generic url
      }
    } else {
      if (strpos($type, '@group') !== false) {
        if (isset($params['category']) && isset(self::$routing_exceptions[$params['category']])) {
          $params['category'] = self::$routing_exceptions[$params['category']];
        }
      }
      switch ($type) {
        case '@cook_profile':
        case 'User' :
          if ($params['display_name'] && $params['display_name'] != '') {
            $url = self::getDomainUri() . url_for('cook_profile', array('display_name' => $params['display_name']));
          } else {
            $url = 'javascript:void(0);';
          }
          break;
        case '@cook_profile_recipes':
        case '@cook_profile_saved_recipes':
        case '@cook_profile_edit':
          $url = self::getDomainUri() . url_for($type . '?display_name=' . $params['display_name']);
          break;
        case '@photo_detail' :
          $url = self::getDomainUri() . url_for($type . '?slug=' . $params['slug'] . '&id=' . $params['id']);
          break;
        case '@photo_upload' :
          $url = self::getDomainUri() . url_for($type . '?id=' . $params['id']);
          break;
        case '@video_detail' :
          $url = self::getDomainUri() . url_for($type . '?slug=' . $params['slug'] . '&id=' . $params['id']);
          break;
        case '@video_upload' :
          $url = self::getDomainUri() . url_for($type . '?id=' . $params['id']);
          break;
        case '@daily_dish_detail' :
          if (isset($params['comment'])) {
            $url = self::getDomainUri() . url_for($type . '?year=' . $params['year'] . '&month=' . $params['month'] . '&day=' . $params['day'] . '&slug=' . $params['slug']) . '#comment';
          } else {
            $url = self::getDomainUri() . url_for($type . '?year=' . $params['year'] . '&month=' . $params['month'] . '&day=' . $params['day'] . '&slug=' . $params['slug']);
          }
          break;
        case '@daily_dish_category' :
          $url = self::getDomainUri() . url_for($type . '?category=' . $params['category']);
          break;
        case '@daily_dish_tag' :
          $url = self::getDomainUri() . url_for($type . '?tag=' . $params['tag']);
          break;
        case '@daily_dish_archive' :
          $url = self::getDomainUri() . url_for($type . '?year=' . $params['year'] . '&month=' . $params['month']);
          break;
        case '@journal_detail' :
          $url = self::getDomainUri() . url_for($type . '?slug=' . $params['slug'] . '&id=' . $params['id']);
          break;
        case '@add_recipe_photo' :
          $url = self::getDomainUri() . url_for($type . '?recipe_id=' . $params['recipe_id']);
          break;
        case '@edit_recipe' :
          $url = self::getDomainUri() . url_for($type . '?id=' . $params['id']);
          break;
        case '@add_recipe' :
          $group_params = isset($params['group_id']) ? '?group_ids=' . $params['group_id'] : '';
          $url = self::getDomainUri() . url_for($type . $group_params);
          break;
        case '@search' :
          $url = self::getDomainUri() . url_for($type . '?term=*&PageType=' . $params['page']);
          break;
        case '@contests_detail' :
          if (isset($params['mode']) && $params['mode'] == 'preview') {
            $url = self::getProtocol() . self::getDomain() . sfContext::getInstance()->getConfiguration()->generateFrontendUrl('contests_detail', $params);
          } else {
            $url = self::getDomain() . url_for('@contests_detail?slug=' . $type->getSlug());
          }
          break;
        case '@contests_enter_contest' :
          $url = self::getDomainUri() . url_for($type . '?id=' . $params['id'] . '&type=' . $params['type'] . '&recipe_id=' . $params['recipe_id']);
          break;
        case '@help' :
          $url = self::getDomainUri() . url_for('@help');
          break;
        case '@rewards' :
          $url = self::getDomainUri() . url_for('@rewards');
          break;
        case '@myrecipebox' :
          $url = self::getDomainUri() . url_for('@myrecipebox');
          break;
        case '@privacy-policy' :
          $url = self::getDomainUri() . url_for('@privacy-policy');
          break;
        case '@terms' :
          $url = self::getDomainUri() . url_for('@terms');
          break;
        case '@comment_auth' :
          $url = self::getDomainUri() . url_for('@comment_auth');
          break;
        case '@create_comment' :
          $url = url_for('@create_comment');
          break;
        default:
          $url = self::getProtocol();
          if (!empty($params['category'])) {
            $url .= $params['category'] . '.';
            unset($params['category']);
          } else {
            $url .= 'www.';
          }
          $url .= self::getDomain();
          // choose the appropriate url_for function
          if (substr($type, 0, 1) == '@') {
            $url .= url_for1($type, false);
          } else {
            $url .= url_for2($type, $params, false);
          }
          break;
      }
    }
    return $url;
  }

  /**
   * Get the domain name
   * 
   * @return string the domain name
   */
  public static function getDomain()
  {
    $host = $_SERVER['HTTP_HOST'];
    $domain = substr($host, strpos($host, 'betterrecipes'));
   if ($host == $domain)        // test for staging URL if we're not at the real site - ben
        $domain = substr($host, strpos($host, 'brstage'));
    if (strpos($domain, 'mixingbowl.com') !== false) {
      $domain = 'betterrecipes.com';
    }
    return $domain;
  }

  /**
   * Get the protocol
   * 
   * @return string http:// or https://
   */
  public static function getProtocol()
  {
    return !isset($_SERVER['HTTPS']) || stripos($_SERVER['HTTPS'], 'on') !== false ? 'https://' : 'http://';
  }

  public static function getDomainUri()
  {
    return self::getProtocol() . 'www.' . self::getDomain();
  }

  public static function getSigninUri($referrer = null)
  {
    return self::getDomainUri() . '/signin' . (($referrer && rtrim($referrer, '/') != self::getDomainUri()) ? '?referrer=' . urlencode($referrer) : '');
  }

  public static function getSignupUri($referrer = null)
  {
    return self::getDomainUri() . '/signup' . (($referrer && rtrim($referrer, '/') != self::getDomainUri()) ? '?referrer=' . urlencode($referrer) : '');
  }

  public static function getSignoutUri($referrer = null)
  {
    return self::getDomainUri() . '/signout' . (($referrer && rtrim($referrer, '/') != self::getDomainUri()) ? '?referrer=' . urlencode($referrer) : '');
  }

  public static function getHomepageUri($referrer = null)
  {
    return self::getDomainUri();
  }

  public static function getSubdomain($request)
  {
    $subdomain = rtrim(substr($request->getHost(), 0, strpos($request->getHost(), self::getDomain())), '.');
    return $subdomain == 'www' ? '' : $subdomain;
  }

  public static function generateCategoryArticleRecipeFriendlySlug($slug, $table, $item_id = null)
  {
    //Convert all the "'s" with "s"
    $slug = str_ireplace("'s", "s", $slug);
    //If slug is being updated, check to see if it contains a numeric value at the end of it
    //If true, then remove it and submit the slug without the numeric value
    $slug = Doctrine_Inflector::urlize($slug);
    if ($item_id) {
      $slug_parts = explode('-', $slug);
      $part_count = count($slug_parts);
      $last_part = $slug_parts[$part_count - 1];
      if (is_numeric($last_part)) {
        array_pop($slug_parts);
      }
      $slug = implode('-', $slug_parts);
    }

    //Get all similar slugs and append the inputted slug value with a numeric value based on greatest number of the slug version
    $obj_coll = array('category', 'article', 'slideshow', 'contest', 'recipe');
    foreach ($obj_coll as $obj) {
      $qstr_coll[] = "SELECT id, slug FROM $obj WHERE slug LIKE '$slug%'";
    }
    $qstr = implode(' UNION ', $qstr_coll);
    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $result = $q->execute($qstr);
    $slugs = $result->fetchAll();
    $slug_count = $result->rowCount();
    $slug_versions = array(0);
    if ($slug_count > 0) {
      foreach ($slugs as $item) {
        $item_parts = explode('-', $item['slug']);
        $item_part_count = count($item_parts);
        $last_item_part = $item_parts[$item_part_count - 1];
        if (is_numeric($last_item_part)) {
          $slug_versions[] = $last_item_part;
        }
      }
      $modified_slug = $slug . '-' . (max($slug_versions) + 1);
    } else {
      $modified_slug = $slug;
    }

    return $modified_slug;
  }

}