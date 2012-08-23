#!/usr/bin/php
<?
define('IMAGE_DB','/tmp/br_recipe_photo_db.php');
define('DOWNLOAD_LIST','/tmp/br_recipe_download_list.txt');
define('DOWNLOAD_RESULTS','/tmp/br_recipe_download_results.txt');
// define('ORIG_IMAGE_DIR', '/srv/sites/br_image_download/');
define('ORIG_IMAGE_DIR', '/srv/sites/betterrecipes/web/uploads/photo/original/');
define('RESIZE_IMAGE_DIR', '/srv/sites/betterrecipes/web/uploads/photo/');

@include_once(IMAGE_DB);

if (!isset($cache)) {
  $cache = array();
}
$images_to_update_list = array();

error_reporting(0);
ini_set('memory_limit', '1G');

// $dbh = mysql_connect('rd3:3307','root','rd112358',true,MYSQL_CLIENT_COMPRESS);
$dbh = mysql_connect();
mysql_select_db('betterrecipes');

$sql = sprintf('
SELECT
  DISTINCT(`image`) AS `image`
FROM
  `photo`
WHERE
  `source`<>"nw"
  '
);

$query = mysql_query($sql);


$fh = fopen(DOWNLOAD_LIST, 'w');
while ($r = mysql_fetch_assoc($query)) {
  if (!isset($cache[$r['image']])) {
    fwrite($fh, $r['image'].PHP_EOL);
  }
  $images_to_update_list[] = $r['image'];
}

fclose($fh);

echo "Downloading images not in DB or Cache...";
exec('download -c '.DOWNLOAD_LIST.' -l '.DOWNLOAD_RESULTS.' -e jpg --md5=2 --forks=50 '.ORIG_IMAGE_DIR);
echo "Done.".PHP_EOL;

// DOWNLOAD_RESULTS -> IMAGE_DB
echo "Writing to cache: ".IMAGE_DB.'...'.PHP_EOL;
$fh = fopen(DOWNLOAD_RESULTS, 'r');
while ($line = fgets($fh)) {
  $r = explode("\t", $line);
  if (count($r) != 3) {
    continue;
  }
  $cache[$r[1]] = $r[0];
}
fclose($fh);

// remove the old 
@unlink(DOWNLOAD_RESULTS.'.bak');
@rename(DOWNLOAD_RESULTS, DOWNLOAD_RESULTS.'.bak');

// save the cache
$buf  = '<?'.PHP_EOL;
$buf .= '$cache = '.PHP_EOL;
$buf .= var_export($cache, true);
$buf .= ';'.PHP_EOL;
file_put_contents(IMAGE_DB, $buf);
echo "Done.".PHP_EOL;


// go through cache and update any photo without it's md5 and ext
echo "Updating MySQL with any newly found images...";
foreach ($images_to_update_list as $url) {
  $sql = sprintf('
    UPDATE `photo`
    SET 
      `image`="%s"
     ,`thumb`=""
     ,`source`="nw"
     ,`updated_at`=NOW()
    WHERE
      `image`="%s"
    AND
      `source`<>"nw"
    ',
    $cache[$url].'.jpg',
    $url);
  mysql_query($sql);
}
echo "Done.".PHP_EOL;

echo "Running the resizer...";
exec('resize -s 400x300,280x205 "'.ORIG_IMAGE_DIR.'" "'.RESIZE_IMAGE_DIR.'"');
echo "Done".PHP_EOL;