<?php

class Utilities
{

  public static function getToday()
  {
    $date_range['start'] = date('Y-m-d') . ' 00:00:00';
    $date_range['end'] = date('Y-m-d') . ' 23:59:59';
    return $date_range;
  }

  public static function getThisWeek()
  {
    $date_range['end'] = date('Y-m-d') . ' 23:59:59';
    $date_range['start'] = date('Y-m-d H:i:s', (strtotime($date_range['end']) - 60 * 60 * 24 * 7));
    return $date_range;
  }

  public static function getDateRange()
  {
    $date_range['end'] = date('Y-m-d');
    $date_range['start'] = date('Y-m-d H:i:s', (strtotime($date_range['end']) - 60 * 60 * 24 * sfConfig::get('app_trending_days_back')));
    return $date_range;
  }

  public static function getDayRange($date)
  {
    $date_range['start'] = self::getStartDate($date);
    $date_range['end'] = self::getEndDate($date);
    return $date_range;
  }

  public static function getStartDate($date)
  {
    $date_parts = explode('/', $date);
    return $date_parts[2] . '-' . $date_parts[0] . '-' . $date_parts[1] . ' 00:00:00';
  }

  public static function getEndDate($date)
  {
    $date_parts = explode('/', $date);
    return $date_parts[2] . '-' . $date_parts[0] . '-' . $date_parts[1] . ' 23:59:59';
  }

  public static function addSlashesToDate($date)
  {
    return substr($date, 0, 2) . '/' . substr($date, 2, 2) . '/' . substr($date, 4, 4);
  }

  public static function convertIsoToUnixTimeStamp($date)
  {
    return date('Y-m-d H:i:s', strtotime($date) + date('O') / 100 * 60 * 60);
  }

  public static function convertToStandardDate($date)
  {
    return date('F j, Y, g:i A', strtotime($date) + date('O') / 100 * 60 * 60);
  }

  public static function convertUnixToHuman($unix)
  {
    return date('F j, Y, g:i A', (int) $unix);
  }

  public static function getServerTimeZoneOffset()
  {
    //return date("O") / 100 * 60 * 60; // Seconds from GMT
    return date("O"); // Seconds from GMT
  }

  public static function date_local($date)
  {
    return date('Y-m-d H:i:s', strtotime($date) + date('Z') * 60 * 60);
  }

  public static function getWeekRange($date = null)
  {
    if (!$date) {
      $date = date('Y-m-d');
    }
    $ts = strtotime($date);
    $start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
    return array(date('Y-m-d', $start) . ' 00:00:00',
      date('Y-m-d', strtotime('next saturday', $start)) . ' 23:59:59');
  }

  public static function dateSplit($date)
  {
    list($year, $month, $day) = preg_split('/[\/\.-]/', $date);
    return $month . "/" . $day;
  }

  public static function genderLabel($arg)
  {
    $g = (int) $arg;
    $label = '';
    if ($g == 1) {
      $label = 'Female';
    } else {
      $label = 'Male';
    }
    return $label;
  }

  public static function getLastUrlSegment($arg, $strip = false)
  {
    $slug = '';
    foreach (explode("/", $arg) as $segment) {
      if (trim($segment) != "") {
        $slug = $segment;
      }
    }
    if ($strip) {
      $str1 = str_replace('.', '', $slug);
      //$s = preg_replace('|[^a-zA-Z0-9~_\-.=!;,:@$*^`()\x80-\xFF ]|', '', $slug);
      $str2 = preg_replace('/post_id=(?<digit>\d+)/', '', $str1);
      $str3 = preg_replace('/\?#(?<digit>\d+)/', '', $str2);
      return $str3;
    } else {
      return $slug;
    }
  }

  public static function getLast2Segments($arg)
  {
    $t = array();
    $slug = '';
    foreach (explode("/", $arg) as $segment) {
      if (trim($segment) != "") {
        array_push($t, $segment);
      }
    }
    $count = count($t) - 1;
    $seg1 = $t[$count - 1];
    $seg2 = $t[$count];
    return array('year' => $seg1, 'month' => $seg2);
  }

  public static function getBackgroundImageUrl($arg)
  {
    $matches = array();
    if (preg_match('/background-image:\s*url\(\s*([\'"]*)(?P<file>[^\1]+)\1\s*\)/i', $arg, $matches)) {
      return $matches['file'];
    }
  }

  public static function getFileName($arg)
  {
    $path_parts = pathinfo($arg);
    return $path_parts['filename'];
  }

  public static function getDirectoryName($arg)
  {
    $path_parts = pathinfo($arg);
    return $path_parts['dirname'];
  }

  public static function activityLabel($arg)
  {
    $s = '';
    switch ($arg) {
      case 'blog_post' :
        $s = ' posted a journal entry ';
        break;
      case 'comment' :
        $s = ' posted a comment ';
        break;
      case 'photo' :
        $s = ' uploaded a photo ';
        break;
      case 'video' :
        $s = ' uploaded a video ';
        break;
      case 'forum_thread' :
        $s = ' posted to the discussion ';
        break;
      case 'forum_post' :
        $s = ' commented on the discussion ';
        break;
    }
    return $s;
  }

  public static function getDailyDishPostUrl($arg)
  {
    $raw = str_replace('http://www.betterrecipes.com/blogs/daily-dish', '', $arg);
    $slug = array();
    foreach (explode("/", $raw) as $segment) {
      if (trim($segment) != "") {
        array_push($slug, $segment);
      }
    }
    return $slug;
  }

