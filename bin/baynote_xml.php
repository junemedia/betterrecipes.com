#!/usr/bin/php
<?
error_reporting(10);
ini_set('memory_limit', '1G');

$dishRssUrl = 'http://10.10.10.19/blogs/daily-dish/feed/';


chdir(dirname(__FILE__));
include_once(dirname(__FILE__) . '/../apps/frontend/lib/Microformat.class.php');


// define('BASE_HOST', 'betterrecipes.mydevstaging.com');
define('BASE_HOST', 'betterrecipes.com');
define('BASE_IMAGE', 'http://' . BASE_HOST . '/uploads/photo/400x300/');

$_ROOT_INGREDIENTS = array();

// $dbh = mysql_connect('rd1:3307','root','rd112358',true,MYSQL_CLIENT_COMPRESS);
$dbh = mysql_connect();
mysql_select_db('betterrecipes');

$sql = sprintf('
SELECT
  `r`.`name` AS `Title`
 ,CONCAT("http://",IF(`c2`.`slug` IS NOT NULL,CONCAT(`c2`.`slug`,"."),CONCAT(`c1`.`slug`,".")),"%s/",`r`.`slug`,".html") AS `Url`
 ,`c1`.`id` AS `CategoryId`
 ,`c1`.`slug` AS `CategorySlug`
 ,`c1`.`name` AS `CategoryName`
 ,`c2`.`id` AS `SubCategoryId`
 ,`c2`.`slug` AS `SubCategorySlug`
 ,`c2`.`name` AS `SubCategoryName`
 ,`r`.`description` AS `Description`
 ,`r`.`ingredients` AS `Ingredients`
 ,`r`.`servings` AS `Servings`
 ,`r`.`preptime` AS `PrepTime`
 ,`r`.`cooktime` AS `CookTime`
 ,`r`.`totaltime` AS `TotalTime`
 ,`r`.`summary` AS `Summary`
 ,`r`.`keywords` AS `Keywords`
 ,`r`.`notes` AS `Notes`
 ,`r`.`rating` AS `Rating`
 ,`r`.`main_ingredient` AS `MainIngredient`
 ,`r`.`course` AS `Course`
 ,`r`.`instructions` AS `Instructions`
 ,`r`.`views` AS `Views`
 ,`r`.`created_at` AS `PubDate`
 ,`u`.`id` AS `AuthorId`
 ,`u`.`display_name` AS `AuthorName`
 ,`u`.`email` AS `AuthorEmail`
 ,`p`.`image` AS `Image`
FROM
  `recipe` AS `r`
LEFT JOIN
  `photo` AS `p`
  ON (`r`.`id` = `p`.`recipe_id`)
LEFT JOIN
  `user` AS `u`
  ON (`r`.`user_id` = `u`.`id`)
LEFT JOIN
  `category_recipe` AS `cr`
  ON (`r`.`id` = `cr`.`recipe_id`)
LEFT JOIN
  `category` AS c1
  ON (`cr`.`category_id` = `c1`.`id`)
LEFT JOIN
  `category` AS c2
  ON (`c1`.`parent_id` = `c2`.`id`)
WHERE
  `r`.`is_active`=1
AND
  `cr`.`sequence`=1
AND
  `r`.`is_active`=1
LIMIT 100000
', BASE_HOST
);
// echo $sql.PHP_EOL;exit;

$query = mysql_query($sql);

// Using ghetto way
echo <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<update-all-attributes>
<attributes list="PageType,Title,Description,Ingredients,Servings,PrepTime,CookTime,TotalTime,Summary,Keywords,Notes,Rating,MainIngredient,Course,Instructions,Views,PubDate,AuthorId,AuthorName,AuthorEmail,Image,RootIngredients,BlogCategory,PubDate"></attributes>

XML;

