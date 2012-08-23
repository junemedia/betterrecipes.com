<?php

/**
 * Url functions
 */
class Microformat
{


  public static function parseInstructions($str)
  {
    $str = preg_replace("/[\n|\r]+/", "\n", $str);
    $arr = explode ("\n", $str);
    $arr = array_map(array('Microformat','paragraph'), $arr);
    return implode($arr); 
  }
  public static function paragraph($str)
  {
    return '<p>'.$str.'</p>';
  }

  public static function tableIngredients($str)
  {
    $arr = Microformat::splitIngredients($str);
    $arr = array_map(array('Microformat','wrapIngredient'), $arr);
    return  '<table class="ingredients">'.PHP_EOL.
            implode("</tr>".PHP_EOL."<tr>", $arr).
            '</table>'.PHP_EOL;
  }
  public static function wrapIngredient($arr)
  {
    extract($arr);

    if ($amount) {
      $str = '<tr itemprop="ingredient" itemscope itemtype="http://data-vocabulary.org/RecipeIngredient">'.PHP_EOL.
         '<td><span itemprop="amount">'.$amount.'</span></td>'.PHP_EOL.
         '<td>'.$name['before'].'<span itemprop="name">'.$name['name'].'</span>'.$name['after'].'</td>'.PHP_EOL.
         '</tr>';
    } else {
      $str = '<tr>'.PHP_EOL.
             '<td></td><td>'.$name['before'].'<span itemprop="ingredient">'.$name['name'].'</span>'.$name['after'].'</td>'.PHP_EOL.
             '</tr>';

    }
    return $str;
  }

  public static function splitIngredients($str)
  {
    $str = preg_replace("/[\n|\r]+/", "\n", $str);
    $str = preg_replace("/  +/", "\n", $str);
    $arr = explode ("\n", $str);
    $arr = array_map(array('Microformat','breakApart'), $arr);
    return $arr;
  }
  public static $fractions = array(
    '½' => '1/2',
    '⅓' => '1/3',
    '⅔' => '2/3',
    '¼' => '1/4',
    '¾' => '3/4',
    '⅕' => '1/5',
    '⅖' => '2/5',
    '⅗' => '3/5',
    '⅘' => '4/5',
    '⅙' => '1/6',
    '⅚' => '5/6',
    '⅛' => '1/8',
    '⅜' => '3/8',
    '⅝' => '5/8',
    '⅞' => '7/8'
  );

  public static function breakApart($str)
  {
    // pre-clean
    $str = strtr($str, Microformat::$fractions);

    // handle inch issue.  ie: 12 1/4-inch
    $str = preg_replace('/(\S*\d)[ \-]{0,1}(?:"|inch|in\.|in)/i', 'INCH:$1:INCH', $str);

    $success = preg_match(
            '/^((?:[\d\/ \-\.]|to[0-9 ]|dash|of)+(?:(?:(?:bag|box|boxes|bunch|bunches|bottle|c|cup|tbs|tablespoon|teaspoon|package|tsp|jar|clove|head|pound|lb|ounce|oz|pkg|fl|gal|hint|drop|ping|dash|tad|stick|pint|pt|qt|quart|gallon|can|slice|stalk|t)\S{0,1}[ \.]){0,1}){0,2})(.+?)$/i',
            $str,
            $m);
    if ($success) {
      $amount = $m[1];
      $name = $m[2];
      list($before,$name,$after) = Microformat::clean_name($name);
      $amount = Microformat::clean_amount($amount);
    } else {
      list($before,$name,$after) = Microformat::clean_name($str);
      $amount = '';
    }
    return array(
      'amount' => $amount,
      'name' => array(
        'before' => $before,
        'name' => $name,
        'after' => $after
      )
    );
  }


  public static function clean_amount($amount)
  {
    $amount = strtolower(trim($amount,' .-'));
    $amount = preg_replace('/\bof$/', '', $amount);
    $amount = str_replace('teaspoons', 'tsp', $amount);
    $amount = str_replace('teaspoon', 'tsp', $amount);
    $amount = str_replace('pounds', 'lb', $amount);
    $amount = str_replace('pound', 'lb', $amount);
    $amount = preg_replace('/\bc\b/', 'cup', $amount);
    $amount = preg_replace('/\bt$/', 'tsp', $amount);
    $amount = preg_replace('/\bT$/', 'Tbsp', $amount);
    $amount = str_replace('tablespoon', 'Tbsp', $amount);
    $amount = str_replace('tbs', 'Tbsp', $amount);
    $amount = str_replace('Tbspp', 'Tbsp', $amount);
    $amount = str_replace('tbsp', 'Tbsp', $amount);
    $amount = str_replace('Tbsps', 'Tbsp', $amount);
    $amount = str_replace('packages', 'pkgs', $amount);
    $amount = str_replace('package', 'pkg', $amount);
    $amount = str_replace('pints', 'pt', $amount);
    $amount = str_replace('pint', 'pt', $amount);
    $amount = str_replace('quarts', 'pkg', $amount);
    $amount = str_replace('quart', 'qt', $amount);
    $amount = str_replace('ounces', 'oz', $amount);
    $amount = str_replace('ounce', 'oz', $amount);
    $amount = str_replace(' to ', ' – ', $amount);
    $amount = preg_replace('/(\d) (\d+[^\/])/', '$1× $2', $amount);
    $fractions_flipped = array_flip(Microformat::$fractions);
    $amount = strtr($amount, $fractions_flipped);
    $fractions_regex = implode('', $fractions_flipped);
    $amount = preg_replace('/(\d)[ \-](['.$fractions_regex.'])/', '$1$2', $amount);
    return trim($amount);
  }

