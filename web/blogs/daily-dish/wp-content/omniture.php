<?php

if($servername==""){
    $servername='www.recipe.com';
}

$gtmAccountId = 'null';

switch($servername){
    case "www.bhg.com":{
        $gtmAccountId = "GTM-WMWB88";
        break;
    }
    case "www.parents.com":{
        $gtmAccountId = "GTM-PT434V";
        break;
    }
    case "www.recipe.com":{
        $gtmAccountId = "GTM-KHJS23";
        break;
    }
    case "www.fitnessmagazine.com":{
        $gtmAccountId = "GTM-P328DB";
        break;
    }
    case "www.familycircle.com":{
        $gtmAccountId = "GTM-MHSQB3" ;
        break;
    }
    case "www.rachaelraymag.com":{
        $gtmAccountId = "GTM-W76K69" ;
        break;
    }
    case "www.diyadvice.com":{
        $gtmAccountId = "GTM-WBB8HB" ;
        break;
    }
    case "www.allpeoplequilt.com":{
        $gtmAccountId = "GTM-T82L3P";
        break;
    }
    case "www.midwestliving.com":{
        $gtmAccountId = "GTM-NNQQ4G";
        break;
    }
    case "www.traditionalhome.com":{
        $gtmAccountId = "GTM-KL57ZH" ;
        break;
    }
    case "www.livingthecountrylife.com":{
        $gtmAccountId = "GTM-W9PJ7R" ;
        break;
    }
    case "www.more.com":{
        $gtmAccountId = "GTM-52GC5C" ;
        break;
    }
    case "www.woodmagazine.com":{
        $gtmAccountId = "GTM-KGGK47" ;
        break;
    }
}

?>

<!-- SiteCatalyst code version: H.5.
Copyright 1997-2006 Omniture, Inc. More info available at
http://www.omniture.com -->
<script language="JavaScript" src="<?=$jspath?>"></script>
<script language="JavaScript">

var dataLayerEntry = {};
window.dataLayer = window.dataLayer || [];

/* You may give each page an identifying name, server, and channel on the next lines. */
s.server="<?=$servername?>";
/* Baynote script requires eVar5 to be defined */
s.eVar5="";

