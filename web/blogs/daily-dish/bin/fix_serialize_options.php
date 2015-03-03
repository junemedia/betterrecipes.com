#!/usr/bin/php
<?
error_reporting(10);

if (strpos($_SERVER['HOSTNAME'], 'rd') === 0) {
    die('THIS SHOULD NOT BE RUN ON PROD'.PHP_EOL);
}



$UNFIXABLE = array();
$FIXED = 0;

// this script attempts to fix the serialization issues after you dump a prod DB to your local (or staging)

// // prod
// $db = new MySQLi(
//       "ufadb.ckkcj8jxszt1.us-east-1.rds.amazonaws.com"
//     , "newadvisor"
//     , "5ql8cce55"
//     , "newadvisor_prod"
// );

$db = new MySQLi(
      ini_get("mysqli.default_host")
    , ini_get("mysqli.default_user")
    , ini_get("mysqli.default_pw")
    , 'newadvisor'
    , ini_get("mysqli.default_port")
);

if ($db->connect_error) {
    debug("Could not connect to MySQL: ".$db->connect_error);
}

// // prod
// $q = $db->query('SHOW TABLES WHERE Tables_in_newadvisor_prod LIKE "%_options"');
$q = $db->query('SHOW TABLES WHERE Tables_in_newadvisor LIKE "%_options"');

while ($r = $q->fetch_row()) {
    $tables[] = $r[0];
}

// print_r($tables);


foreach ($tables as $table) {

    // try to find any serialized values
    $q = $db->query('SELECT option_id, option_value FROM '.$table);
    while ($r = $q->fetch_assoc()) {
        $id = $r['option_id'];
        $val = $r['option_value'];

        // is this possibly a serialized PHP string?
        if (!preg_match('/^[as]:\d+:\{/', $val))
            continue;

        // ok, it looks like a serialized PHP string, does it work?
        if (@unserialize($val) !== false)
            continue; // it's working perfectly, leave it alone

        // if (strpos($val, 'resolute.com') === false) {
        //     echo 'BROKEN, but not from sed replacement: '.$table.' :::::: '.$id.PHP_EOL;
        // }

        $fixed_val = un_f_serialize($val);
        if (!$fixed_val) {
            continue; // :( couldn't fix
            $UNFIXABLE[] = $table.','.$id;
        }

        // Let's start updating mysql
        $db->query(sprintf('UPDATE `%s` SET `option_value`="%s" WHERE `option_id`=%d'
            ,   $table
            ,   mysqli_real_escape_string($db, $fixed_val)
            ,   (int)$id
            )
        );
        $FIXED++;
        // echo 'BROKEN: '.$table.' :::::: '.$id.' ===== '.$val.PHP_EOL.PHP_EOL;
    }


}

if (count($UNFIXABLE)) {
    echo '*** Could not fix the following serialized values'.PHP_EOL;
    print_r($UNFIXABLE);
}

echo 'Fixed '.$FIXED.' broken serialization values'.PHP_EOL;

// exit;
//
// $data[] = <<<HOAH
// a:3:{i:2;a:29:{s:5:"title";s:12:"Recent Posts";s:10:"hide_title";i:1;s:9:"title_url";s:0:"";s:12:"number_posts";i:6;s:11:"post_offset";i:0;s:11:"maximum_age";s:1:"0";s:9:"post_type";s:4:"post";s:11:"post_status";s:7:"publish";s:8:"order_by";s:4:"date";s:5:"order";s:30:"ASC>ASC</option><option value=";s:14:"order_meta_key";s:0:"";s:13:"reverse_order";i:0;s:13:"shuffle_order";i:0;s:13:"ignore_sticky";i:0;s:11:"only_sticky";i:0;s:14:"exclude_sticky";i:0;s:15:"exclude_current";i:1;s:16:"current_category";i:0;s:23:"current_single_category";i:0;s:14:"current_author";i:0;s:10:"categories";s:61:"126,89,138,1013,28,76689,136769,-68350,-331,-26,429,-556,-488";s:4:"tags";s:6:"136770";s:11:"post_author";s:0:"";s:3:"tax";s:0:"";s:13:"custom_fields";s:0:"";s:7:"exclude";s:0:"";s:12:"before_items";s:27:"<div class=\"hpgallery\">";s:11:"item_format";s:448:"<div class=\"hpitem\"><div class=\"hpslug\">[category link = 1 justone = 1]<a href=\"[url]\"></div>
// <div class=\"hpimg\">[image from=attached width=205 height=150
// class=aligncenter fallback=\'http://blogs.chris.resolute.com/blogs/ladieslounge/files/2012/06/bkg.jpg\']</a></div>
// <div class=\"hphed\"><a href=\"[url]\">[title]</a></div>
// <div class=\"hpbody\">[excerpt length=100 space_between=1 after=\"...\" after_link=1]</div></div>";s:11:"after_items";s:6:"</div>";}i:3;a:29:{s:5:"title";s:11:"Fresh Posts";s:10:"hide_title";i:0;s:9:"title_url";s:0:"";s:12:"number_posts";i:3;s:11:"post_offset";i:0;s:11:"maximum_age";s:1:"0";s:9:"post_type";s:4:"post";s:11:"post_status";s:7:"publish";s:8:"order_by";s:4:"date";s:5:"order";s:30:"ASC>ASC</option><option value=";s:14:"order_meta_key";s:0:"";s:13:"reverse_order";i:0;s:13:"shuffle_order";i:0;s:13:"ignore_sticky";i:1;s:11:"only_sticky";i:0;s:14:"exclude_sticky";i:0;s:15:"exclude_current";i:1;s:16:"current_category";i:1;s:23:"current_single_category";i:1;s:14:"current_author";i:0;s:10:"categories";s:0:"";s:4:"tags";s:0:"";s:11:"post_author";s:0:"";s:3:"tax";s:0:"";s:13:"custom_fields";s:0:"";s:7:"exclude";s:0:"";s:12:"before_items";s:0:"";s:11:"item_format";s:337:"<div class=\"sidebaritem\">
// <div class=\"sidebarimg\">[image from=attached width=125 height=70
// class=aligncenter fallback=\'http://www.lhj.com/blogs/ladieslounge/2012/06/21/10-cute-and-stylish-swim-coverups/screen-shot-2012-06-13-at-3-07-05-pm-2/\']</a></div>
// <div class=\"sidebarhed\"><a href=\"[url]\">[title]</a></div>
// </div>";s:11:"after_items";s:97:"<div class=\"seeall\"><a href=\"/blogs/ladieslounge/home\">See All Fresh Blog Posts</a></div>";}s:12:"_multiwidget";i:1;}
// HOAH;


function un_f_serialize($d) {
    $d = html_entity_decode($d, ENT_QUOTES, 'UTF-8');
    $d = stripslashes($d);
    $d = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $d );
    $d = unserialize($d);
    return ($d !== false) ? serialize($d) : false;
    // print_r($d);
    // echo PHP_EOL.PHP_EOL.serialize($d).PHP_EOL.PHP_EOL.PHP_EOL.PHP_EOL.PHP_EOL.PHP_EOL.PHP_EOL.PHP_EOL;
}