  public static function getFirstUrlSegment($arg)
  {
    $slug = array();
    $raw = str_replace('http://social.betterrecipes.com', '', $arg);
    foreach (explode("/", $raw) as $segment) {
      if (trim($segment) != "") {
        array_push($slug, $segment);
      }
    }
    return $slug[0];
  }

  public static function joinGroupMessage($group_name, $group_url, $from = null)
  {
    $s = '';
    $s .= (!is_null($from)) ? $from . 'would like to invite you to join the ' . $group_name . ' group on BetterRecipes.com' . "\r\n" : 'You have been invited join the ' . $group_name . ' group on BetterRecipes.com' . "\r\n";
    $s .= 'To join this group, follow this link ' . $group_url . "\r\n";
    return $s;
  }

  public static function correctGroupCategory($cat)
  {
    if ($cat == 'recipes') {
      return 'groups';
    } else {
      return $cat;
    }
  }

  static public function slugify($str, $separator = 'dash', $lowercase = FALSE)
  {
    if ($separator == 'dash') {
      $search = '_';
      $replace = '-';
    } else {
      $search = '-';
      $replace = '_';
    }

    $trans = array(
      '&\#\d+?;' => '',
      '&\S+?;' => '',
      '\s+' => $replace,
      '[^a-z0-9\-\._]' => '',
      $replace . '+' => $replace,
      $replace . '$' => $replace,
      '^' . $replace => $replace,
      '\.+$' => ''
    );

    $str = strip_tags($str);

    foreach ($trans as $key => $val) {
      $str = preg_replace("#" . $key . "#i", $val, $str);
    }

    if ($lowercase === TRUE) {
      $str = strtolower($str);
    }

    return trim(stripslashes($str));
  }

  static public function removeSlug($str, $separator = 'dash', $uppercase = FALSE)
  {
    if ($separator == 'dash') {
      $search = '-';
      $replace = ' ';
    } else {
      $search = '_';
      $replace = ' ';
    }
    $text = str_replace($search, $replace, $str);
    if ($uppercase == TRUE) {
      $text = strtoupper($text);
    }
    return trim($text);
  }

  /**
   * truncateHtml can truncate a string up to a number of characters while preserving whole words and HTML tags
   *
   * @param string $text String to truncate.
   * @param integer $length Length of returned string, including ellipsis.
   * @param string $ending Ending to be appended to the trimmed string.
   * @param boolean $exact If false, $text will not be cut mid-word
   * @param boolean $considerHtml If true, HTML tags would be handled correctly
   *
   * @return string Trimmed string.
   */
  public static function truncateHtml($s, $l, $e = '...', $isHTML = true)
  {
    $i = 0;
    $tags = array();
    if ($isHTML) {
      preg_match_all('/<[^>]+>([^<]*)/', $s, $m, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
      foreach ($m as $o) {
        if ($o[0][1] - $i >= $l)
          break;
        $t = substr(strtok($o[0][0], " \t\n\r\0\x0B>"), 1);
        if ($t[0] != '/')
          $tags[] = $t;
        elseif (end($tags) == substr($t, 1))
          array_pop($tags);
        $i += $o[1][1] - $o[0][1];
      }
    }
    return substr($s, 0, $l = min(strlen($s), $l + $i)) . (count($tags = array_reverse($tags)) ? '</' . implode('></', $tags) . '>' : '') . (strlen($s) > $l ? $e : '');
  }

  /**
   * Translates a camel case string into a string with underscores (e.g. firstName -&gt; first_name)
   * @param    string   $str    String in camel case format
   * @return    string            $str Translated into underscore format
   */
  public static function fromCamelCase($str)
  {
    $str[0] = strtolower($str[0]);
    $func = create_function('$c', 'return "_" . strtolower($c[1]);');
    return preg_replace_callback('/([A-Z])/', $func, $str);
  }

  /**
   * Translates a string with underscores into camel case (e.g. first_name -&gt; firstName)
   * @param    string   $str                     String in underscore format
   * @param    bool     $capitalise_first_char   If true, capitalise the first char in $str
   * @return   string                              $str translated into camel caps
   */
  public static function toCamelCase($str, $capitalise_first_char = false)
  {
    if ($capitalise_first_char) {
      $str[0] = strtoupper($str[0]);
    }
    $func = create_function('$c', 'return strtoupper($c[1]);');
    return preg_replace_callback('/_([a-z])/', $func, $str);
  }
  
  public static function showDate($date) 
	{
		$stf = 0;
		$cur_time = time();
		$diff = $cur_time - strtotime($date);
		$phrase = array('second','minute','hour','day','week','month','year','decade');
		$length = array(1,60,3600,86400,604800,2630880,31570560,315705600);
		for($i =sizeof($length)-1; ($i >=0)&&(($no =  $diff/$length[$i])<=1); $i--); if($i < 0) $i=0; $_time = $cur_time  -($diff%$length[$i]);
		$no = floor($no); if($no <> 1) $phrase[$i] .='s'; $value=sprintf("%d %s ",$no,$phrase[$i]);
		if(($stf == 1)&&($i >= 1)&&(($cur_tm-$_time) > 0)) $value .= time_ago($_time);
		return $value.' ago ';
	}
	
	// note: use this function to determine when to show the user activity completed log in the right rail, as per stupid ET#6800
	public static function userLogCompletedIncrement()
	{
	  if ( $views = sfContext::getInstance()->getUser()->getAttribute('totalLogViews') ) {
	      if ( $views > 5 ) {
		      $views = 1;
	      } else {
		      $views++;
	      }
	      sfContext::getInstance()->getUser()->setAttribute('totalLogViews', $views);
      } else {
      	  $views = 1;
	      sfContext::getInstance()->getUser()->setAttribute('totalLogViews', $views);
      }
      return $views;
	}

}
