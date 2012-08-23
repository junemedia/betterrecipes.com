#!/usr/bin/php
<?
error_reporting(0);
ini_set('memory_limit', '1G');

define('ONESITE_BAYNOTE_XML', '/srv/incoming/betterrecipes/uploads/ftp/baynote_onesite.xml.gz');
define('ONESITE_FTP_HOST','ftp.onesite.com');
define('ONESITE_FTP_USER','social.betterrecipes.com');
define('ONESITE_FTP_PASS','mcorp001');
define('ONESITE_FTP_PATH','/data/baynote_onesite.xml.gz');

$ftp_url = sprintf(
  "ftp://%s:%s@%s%s",
  ONESITE_FTP_USER,
  ONESITE_FTP_PASS,
  ONESITE_FTP_HOST,
  ONESITE_FTP_PATH
  );
  
$fh = fopen(ONESITE_BAYNOTE_XML, "w");
$c = curl_init();
curl_setopt($c, CURLOPT_URL, $ftp_url);
curl_setopt($c, CURLOPT_FILE, $fh);
curl_exec($c);
