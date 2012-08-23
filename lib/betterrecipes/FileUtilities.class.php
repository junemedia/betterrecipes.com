<?php
class FileUtilities
{
  public static function copy_dir($source, $dest){
    // Simple copy for a file
    if (is_file($source)) {
      $c = copy($source, $dest);
      chmod($dest, 0777);
      return $c;
    }
    // Make destination directory
    if (!is_dir($dest)) {
      $oldumask = umask(0);
      mkdir($dest, 0777, true);
      umask($oldumask);
    }
    // Loop through the folder
    if(is_dir($source)){
      $dir = dir($source);
      while (false !== $entry = $dir->read()) {
        // Skip pointers
        if ($entry == '.' || $entry == '..') {
          continue;
        }
        // Deep copy directories
        if ($dest !== $source.'/'.$entry) {
          self::copy_dir($source.'/'.$entry, $dest.'/'.$entry);
        }
      }
      // Clean up
      $dir->close();      
    }
    return true;
  }
  
  public static function compress($zip_file_name){ 
    // increase script timeout value
    ini_set('max_execution_time', 600);
    // create object
    $zip = new ZipArchive();
    // open archive
    if ($zip->open($zip_file_name.'.zip', ZIPARCHIVE::CREATE) !== true) {
      die ('Could not open archive');
    }
    // initialize an iterator
    // pass it the directory to be processed 
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($zip_file_name));
    // iterate over the directory
    // add each file found to the archive
    foreach ($iterator as $key=>$value) {
    $zip->addFile(realpath($key), $key) or die ('ERROR: Could not add file: '.$key);
    }
    // close and save archive
    $zip->close();
  }

  public static function removeDir($dir){ 
    if (is_dir($dir)) {
      $objects = scandir($dir);
      foreach ($objects as $object) {
        if ($object != "." && $object != "..") {
        if (filetype($dir."/".$object) == "dir") self::removeDir($dir."/".$object); else unlink($dir."/".$object);
        }
      }
      reset($objects);
      rmdir($dir);
    } 
  }

}
