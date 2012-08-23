<?php

class Toolkit {
  const FILE_SIZE_ORIGINAL = 'original';

  /**
   * Returns the path to an uploaded file
   *
   * @param string $base_path the base path to start from
   * @param string $name      the name of the file
   * @param string $size      the dimensions in the format: widthxheight, ie, 440x440 | 440x | x440
   * @return string
   */
  public static function getFilePath($base_path, $name, $size = self::FILE_SIZE_ORIGINAL) {
    $levels = sfConfig::get('app_uploads_levels', 2);

    $path = rtrim($base_path, '/').'/'.$size.'/';

    for ($i = 0; $i < $levels; $i++) {
      $path .= substr($name, $i, 1).'/';
    }

    return $path;
  }

  /**
   * Get file's URL
   * 
   * @param string $base_path
   * @param string $name
   * @param string $size
   * @param boolean $absolute
   * @return string 
   */
  public static function getFileUrl($base_path, $name, $size = self::FILE_SIZE_ORIGINAL, $absolute = false) {
    return str_replace(sfConfig::get('sf_web_dir'), $absolute ? 'http://'.$_SERVER['HTTP_HOST'] : '', Toolkit::getFilePath($base_path, $name, $size).$name);
  }

  /**
   * Resize image
   *
   * @param string $path
   * @param string $name
   * @param string $size
   * @return string
   */
  public static function resizeImage($base_path, $name, $size) {
    if ($size == self::FILE_SIZE_ORIGINAL) {
      return self::getFilePath($base_path, $name).$name;
    } else {
      if (!strstr($size, 'x')) {
        throw new sfException('Invalid $size argument passed to loToolkit::resizeImage(): '.$size);
      }
      list($width, $height) = explode('x', $size);
    }

    $original = self::getFilePath($base_path, $name).$name;

    if (!is_file($original))
      return null;

    $path = self::getFilePath($base_path, $name, $size);

    @mkdir($path, 0777, true);

    $new = $path.$name;

    $xheight = 'x'.$height;

    $command = sfConfig::get('app_resize_command', '/srv/bin/resize')." -s {$width}x{$height} $original $new";

    $fs = new sfFilesystem();
    $fs->execute($command);

    return $new;
  }

  /**
   * Batch resize images
   *
   * @param string $path
   * @param string $name
   * @param array|string $sizes
   */
  public static function resizeImages($path, $name, $sizes) {
    if (!is_array($sizes))
      $sizes = array($sizes);
    foreach ($sizes as $size) {
      self::resizeImage($path, $name, $size);
    }
  }

  /**
   * Retrieves the extension for a giver mime type
   *
   * @param string $mime
   * @param boolean $dot
   * @return string
   */
  public static function mimeTypeToExtension($mime, $dot = false) {
    $flipped = array_flip(self::$mim_types);
    if (array_key_exists($mime, $flipped)) {
      return ($dot ? '.' : '').$flipped[$mime];
    }
    return null;
  }

  /**
   * Retrieves the mime type for a given extension
   *
   * @param string $extension
   * @return string
   */
  public static function extensionToMimeType($extension) {
    if (array_key_exists($extension, self::$mim_types)) {
      return self::$mim_types[$extension];
    }
    return null;
  }