  public static function clean_name($name)
  {
    $name = str_replace('INCH:', '', $name);
    $name = str_replace(':INCH', '"', $name);
    $name = preg_replace('/^of\b/', '', $name);
    $name = preg_replace('/(\S)(\()/', '$1 $2', $name);
    $name = preg_replace('/(\S)(&)/', '$1 $2', $name);
    $success = preg_match('/^((?:(?:freshly|fresh|finely|ground|cooked|small|size|boxes|container|instant|canned|bottled|peeled|extra|all|purpose|melted|cubed|powdered|granulated|minced|uncooked|quick|cooking|trimmed|halved|blanched|medium|large|stewed|sprigs|whole|new|grated|shredded|diced|sliced|prepared|creamy|chopped|deli|thin|thinly|refrigerated|lean|of|pieces|chunks|or|and|&|lg\.{0,1}|me{0,1}d\.{0,1}|sm\.{0,1}) )*)(.+?)((?:, .+|\(.+\)|to taste| at .+| for .+)*)$/i', $name, $m);
    if (!$success) {
      return array('', $name, '');
    }
    $before = $m[1] ? Microformat::correct_caps(trim($m[1])).' ' : '';
    $name = Microformat::correct_caps(trim($m[2]));
    $after = $m[3] ? ', '.strtolower(trim($m[3] , '(),')) : '';

    $flip_fractions = array_flip(Microformat::$fractions);
    $before = strtr($before, $flip_fractions);
    $after = strtr($after, $flip_fractions);

    return array($before, $name, $after);
  }

  public static function correct_caps($str) 
  {
    $str = mb_convert_case($str, MB_CASE_LOWER, "UTF-8");
    $str = ucwords($str);
    $str = preg_replace('/\bOr\b/', 'or', $str);
    $str = preg_replace('/\bAnd\b/', '&', $str);
    $str = preg_replace('/\bOf\b/', 'of', $str);
    $str = preg_replace('/\bA\b/', 'a', $str);
    return trim($str);
  }

  // This function currently doesn't do anything. It is just a wrapper in case in the future if we want to add this functionality  
  public static function correct_sentence($str) 
  {
    return $str;
  }

  public static function correct_spaces($str) 
  {
    if (is_array($str))
      return $str;
    $str = preg_replace('/ {2,}/', ' ', $str);
    return $str;
  }

  public static function duration($a)
  {
    foreach ($a as &$t){
      if ($t >= 60) {
        $h = floor($t / 60);
        $m = $t - ($h*60);
        if ($m == 0)
          $t = 'PT'.$h.'H';
        else
          $t = 'PT'.$h.'H'.$m.'M';
      } else {
        $m = $t;
        $t = 'PT'.$m.'M';
      }
    }
    return $a;
  }

  public static function duration_to_pretty($d)
  {
    if (!preg_match_all('/(\d+)(H|M)/', $d, $m, PREG_SET_ORDER))
      return '';

    $buf = '';

    foreach ($m as $n) {
      $buf .= $n[1].' ';
      if ($n[2] == 'H') {
        if ($n[1] == 1) {
          $buf .= 'hour ';
        } else {
          $buf .= 'hours ';
        }
      } elseif ($n[2] == 'M') {
        if ($n[1] == 1) {
          $buf .= 'minute ';
        } else {
          $buf .= 'minutes ';
        }
      }
    }

    return trim($buf);
  }

  public static function times($o)
  {
    $prep = Microformat::parse_time($o->getPreptime());
    $cook = Microformat::parse_time($o->getCooktime());
    $total = Microformat::parse_time($o->getTotaltime());

    if (!$prep && !$cook && !$total) {
      return array(0,0,0);
    }

    // Perfect Case Scenario: everything adds up
    if ($prep + $cook == $total) {
      return 
          Microformat::duration(
            array($prep,$cook,$total)
          );
    }

    // Total Time is missing
    if ($prep && $cook && !$total) {
      return 
          Microformat::duration(
            array($prep,$cook,$prep+$cook)
          );
    }

    // Cook Time is missing
    if ($prep && !$cook && $total) {
      return 
          Microformat::duration(
            array($prep,$total-$prep,$total)
          );
    }

    // Prep Time is missing
    if (!$prep && $cook && $total) {
      return 
          Microformat::duration(
            array($total-$cook,$cook,$total)
          );
    }

    // Prep Time + Cook Time != Total Time
    if ($prep + $cook != $total) {
      return 
          Microformat::duration(
            array($prep,$cook,$prep+$cook)
          );
    }

    return array(0,0,0);
  }


  public static function parse_time($t)
  {
    // given a string format of minutes and hours
    // return # of minutes

    $t = strtolower($t);

    $minutes = 0;
    // add minutes
    $success = preg_match(
      '/(\d+)\s*(min)/',
      $t,
      $m
      );
    if ($success) {
      $minutes += $m[1];
    }
    // add any hours
    $success = preg_match(
      '/(\d+)\s*(hour|hr)/',
      $t,
      $m
      );
    if ($success) {
      $minutes += $m[1]*60;
    }
    return $minutes;
  }

}
