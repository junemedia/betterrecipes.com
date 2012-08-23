<?
class sfValidatedFileCustom extends sfValidatedFile
{
  private $file_name;
  
  public function setFileName($value)
  {
    $this->file_name = $value;
  }
  
  public function generateFilename()
  {
    $file_arr = explode('.', $this->originalName); 
    $extension = $file_arr[1]; 
    $file_name = $this->file_name. '.' . $extension;
    return $file_name;
  }
  
  
}