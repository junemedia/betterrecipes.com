<?php

/**
 * ImageType
 * 
 * @package betterrecipes
 * @author Toros Tarpinyan <ttarpinyan@resolute.com>
 */
class ImageType extends sfValidatorFile
{
  protected $extension_map = array('image/gif' => 'gif', 'image/jpeg' => 'jpg', 'image/jpg' => 'jpg', 'image/png' => 'png');

  protected function configure($options = array(), $messages = array())
  {
    parent::configure(array('mime_types' => array('image/gif', 'image/jpeg', 'image/jpg', 'image/png')));
  }

  public function detectImageType($file)
  {
    $ext = explode('.', $file);
    $fallback = array_pop($ext);
    return @parent::getMimeType($file, $fallback);
  }

  public function getExtention($file)
  {
    $type = $this->detectImageType($file);
    return $this->extension_map[$type];
  }

}