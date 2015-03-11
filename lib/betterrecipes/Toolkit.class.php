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
   * Custom Resize image
   *
   * @param string $path
   * @param string $name
   * @param string $size
   * @return string
   */
  public static function customResizeImage($base_path, $name, $size,$zoomCrop=3,$quality=80,$effect=0) {
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

	// Nothing to do if cache file exists
	if (is_file($new)) {
		return $new;
	}

	$details = getimagesize($original);
	$mimeType = $details['mime'];

	// Open the existing image
	$image = '';
	if (stristr($mimeType, 'gif')) {
		$image = imagecreatefromgif($original);
	} elseif (stristr($mimeType, 'jpeg') || stristr($mimeType, 'jpg')) {
		@ini_set('gd.jpeg_ignore_warning', 1);
		$image = imagecreatefromjpeg($original);
	} elseif (stristr($mimeType, 'png')) {
		$image = imagecreatefrompng($original);
	}
	if (!$image) {
		return false;
	}

	// Get original width and height
	$srcWidth = imagesx($image);
	$srcHeight = imagesy($image);

	// Generate new w/h if not provided
	if ($width && !$height) {
		$height = $srcHeight * ($width / $srcWidth);
	} elseif ($height && !$width) {
		$width = $srcWidth * ($height / $srcHeight);
	} elseif (!$width && !$height) {
		$width = $srcWidth;
		$height = $srcHeight;
	}

	// Create a new true color image
	$canvas = imagecreatetruecolor($width, $height);
	imagealphablending ($canvas, false);
	imagesavealpha ($canvas, true);
	$fillRGB = self::hexToRgb('FFFFFF');
	$transparency = 127;
	$fill = imagecolorallocatealpha($canvas, $fillRGB[0], $fillRGB[1], $fillRGB[2], $transparency);
	imagefilledrectangle($canvas, 0, 0, $width, $height, $fill);

	// Zoom and crop image
	switch ($zoomCrop) {

		// Copy and resize part of an image with resampling
		case 0:
			imagecopyresampled($canvas, $image, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
			break;

		// Fit image to dimensions
		case 1:

			$imWidth = $srcWidth;
			$imHeight = $srcHeight;

			// Constrain width and height, scaling proportionally
			if ($imWidth > $width) {
				$imHeight = floor($imHeight * ($width / $imWidth));
				$imWidth = $width;
			}
			if ($imHeight > $height) {
				$imWidth = floor($imWidth * ($height / $imHeight));
				$imHeight = $height;
			}

			// Calculate x and y coordinate in destination
			$destX = round(($width - $imWidth) / 2);
			$destY = round(($height - $imHeight) / 2);

			imagecopyresampled($canvas, $image, $destX, $destY, 0, 0, $imWidth, $imHeight, $srcWidth, $srcHeight);
			break;

		// Take a chunk of the specified size from the center of the image, and automatically get a bit that isn't white.
		case 2:
			$offset = 10;
			do {
				imagecopyresampled($canvas, $image, 0, 0, $offset, (($srcHeight/2)-($height/2)), $width, $height, $width, $height);
				$notGoodEnough = false;
				$topLeftColor = imagecolorat($canvas,1,1);
				$r = ($topLeftColor >> 16) & 0xFF;
				$g = ($topLeftColor >> 8) & 0xFF;
				$b = $topLeftColor & 0xFF;
				if (($r+$g+$b) > 740) {
					$notGoodEnough = true;
					$offset += 180;
				} else {
					$notGoodEnough = false;
				}
			} while ($notGoodEnough && ($offset < ($srcWidth - $width)));
			break;

		// Crop image to dimensions
		case 3:

			$srcX = $srcY = 0;
			$imWidth = $srcWidth;
			$imHeight = $srcHeight;

			// Calculate ratios for comparison
			$cmpX = $srcWidth  / $width;
			$cmpY = $srcHeight / $height;

			// Calculate x or y coordinate and width or height of source
			if ($cmpX > $cmpY) {
				$imWidth = round(($srcWidth / $cmpX * $cmpY));
				$srcX = round(($srcWidth - ($srcWidth / $cmpX * $cmpY)) / 2);
			} elseif ($cmpY > $cmpX) {
				$imHeight = round(($srcHeight / $cmpY * $cmpX));
				$srcY = round(($srcHeight - ($srcHeight / $cmpY * $cmpX)) / 2);
			}

			imagecopyresampled($canvas, $image, 0, 0, $srcX, $srcY, $width, $height, $imWidth, $imHeight);
			break;
	}

	switch ($effect) {
		// Gaussian Blur
		case '1':
			for ($a=0; $a<20; $a++) {
				imagefilter($canvas, IMG_FILTER_GAUSSIAN_BLUR);
			}
			imagefilter ($canvas, IMG_FILTER_COLORIZE, 255, 255, 255, 10);
		break;
	}

	$returnType = 'jpeg';
	
	if (stristr($mimeType, 'png')) {
		$returnType = 'png';
	}

	// Output image to cache
	$ret = '';//$this->_writeCacheFile($canvas, $cacheDir, $cachePath, $quality, $returnType);
	// Create cache directory if it doesn't exist
	if(!is_dir($cacheDir)) {
		@mkdir($cacheDir, 0700, true);
	}

	// Create cache file
	touch($new);
	chmod($new, 0600);

	// Write image to cache file
	switch ($returnType) {
		case "png" :
			$ret = imagepng($canvas, $new, (9-floor(($quality-1)/10)));
		break;
		default:
			$ret = imagejpeg($canvas, $new, $quality);
		break;
	}

	// Remove image from memory
	imagedestroy($canvas);

	// Return cache path on succes, false otherwise
	return $ret ? $new : false;
  }
	
  public static function hexToRgb($hex)
	{
        // Strip off any leading #
        $hex = str_replace('#', '', $hex);

        // Break into hex 3-tuple
        $cutpoint = ceil(strlen($hex) / 2)-1;
        $rgb = explode(':', wordwrap($hex, $cutpoint, ':', $cutpoint), 3);

        // Convert each tuple to decimal
        foreach ($rgb as $k => &$v) {
        	if (strlen($v) < 2) {
        		$v = str_repeat($v, 2);
        	}
        	$v = hexdec($v);
        }

        return $rgb;
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
