<?

/*
 * AdCopy Class - based on class from Photofaves
 * Authored By: Larry Laski
 */

class AdCopy {
  
 /* //STAGING KEYS
  public static $staging_challengeKey = '-wmEsCXIKwYpeg2POtijGgnWFQD6E71a';
  public static $staging_verificationKey = 'IWqaeDDDNoYlAuVkq8wyW0SO7TZoWuTJ';
  public static $staging_hashKey = 'D4XnBCewrif27lKxOZOzN2Y5s-dqY5fz';
  //PROD KEYS
  public static $challengeKey = 'Vh1y5TEidP5lYG52HkgMMsVkHSzCxb-1';
  public static $verificationKey = '9TPC5aqQ8.VIsGUsK55ljY.EoApJH7Rh';
  public static $hashKey = 'UryBhEva5GhYTzZo-NY7WsDikB6kPl-D';*/

  public static function getSolveMediaHtml($challengeKey) {
    require_once(sfConfig::get('sf_lib_dir')."/vendor/AdCopy/adcopylib.php"); //include the AdCopy library
    return solvemedia_get_html($challengeKey);
  }

}

?>