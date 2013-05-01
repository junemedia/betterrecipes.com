<?php

/**
 * Search and Replace Library
 */
class SearchReplace
{

  public static function run($str, $limit=false)
  {

    # set a proper limit for preg_replace
    if (! (int)$limit > 0) {
      $limit = sfConfig::get('app_searchreplace_limit');
      if (! (int)$limit > 0) {
        $limit = -1;
      }
    }

    $find = array();
    $repl = array();
    $config = sfConfig::get('app_searchreplace_patterns');

    # build $find and $repl arrays for use with preg_replace
    foreach ($config as $c) {
      $find[] = $c['find'];
      $repl[] = $c['repl'];
    }

    return preg_replace($find, $repl, $str, $limit);
  }

}
