<?
class sfValidatorFileCustom extends sfValidatorFile
{
  protected function configure($options = array(), $messages = array())
  {
    parent::configure($options, $messages);
    $this->setOption('validated_file_class', 'sfValidatedFileCustom');
    $mime_categories = $this->getOption('mime_categories');
    $mime_categories['ipad_videos'] = array('video/quicktime','video/mp4');
    $this->addOption('mime_categories', $mime_categories);
    $this->addOption('file_name', null);
  }
   
  protected function doClean($value)
  {
    $validatedFile = parent::doClean($value);
    $validatedFile->setFileName($this->getOption('file_name'));
    return $validatedFile;
  }
}