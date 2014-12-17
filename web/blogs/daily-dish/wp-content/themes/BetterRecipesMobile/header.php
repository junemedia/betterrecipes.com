<?php
/**
 * @package WordPress
 * @subpackage BetterRecipes2011
 */
?>
<!doctype html>
  <!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
  <!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
  <!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
  <!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
<!--  profile="http://gmpg.org/xfn/11" -->
<title>
<?php wp_title('&laquo;', true, 'right'); ?>
<?php bloginfo('name'); ?>
</title>
<!-- [Meta] -->
<meta charset="utf-8">
<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame. Remove this if you use the .htaccess -->
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, user-scalable=1, initial-scale=1.0, minimal-scale=1, maximum-scale=1, target-densityDpi=device-dpi" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link href="http://www.betterrecipes.com/favicon.ico" rel="shortcut icon">
<!-- [Stylesheets] -->
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory'); ?>/dev-assets/betterrecipes.css" />
<? /* <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css"/> */ ?>
<? /*
<link rel="stylesheet" type="text/css" media="print" href="<?php bloginfo('template_directory'); ?>/css/print.css" />
*/ ?>
<!-- [WP HEAD] -->
<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); wp_head(); ?>
<!-- [Scripts] -->
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/dev-assets/jquery.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/dev-assets/brmobile.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/dailydish.js"></script>
<script type="text/javascript" src="http://cdn.gigya.com/js/socialize.js?apiKey=2_t7ugJniPXN32-uUr2BkBDPmTa-oo6VVzt2Gl2MFyw-N8bgqbxzpADm4C1F_6gD51"></script>
<script type="text/javascript">
var conf=
{ 
  APIKey: '2_t7ugJniPXN32-uUr2BkBDPmTa-oo6VVzt2Gl2MFyw-N8bgqbxzpADm4C1F_6gD51'
}
</script>
<? $category = get_the_category();  ?>
<? $blogname = get_bloginfo('name');  ?>
<? $blogname = htmlspecialchars_decode( $blogname, ENT_QUOTES); ?>
<? $blogname = preg_replace('/[^a-zA-Z0-9-]/', '', $blogname); ?>
<? $blogcat = $category[0]->cat_name;  ?>
<? $blogcat = htmlspecialchars_decode( $blogcat, ENT_QUOTES); ?>
<? $blogcat = preg_replace('/[^a-zA-Z0-9-]/', '', $blogcat); ?>


<script type="text/javascript"> 
/* <![CDATA[ */ 
	ord=Math.random()*10000000000000000;
	//var adzone = 'betterrecipes.mdp.com';
	var adchannelid="<?=$blogname; ?>";
	var adparentid="<?=$blogcat; ?>";
	var adchild1id=''; 						/* 3rd Level Tag - - Alt. var names: child1 */
	var adid='<?= md5($_SERVER["HTTP_X_FORWARDED_HOST"].$_SERVER["SCRIPT_URL"]); ?>'; 					/* 4th Level Tag - "Blog Title" - Alt. var names: id */
	var adsite='br';
	var banneradsz= '728x90';
	var banneradtile= 1;
	var sidebaradsz= '300x250';
	var sidebaradtile= 2;
/* ]]> */ 
</script>

<?php define('THEMEPATH', '/blogs/daily-dish/wp-content/themes/BetterRecipesMobile/dev-assets'); ?>
</head>
<body>


<header id="main-header">
  <a href="http://www.betterrecipes.com" title="Better Recipes">
  	<img src="<?=THEMEPATH?>/img/m/logo-betterrecipes-hd.jpg" height="40" width="159" alt="BetterRecipes: better recipes - better meals"  />
  </a>
  <a href="http://www.betterrecipes.com/mixing-bowl" title="mixing bowl">
  	<img src="<?=THEMEPATH?>/img/m/logo-mixingbowl-hd.jpg" height="40" width="160" alt="mixingbowl" />
  </a>
</header><!-- /#header -->


<header id="hd-search">
  <div class="ad320x40">
    <!-- BEGIN: Top ad tag: -->
	<script type="text/javascript" src="http://ad.mo.doubleclick.net/N3865/dartproxy/mobile.handler?k=br.mob/;site=br;id=br1000;pos=top;tile=1;sz=3x3;ord=[?];dw=1"></script>
	<!-- END: Top ad tag: -->
  </div><!-- /.ad320x40 -->
  <div class="searchbox">
    <form action="http://www.betterrecipes.com/search" method="get">
      <input type="text" value="" placeholder="Search for recipe" name="term" onFocus="clearText(this)" onBlur="clearText(this)" />
      <input type="hidden" name="PageType" value="Recipe" />
      <input type="submit" value="SEARCH" />
    </form>
    <ul>
      <li><a href="http://www.facebook.com/betterrecipes" title="Find us on Facebook"><img src="<?=THEMEPATH?>/img/m/cta-facebook.jpg" height="28" width="28" alt="Facebook" /></a></li>
      <li><a href="http://www.twitter.com/betterrecipes" title="Find us on Twitter"><img src="<?=THEMEPATH?>/img/m/cta-twitter.jpg" height="30" width="29" alt="Twitter" /></a></li>
    </ul>
  </div><!-- /.searchbox -->
</header><!-- /#search -->


	<header class="daily-dish">
	  <img src="<?=THEMEPATH?>/img/m/img-dd-header.jpg" />
	</header>
	
	<div id="jumpbox">
	  <form action="<?php bloginfo('url'); ?>/" method="get">
	    <!--<input type="text" id="jumpbox-input" name="jumpbox-input" value="Jump to a page" />-->
	    <?php
		$select = wp_dropdown_categories('show_option_none=Jump to a category&orderby=name&echo=0');
		$select = preg_replace("#<select([^>]*)>#", "<select$1 name=\"jumpbox-select\" id=\"jumpbox-select\" onchange='return this.form.submit()'>", $select);
		echo $select;
		?>
		<!--
	    <select name="jumpbox-select" id="jumpbox-select" onchange="location=this.options[this.selectedIndex].value;">
	    	<option value="">Jump to a category</option>
	    	<option value="">Recipes</option>
	    </select>
	    -->
	  </form>
	</div><!-- /#jumpbox -->

	<div id="main-content" class="daily-dish">