while ($r = mysql_fetch_assoc($query)) {
  printf('<document name="%s">' . PHP_EOL, $r['Url']);
  unset($r['Url']); // remove 'Url' from array
  $r = array_filter($r); // removes blank attributes;
  $r = preg_replace("/[^0-9A-Za-z,\/\.@_\- ]/", '', $r);
  if (isset($r['Ingredients'])) {
    // Ingredients -> RootIngredients
    $r['RootIngredients'] = Microformat::splitIngredients($r['Ingredients']);
  }
  $r = array_map(array('Microformat', 'correct_spaces'), $r);
  $r['Title'] = Microformat::correct_caps($r['Title']);
  $r['PageType'] = 'recipe';
  foreach ($r as $key => $val) {
    switch ($key) {
      case 'Image':
        $val = xml_escape(image_url($val));
        break;
      case 'Description':
      case 'Ingredients':
      case 'Instructions':
        $val = xml_escape(trim(substr(Microformat::correct_sentence($val), 0, 350)));
        break;
      case 'RootIngredients':
        foreach ($val as $ingredient) {
          // collect stats for all root ingredients
          if (isset($_ROOT_INGREDIENTS[$ingredient['name']['name']]))
            $_ROOT_INGREDIENTS[$ingredient['name']['name']]++;
          else
            $_ROOT_INGREDIENTS[$ingredient['name']['name']] = 1;

          // one last chance to remove any bogus RootIngredients
          if (
            (strlen($ingredient['name']['name']) > 40)
            || preg_match('/\d/', $ingredient['name']['name'])
            || (strlen($ingredient['name']['name']) <= 2)
          )
            continue;

          printf('<attribute name="RootIngredients" value="%s"/>' . PHP_EOL, xml_escape($ingredient['name']['name']));
        }
        break;
      default:
        $val = xml_escape(trim(substr(Microformat::correct_caps($val), 0, 350)));
    }
    if (!is_array($val))
      printf('<attribute name="%s" value="%s"/>' . PHP_EOL, $key, xml_escape($val));
  }
  printf('</document>' . PHP_EOL);
}


// fetch DailyDish Blog Posts and loop through them to build XML
$dish = getFeed();

for ($i = 0; $i < count($dish); $i++) {
  // output the xml
  printf('<document name="%s">' . PHP_EOL, $dish[$i]['link']);
  printf('<attribute name="%s" value="%s"/>' . PHP_EOL, 'PageType', 'blogs');
  printf('<attribute name="%s" value="%s"/>' . PHP_EOL, 'Title', xml_escape($dish[$i]['title']));
  printf('<attribute name="%s" value="%s"/>' . PHP_EOL, 'Url', xml_escape($dish[$i]['link']));
  printf('<attribute name="%s" value="%s"/>' . PHP_EOL, 'Description', xml_escape($dish[$i]['description']));
  printf('<attribute name="%s" value="%s"/>' . PHP_EOL, 'PubDate', xml_escape($dish[$i]['PubDate']));
  foreach ($dish[$i]['BlogCategory'] as $val) {
    printf('<attribute name="%s" value="%s"/>' . PHP_EOL, 'BlogCategory', xml_escape($val));
  }
  printf('</document>' . PHP_EOL);
}


echo '</update-all-attributes>' . PHP_EOL;


$buf = '';
arsort($_ROOT_INGREDIENTS);
foreach ($_ROOT_INGREDIENTS as $ingredient => $count) {
  $buf .= $count . "\t" . $ingredient . PHP_EOL;
}
file_put_contents('/srv/sites/brmb-root-ingredients.txt', $buf);

function image_url($md5)
{
  if (strpos($md5, 'http') === 0) {
    return $md5;
  }
  return
    BASE_IMAGE
    . substr($md5, 0, 1)
    . '/'
    . substr($md5, 1, 1)
    . '/'
    . $md5;
}

function xml_escape($str)
{
  $str = str_replace('&amp;', '&', $str);
  $str = str_replace('&', '&amp;', $str);
  $str = str_replace('<', '&lt;', $str);
  $str = str_replace('"', '&quot;', $str);
  return $str;
}

function initApiFeed($url)
{
  //echo $url;
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  // HACK BECAUSE WE CANNOT ACCESS OUR EXTERNAL IPS INTERNALLY
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Host: blogs.mydevstaging.com'));
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  $xmlstr = curl_exec($curl);
  curl_close($curl);
  // echo $xmlstr;
  $xml1 = preg_replace('|<([/\w]+)(:)|m', '<$1', $xmlstr);
  $xml2 = preg_replace('|(\w+)(:)(\w+=\")|m', '$1$3', $xml1);
  return trim($xml2);
}

function loopThroughCategories($obj)
{
  $a = array();
  foreach ($obj as $val) {
    array_push($a, $val);
  }
  return $a;
}

function getFeed()
{
  global $dishRssUrl;
  $items = array();
  $response = initApiFeed($dishRssUrl);
  $xml = simplexml_load_string($response, null, LIBXML_NOCDATA);
  $length = count($xml->xpath('//rss/channel')); //should be 1 for valid rss
  if ($length > 0) {
    $total = count($xml->xpath('//rss/channel/item'));
    $i = 0;
    for ($i; $i < $total; $i++) {
      $items[] = array(
        'title' => (string) $xml->channel->item[$i]->title,
        'link' => (string) $xml->channel->item[$i]->link,
        'PubDate' => (string) date('F j, Y, g:i A', strtotime($xml->channel->item[$i]->pubDate)),
        'description' => trim((string) $xml->channel->item[$i]->description),
        'BlogCategory' => loopThroughCategories($xml->channel->item[$i]->category)
      );
    }
  }
  return $items;
}