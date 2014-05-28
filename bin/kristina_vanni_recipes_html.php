#!/usr/bin/php
<?

$dbh = mysql_connect();
mysql_select_db('betterrecipes');

$sql = sprintf('SELECT
    TRIM(`r`.`name`) `name`,
    CONCAT("http://",IF(`c2`.`slug` IS NOT NULL,CONCAT(`c2`.`slug`,"."),CONCAT(`c1`.`slug`,".")),"betterrecipes.com/",`r`.`slug`,".html") AS `url`,
    TRIM(`introduction`) `introduction`,
    TRIM(`instructions`) `instructions`,
    TRIM(`ingredients`) `ingredients`,
    TRIM(`notes`) `notes`,
    -- `r`.`created_at` `created`,
    COUNT(1) AS `imgcnt`,
    GROUP_CONCAT(
        CONCAT(
            "http://www.betterrecipes.com/uploads/photo/original/",
            SUBSTR(`p`.`image`, 1, 1),
            "/",
            SUBSTR(`p`.`image`, 2, 1),
            "/",
            `p`.`image`
        )
        SEPARATOR ",") `images`
FROM
    `recipe` `r`
LEFT JOIN
    `photo` `p` ON (`r`.`id` = `p`.`recipe_id`)
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
    `r`.`user_id`=14572
GROUP BY
    `r`.`id`
ORDER BY
    `r`.`created_at` DESC
');

$query = mysql_query($sql);

?><!doctype HTML>
<html>
<head>
<title>Kristina Vanni's Recipes</title>
<meta charset="utf-8">
<style>
    img {
        max-width: 400px;
    }
</style>
</head>
<body>
<? $cnt = 0; while ($r = mysql_fetch_assoc($query)): ?>
    <? if ($cnt++): ?>
    <hr>
    <? endif ?>
    <h1><a href="<?= $r['url'] ?>"><?= $r['name'] ?></a></h1>
    <h4>Introduction</h4>
    <?= p_format($r['introduction']) ?>
    <h4>Instructions</h4>
    <?= p_format($r['instructions']) ?>
    <h4>Ingredients</h4>
    <?= ingredient_format($r['ingredients']) ?>
    <h4>Notes</h4>
    <?= strlen($r['notes']) > 5 ? p_format($r['notes']) : '(none)' ?>
    <h4><?= $r['imgcnt'] ?> Image<?= $r['imgcnt'] > 1 ? 's' : '' ?></h4>
    <?= img_format($r['images']) ?>
<? endwhile ?>
</body>
</html><?


function p_format($str) {
    return "<p>".preg_replace("/\n+/", "</p><p>", trim($str))."</p>";
}
function ingredient_format($str) {
    return "<p>".preg_replace("/\n+/", "<br/>", trim($str))."</p>";
}
function img_format($str) {
    $buf = '';
    $imgs = explode(',', $str);
    foreach ($imgs as $img) {
        $buf .= '<p><a href="'.$img.'" target="_blank"><img src="'.$img.'"/></a><br/>'.$img.'</p>';
    }
    return $buf;
}
