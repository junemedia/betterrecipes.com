#!/usr/bin/php
<?

$db = new MySQLi(
      ini_get("mysqli.default_host")
    , ini_get("mysqli.default_user")
    , ini_get("mysqli.default_pw")
    , 'betterrecipes'
    , ini_get("mysqli.default_port")
);

if ($db->connect_error) {
    debug("Could not connect to MySQL: ".$db->connect_error);
}

$query = "SELECT id, slug, parent_id FROM category WHERE is_active = 1";

if(!($stmt = $db->prepare( $query )))
{
    echo "Prepare failed: (" . $db->errno . ") " . $db->error;
    echo $query;
}else
{
    if (!$stmt->execute())
    {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        echo $stmt;
    }
    $results = $stmt->get_result();
}

$row_array = array();

while( $row = $results->fetch_assoc() )
{
    $recipe_array = array();
    $results_array = array();
    //THIS WILL FAIL ONLY IF THE ID OF THE PARENT IS HIGHER THEN THEN CHILD
    $url = 'http://';
    $row_array[$row['id']] = $row;
    if( isset( $row['parent_id'] ))
    {
        $url .= $row_array[$row['parent_id']]['slug'] . ".betterrecipes.com/" . $row['slug'] . ".html";
        $filter = 'SubCategoryId:' . $row['id'];
    }else
    {
        $url .= $row['slug'] . ".betterrecipes.com/";
        $filter = 'CategoryId:' . $row['id'];
    }

    // Get cURL resource
    $curl = curl_init();
    // Set some options - we are passing in a useragent too here
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://meredith-betrec.baynote.net/baynote/guiderest?customerId=meredith&code=betrec&guide=MostPopularRecipes&resultsPerPage=10&attrFilter=' . $filter . '&attrList=*&url=' . urlencode($url) . '&v=1',
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1309.0 Safari/537.17'
    ));
    // Send the request & save response to $resp
    $resp = curl_exec($curl);

    if(!curl_exec($curl)){
        die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
    }
    // Close request to clear up some resources
    curl_close($curl);

    $xml_object = simplexml_load_string( $resp );
    
    foreach( $xml_object as $r )
    {
        $recipe_array = array();
        $recipe_array['url'] = (string)$r->attributes()->u;
        $recipe_array['title'] = trim( str_replace( "| Better Recipes", "", (string)$r->attributes()->t ));
        $recipe_url = parse_url( $recipe_array['url'] );
        $path = explode( '.', $recipe_url['path'] );
        $recipe_array['slug'] = str_replace( '/', '',  $path[0] );
        foreach( $r as $a )
        {
            if( $a->attributes()->n == 'Description' )
            {
                $recipe_array['description'] =  (string)$a->attributes()->v;
            }else if( $a->attributes()->n == 'Image' )
            {
                $recipe_array['image_url'] = (string)$a->attributes()->v;
            }
        }
        $results_array[] = $recipe_array;
    }
    $memcache = new Memcache();
    $memcache->connect('mmc', 11211);
    $memcache->set('br_pop_recipes_' . md5($row['slug']), $results_array, 0, 86400); //Queue lasts for 1 day max
    $memcache->close();
}
?>