  protected static $mim_types = array(
      'htm' => 'text/html',
      'shtml' => 'text/html',
      'html' => 'text/html',
      'css' => 'text/css',
      'xml' => 'text/xml',
      'rss' => 'text/xml',
      'gif' => 'image/gif',
      'jpeg' => 'image/jpeg',
      'jpg' => 'image/jpeg',
      'js' => 'application/x-javascript',
      'json' => 'application/json',
      'atom' => 'application/atom+xml',
      'mml' => 'text/mathml',
      'txt' => 'text/plain',
      'jad' => 'text/vnd.sun.j2me.app-descriptor',
      'wml' => 'text/vnd.wap.wml',
      'htc' => 'text/x-component',
      'png' => 'image/png',
      'tif' => 'image/tiff',
      'tiff' => 'image/tiff',
      'wbmp' => 'image/vnd.wap.wbmp',
      'ico' => 'image/x-icon',
      'jng' => 'image/x-jng',
      'bmp' => 'image/x-ms-bmp',
      'svg' => 'image/svg+xml',
      'war' => 'application/java-archive',
      'ear' => 'application/java-archive',
      'jar' => 'application/java-archive',
      'hqx' => 'application/mac-binhex40',
      'doc' => 'application/msword',
      'pdf' => 'application/pdf',
      'eps' => 'application/postscript',
      'ps' => 'application/postscript',
      'ai' => 'application/postscript',
      'rtf' => 'application/rtf',
      'xls' => 'application/vnd.ms-excel',
      'ppt' => 'application/vnd.ms-powerpoint',
      'wmlc' => 'application/vnd.wap.wmlc',
      'xhtml' => 'application/vnd.wap.xhtml+xml',
      'cco' => 'application/x-cocoa',
      'jardiff' => 'application/x-java-archive-diff',
      'jnlp' => 'application/x-java-jnlp-file',
      'run' => 'application/x-makeself',
      'pm' => 'application/x-perl',
      'pl' => 'application/x-perl',
      'prc' => 'application/x-pilot',
      'pdb' => 'application/x-pilot',
      'rar' => 'application/x-rar-compressed',
      'rpm' => 'application/x-redhat-package-manager',
      'sea' => 'application/x-sea',
      'swf' => 'application/x-shockwave-flash',
      'sit' => 'application/x-stuffit',
      'tcl' => 'application/x-tcl',
      'tk' => 'application/x-tcl',
      'der' => 'application/x-x509-ca-cert',
      'pem' => 'application/x-x509-ca-cert',
      'crt' => 'application/x-x509-ca-cert',
      'xpi' => 'application/x-xpinstall',
      'zip' => 'application/zip',
      'bin' => 'application/octet-stream',
      'exe' => 'application/octet-stream',
      'dll' => 'application/octet-stream',
      'deb' => 'application/octet-stream',
      'dmg' => 'application/octet-stream',
      'iso' => 'application/octet-stream',
      'img' => 'application/octet-stream',
      'msi' => 'application/octet-stream',
      'msp' => 'application/octet-stream',
      'msm' => 'application/octet-stream',
      'mid' => 'audio/midi',
      'midi' => 'audio/midi',
      'kar' => 'audio/midi',
      'mp3' => 'audio/mpeg',
      'ra' => 'audio/x-realaudio',
      'ogg' => 'audio/ogg',
      'oga' => 'audio/ogg',
      '3gpp' => 'video/3gpp',
      '3gp' => 'video/3gpp',
      'mpeg' => 'video/mpeg',
      'mpg' => 'video/mpeg',
      'm4v' => 'video/mp4',
      'mp4' => 'video/mp4',
      'ogv' => 'video/ogg',
      'mov' => 'video/quicktime',
      'flv' => 'video/x-flv',
      'mng' => 'video/x-mng',
      'asx' => 'video/x-ms-asf',
      'asf' => 'video/x-ms-asf',
      'wmv' => 'video/x-ms-wmv',
      'avi' => 'video/x-msvideo',
      'eot' => 'application/vnd.ms-fontobject',
      'ttf' => 'font/ttf',
      'otf' => 'font/otf'
  );

  public static function detectZipcode() {
    include_once('geoipzip.inc.php');
    if (function_exists('geoipzip')) {
      $zip = @geoipzip(self::detectIp());
      return $zip;
    }
    return '';
  }

  public static function detectLocation() {
    include_once('geoipzip.inc.php');
    if (function_exists('geoipzip')) {
      $geo = @geoip_record_by_name(self::detectIp());
      return $geo;
    }
    return '';
  }

  public static function detectIp() {
    return isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
  }

  public static function ipToInteger($ip) {
    $long = ip2long($ip);
    return $long == -1 || $long === false ? 0 : sprintf("%u", $long);
  }

  public static function getBeginningOfToday() {
    return date('Y-m-d').' 00:00:00';
  }

  public static function getEndOfToday() {
    return date('Y-m-d').' 23:59:59';
  }

  public static function getTimeToEndOfToday() {
    return time(self::getEndOfToday()) - time();
  }

  /**
   * Sends a email via MarketFirst
   * 
   * @param User $user
   * @param array $params
   * @return int the number of emails sent
   */
  public static function sendMFEmail(User $user, array $params = array()) {
    $url = 'http://info.local.com/mk/submit/LC_PHOTO?_JS=T';

    $params = array_merge(array(
        'FIRST_NAME' => $user->getFirstName(),
        'LAST_NAME' => $user->getLastName(),
        'PRIMARY_EMAIL_ADDR' => $user->getEmailAddress(),
        'Your_Photo_URL' => '',
        'Other_Photo_URL' => '',
        'Contest_Name' => '',
        'Contest_Link' => '',
        'Number_of_votes' => '',
        'Location' => ''
            ), $params);

    foreach ($params as $k => $v) {
      $url .= "&$k=".rawurlencode($v);
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
  }

}