<?php if ( is_404() || is_category() || is_archive() || is_day() || is_month() || is_year() || is_search() || is_paged() || is_single() || (strcmp($wp_query->is_page,"1")==0)) { ?>
						
						<?php /* If this is a 404 page */ if (is_404()) { ?>
				/* if there were any 404 Omniture values, those would go here */

						<?php /* If this is a Category archive */ } elseif (is_category()) { ?>
				s.pageName = dataLayerEntry['Page Name'] = "Blogs:<?=bloginfo('name')?>:<?=single_cat_title('')?>";
				s.channel=dataLayerEntry['Channel'] = "Blogs";
				s.prop1=dataLayerEntry['Category'] = "Community";
				/* E-commerce Variables */
				s.eVar9="Blogs:<?=bloginfo('name')?>:<?=single_cat_title('')?>";
				s.eVar14="Blogs";

						<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
				s.pageName = dataLayerEntry['Page Name']="Blogs:<?=bloginfo('name')?>:<?=the_time('l, F jS, Y')?>";
				s.channel=dataLayerEntry['Channel'] = "Blogs";
				s.prop1=dataLayerEntry['Category'] = "Community";
				/* E-commerce Variables */
				s.eVar9="Blogs:<?=bloginfo('name')?>:<?=the_time('l, F jS, Y')?>";
				s.eVar14="Blogs";

						<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
				s.pageName = dataLayerEntry['Page Name']="Blogs:<?=bloginfo('name')?>:<?=the_time('F, Y')?>";
				s.channel=dataLayerEntry['Channel'] = "Blogs";
				s.prop1=dataLayerEntry['Category'] = "Community";
				/* E-commerce Variables */
				s.eVar9="Blogs:<?=bloginfo('name')?>:<?=the_time('F, Y')?>";
				s.eVar14="Blogs";

						<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
				s.pageName = dataLayerEntry['Page Name']="Blogs:<?=bloginfo('name')?>:<?=the_time('Y')?>";
				s.channel=dataLayerEntry['Channel'] = "Blogs";
				s.prop1=dataLayerEntry['Category'] = "Community";
				/* E-commerce Variables */
				s.eVar9="Blogs:<?=bloginfo('name')?>:<?=the_time('Y')?>";
				s.eVar14="Blogs";

						<?php /* If this is a search result */ } elseif (is_search()) { ?>
				s.pageName = dataLayerEntry['Page Name']="Blogs:<?=bloginfo('name')?>:Search:<?=the_search_query()?>";
				s.channel=dataLayerEntry['Channel'] = "Search";
				s.prop1=dataLayerEntry['Category'] = "Community";
				/* E-commerce Variables */
				s.eVar9="Blogs:<?=bloginfo('name')?>:Search:<?=the_search_query()?>";
				s.eVar14="Search";
				s.eVar5=dataLayerEntry['Search Term']="<?=the_search_query()?>";

							<?php /* If this is a page */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
					s.pageName = dataLayerEntry['Page Name']="Blogs:Post:<?=bloginfo('name')?>";
					s.channel=dataLayerEntry['Channel'] = "Blogs";
					s.prop1=dataLayerEntry['Category'] = "Community";
					/* E-commerce Variables */
					s.eVar9="Blogs:Post:<?=bloginfo('name')?>";
					s.eVar14="Blogs";

							<?php /* If this is a page */ } elseif (strcmp($wp_query->is_page,"1")==0) { ?>
					s.pageName = dataLayerEntry['Page Name']="Blogs:<?=bloginfo('name')?>:Post:<?=the_title()?>";
					s.channel=dataLayerEntry['Channel'] = "Blogs";
					s.prop1=dataLayerEntry['Category'] = "Community";
					/* E-commerce Variables */
					s.eVar9="Blogs:<?=bloginfo('name')?>:Post:<?=the_title()?>";
					s.eVar14="Blogs";

						<?php /* If this is a 'Category' or 'Tag' or 'Author' archive */ } elseif (is_archive()) { ?>
				s.pageName = dataLayerEntry['Page Name']="Blogs:<?=bloginfo('name')?>:<?=single_cat_title('')?>";
				s.channel=dataLayerEntry['Channel'] = "Blogs";
				s.prop1=dataLayerEntry['Category'] = "Community";
				/* E-commerce Variables */
				s.eVar9="Blogs:<?=bloginfo('name')?>:<?=single_cat_title('')?>:<?php the_author(); ?>";
				s.eVar14="Blogs";

						<?php /* If this is a single post */} elseif (is_single()) { ?>
				s.pageName = dataLayerEntry['Page Name']="Blogs:<?=bloginfo('name')?>:<?=trim(str_replace("&raquo;","",wp_title("",false)))?>";
				s.channel=dataLayerEntry['Channel'] = "Blogs";
				s.prop1=dataLayerEntry['Category'] = "Community";
				/* E-commerce Variables */
				s.eVar9="Blogs:<?=bloginfo('name')?>:<?=trim(str_replace("&raquo;","",wp_title("",false)))?>";
				s.eVar14="Blogs";
		
    				<?php } ?>
    
		<?php /* If it's not any of the above, it must be the front-page */} elseif (is_front_page() || is_home()) { ?>
s.pageName = dataLayerEntry['Page Name']="Blogs:<?=bloginfo('name')?>";
s.channel=dataLayerEntry['Channel']="Blogs";
s.prop1=dataLayerEntry['Category']="Community";
/* E-commerce Variables */
s.eVar9="Blogs:<?=bloginfo('name')?>";
s.eVar14="Blogs";
<?php }?>
/* Omniture updates for Jan 1, 2010 per Mark Ribich - Ben, 12-29-2009*/
<?php
function getRootDomain()
{
	$test  = $_SERVER['HTTP_HOST'];
	if ($test == "blogs.mydevstaging.com" && !empty($_SERVER["HTTP_X_FORWARDED_HOST"]))
	{
		$test = $_SERVER["HTTP_X_FORWARDED_HOST"];
	}
	//$test = "bhg.com";
	$var = explode(".",$test);
	$data = $var[count($var)-2];
	return $data;
}
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
	$test  = $_SERVER['HTTP_HOST'];
	if ($test == "blogs.mydevstaging.com" && !empty($_SERVER["HTTP_X_FORWARDED_HOST"]))
	{
		$test = $_SERVER["HTTP_X_FORWARDED_HOST"];
	}

 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $test.":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $test.$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
?>
s.prop18="<?=getRootDomain();?>";

<?php
	if (getRootDomain() == "topbabynames")
	{
		echo "s.prop19=\"Baby Names\";";
	}
	else if (getRootDomain() == "betterrecipes")
	{
		echo "s.prop19=\"food\";";
	}
	else
	{
		echo "s.prop19=\"Other\";";
	}
?>

s.prop20="<?=curPageURL();?>";

/* Added s.eVar29 to Parents blogs - Jeremy Schultz, 3/14/12 */
<?php
	if ($servername == "www.parents.com")
	{
		echo "s.eVar29=\"Blog\";";
	}
?>

dataLayerEntry['Hash ID'] = "";
dataLayerEntry['event'] = "pageview";

if (typeof dataLayer == "object" && typeof dataLayerEntry == "object")
	dataLayer.push(dataLayerEntry);

/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
var s_code=s.t();if(s_code)document.write(s_code)
</script>
<script language="JavaScript"><!--
if(navigator.appVersion.indexOf('MSIE')>=0)document.write(unescape('<')+'\!-'+'-')
//--></script><!--/DO NOT REMOVE/-->
<!-- End SiteCatalyst code version: H.5. -->


