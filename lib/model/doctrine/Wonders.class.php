<?php

/**
 * Wonders
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    betterrecipes
 * @subpackage model
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Wonders extends BaseWonders
{
	
	public function getImgSrc($whichImage, $size='400x300', $absolute = false)
	{
	  	switch ($whichImage) {
	  		case 'one' :
	  			$img = $this->getSlotOneImg();
	  		break;
	  		case 'two' :
	  			$img = $this->getSlotTwoImg();
	  		break;
	  		case 'three' :
	  			$img = $this->getSlotThreeImg();
	  		break;
	  		case 'four' :
	  			$img = $this->getSlotFourImg();
	  		break;
	  		
	  		case 'five' :
	  			$img = $this->getSlotFiveImg();
	  		break;
	  	}
	    if (!is_null($img)) {
	      $config = sfConfig::get('app_uploads_photo');
	      return Toolkit::getFileUrl($config['dir'], $img, $size, $absolute);
	    }
	}
	
	public function processFileOne() {
    if (!$this->getSlotOneImg())
      return;
    $image_config = sfConfig::get('app_uploads_photo', array('dir' => sfConfig::get('sf_upload_dir').'/photo'));
    $path = $image_config['dir'].'/';
    $original = sfConfig::get('app_uploads_tmp').'/'.$this->getSlotOneImg();
    $md5sum = md5_file($original);
    $ext = explode('.', $original);
    $ext = '.'.array_pop($ext);
    $new_name = $md5sum.strtolower($ext);
    $new_path = Toolkit::getFilePath($path, $new_name);
    @mkdir($new_path, 0777, true);
    $new = $new_path.$new_name;
    if (is_file($new))
      unlink($new);
    @rename($original, $new);
    $this->setSlotOneImg($new_name);
    $this->save();
    $sizes = $image_config['sizes'];
    Toolkit::resizeImages($path, $new_name, $sizes);
  }
  
  public function processFileTwo() {
    if (!$this->getSlotTwoImg())
      return;
    $image_config = sfConfig::get('app_uploads_photo', array('dir' => sfConfig::get('sf_upload_dir').'/photo'));
    $path = $image_config['dir'].'/';
    $original = sfConfig::get('app_uploads_tmp').'/'.$this->getSlotTwoImg();
    $md5sum = md5_file($original);
    $ext = explode('.', $original);
    $ext = '.'.array_pop($ext);
    $new_name = $md5sum.strtolower($ext);
    $new_path = Toolkit::getFilePath($path, $new_name);
    @mkdir($new_path, 0777, true);
    $new = $new_path.$new_name;
    if (is_file($new))
      unlink($new);
    @rename($original, $new);
    $this->setSlotTwoImg($new_name);
    $this->save();
    $sizes = $image_config['sizes'];
    Toolkit::resizeImages($path, $new_name, $sizes);
  }
  
  public function processFileThree() {
    if (!$this->getSlotThreeImg())
      return;
    $image_config = sfConfig::get('app_uploads_photo', array('dir' => sfConfig::get('sf_upload_dir').'/photo'));
    $path = $image_config['dir'].'/';
    $original = sfConfig::get('app_uploads_tmp').'/'.$this->getSlotThreeImg();
    $md5sum = md5_file($original);
    $ext = explode('.', $original);
    $ext = '.'.array_pop($ext);
    $new_name = $md5sum.strtolower($ext);
    $new_path = Toolkit::getFilePath($path, $new_name);
    @mkdir($new_path, 0777, true);
    $new = $new_path.$new_name;
    if (is_file($new))
      unlink($new);
    @rename($original, $new);
    $this->setSlotThreeImg($new_name);
    $this->save();
    $sizes = $image_config['sizes'];
    Toolkit::resizeImages($path, $new_name, $sizes);
  }
  
  public function processFileFour() {
    if (!$this->getSlotFourImg())
      return;
    $image_config = sfConfig::get('app_uploads_photo', array('dir' => sfConfig::get('sf_upload_dir').'/photo'));
    $path = $image_config['dir'].'/';
    $original = sfConfig::get('app_uploads_tmp').'/'.$this->getSlotFourImg();
    $md5sum = md5_file($original);
    $ext = explode('.', $original);
    $ext = '.'.array_pop($ext);
    $new_name = $md5sum.strtolower($ext);
    $new_path = Toolkit::getFilePath($path, $new_name);
    @mkdir($new_path, 0777, true);
    $new = $new_path.$new_name;
    if (is_file($new))
      unlink($new);
    @rename($original, $new);
    $this->setSlotFourImg($new_name);
    $this->save();
    $sizes = $image_config['sizes'];
    Toolkit::resizeImages($path, $new_name, $sizes);
  }
  
  public function processFileFive() {
    if (!$this->getSlotFiveImg())
      return;
    $image_config = sfConfig::get('app_uploads_photo', array('dir' => sfConfig::get('sf_upload_dir').'/photo'));
    $path = $image_config['dir'].'/';
    $original = sfConfig::get('app_uploads_tmp').'/'.$this->getSlotFiveImg();
    $md5sum = md5_file($original);
    $ext = explode('.', $original);
    $ext = '.'.array_pop($ext);
    $new_name = $md5sum.strtolower($ext);
    $new_path = Toolkit::getFilePath($path, $new_name);
    @mkdir($new_path, 0777, true);
    $new = $new_path.$new_name;
    if (is_file($new))
      unlink($new);
    @rename($original, $new);
    $this->setSlotFiveImg($new_name);
    $this->save();
    $sizes = $image_config['sizes'];
    Toolkit::resizeImages($path, $new_name, $sizes);
  }



}
