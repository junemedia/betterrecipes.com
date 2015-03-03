<?php
/**
 * @package WordPress
 * @subpackage M3Column
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

<!-- [Meta] -->
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
 	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!-- [Stylesheets] -->
	<link rel="stylesheet" type="text/css" href="http://recipes.betterrecipes.com/web/common/css/util.css" />
	<link rel="stylesheet" type="text/css" href="http://recipes.betterrecipes.com/web/betterrecipes/css/core.css" />
	<link rel="stylesheet" type="text/css" href="http://recipes.betterrecipes.com/web/betterrecipes/css/mainnav.css" />
	<link rel="stylesheet" type="text/css" href="http://recipes.betterrecipes.com/web/betterrecipes/css/image.css" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

<!-- [WP HEAD] -->
 <?php wp_head(); ?>

<!-- [Scripts] -->
	<script type="text/javascript" src="http://recipes.betterrecipes.com/web/common/js/mdp_core.js"></script>
<!-- [AdTag Scripts - Set Values, Objects] -->
	<script type="text/javascript">/* *** Change Values HERE and in NOSCRIPT (Banner & Side Ad) sections only *** */
	/* <![CDATA[ */
	ord=Math.random()*10000000000000000;	
			var adzone = 'betterrecipes.mdp.com';
			var adchannelid='betterrecipes'; 			/* Top Level Tag - "Blogs" - Alt. var names: channel, category */
			var adparentid='';	/* 2nd Level Tag - "Editors Blogs" - Alt. var names: parent, subcategory */
			var adchild1id=''; 						/* 3rd Level Tag - - Alt. var names: child1 */
			var adid=''; 									/* 4th Level Tag - "Blog Title" - Alt. var names: id */
			var adsite='betterrecipes';
			var banneradsz= '728x90';
			var banneradtile= 1;
			var sidebaradsz= '160x600,300x250';
			var sidebaradtile= 2;
	/* ]]> */
	</script>
	
</head>
<body class="shell thirdParty"><!-- start body -->
<script type="text/javascript" src="http://assets.bunchball.net/scripts/nitro/3.4.0/nitro.js"></script>
<div id="brbg">
<div id="wrapper"><!-- start wrapper -->
	<noscript><div class="noJS ACThead1">You Need To Have Javascript and Flash To Make This Site Work Well.</div></noscript>
<!-- ---------[HEADER]--------- -->
	<div id="header">
		<div class="logophoto"><a href="http://www.betterrecipes.com/"><img src="http://images.meredith.com/betterrecipes/images/template/shell/logo.gif" alt="Better Recipes with Kristina Vanni" title="Better Recipes with Kristina Vanni" /></a></div>
		<div class="headerContent">
			<div class="bannerContainer">
				<div id="banner">
					<?php include('bannerad.php'); ?>
				</div>
			</div>
			<div id="navwrap">
				<ul id="mainnav">
					<li class="li-top first"><a href="http://www.betterrecipes.com//favorites/index.html" class="top"><span>Recipes</span></a>
						<ul class="ul-sub">
			               <li><a href="http://appetizer.betterrecipes.com/">Appetizer Recipes</a></li>
			               <li><a href="http://grilling.betterrecipes.com/">Grilling Recipes</a></li>
			               <li><a href="http://beef.betterrecipes.com/">Beef Recipes</a></li>
			               <li><a href="http://halloween.betterrecipes.com/">Halloween Recipes</a></li>
			               <li><a href="http://bread.betterrecipes.com/">Bread Recipes</a></li>
			               <li><a href="http://healthy.betterrecipes.com/">Healthy Recipes</a></li>
			               <li><a href="http://breakfast.betterrecipes.com/">Breakfast Recipes</a></li>
			               <li><a href="http://italian.betterrecipes.com/">Italian Recipes</a></li>
			               <li><a href="http://cake.betterrecipes.com/">Cake Recipes</a></li>
			               <li><a href="http://lowcarb.betterrecipes.com/">Low Carb Recipes</a></li>
			               <li><a href="http://chicken.betterrecipes.com/">Chicken Recipes</a></li>
			               <li><a href="http://lowfat.betterrecipes.com/">Low Fat Recipes</a></li>
			               <li><a href="http://christmas.betterrecipes.com/">Christmas Recipes</a></li>
			               <li><a href="http://mexican.betterrecipes.com/">Mexican Recipes</a></li>
			               <li><a href="http://cookie.betterrecipes.com/">Cookie Recipes</a></li>
			               <li><a href="http://pork.betterrecipes.com/">Pork Recipes</a></li>
			               <li><a href="http://crockpot.betterrecipes.com/">Crock Pot Recipes</a></li>
			               <li><a href="http://salad.betterrecipes.com/">Salad Recipes</a></li>
			               <li><a href="http://dessert.betterrecipes.com/">Dessert Recipes</a></li>
			               <li><a href="http://seafood.betterrecipes.com/">Seafood Recipes</a></li>
			               <li><a href="http://diabetic.betterrecipes.com/">Diabetic Recipes</a></li>
			               <li><a href="http://soup.betterrecipes.com/">Soup Recipes</a></li>
			               <li><a href="http://drink.betterrecipes.com/">Drink Recipes</a></li>
			               <li><a href="http://thanksgiving.betterrecipes.com/">Thanksgiving Recipes</a></li>
			               <li><a href="http://easter.betterrecipes.com/">Easter Recipes</a></li>
			               <li><a href="http://vegetarian.betterrecipes.com/">Vegetarian Recipes</a></li>
			               <li><a href="http://easy.betterrecipes.com/">Easy Recipes</a></li>
			               <li><a href="http://www.betterrecipes.com/sponsored-recipes/">Sponsored Recipes</a></li>
			           </ul>
					</li>
					<li class="li-top"><a href="http://www.betterrecipes.com/blogs/daily-dish/" class="top"><span>The Daily Dish</span></a></li>
					<li class="li-top"><a href="http://www.betterrecipes.com/contest/" class="top"><span>Recipe Contests</span></a></li>
					<li class="li-top"><a href="http://win.betterrecipes.com/" class="top"><span>Daily Sweeps</span></a></li>
					<li class="li-top"><a href="https://secure.recipes.betterrecipes.com/common/profile/quicksignup.jsp?regSource=8261" class="top"><span>Newsletters</span></a></li>
				</ul>
				<a href="http://recipes.betterrecipes.com/common/profile/login1.jsp?regSource=8260&absoluteLinkBrand=br" class="ML5"><img src="http://images.meredith.com/betterrecipes/images/template/buttons/login.gif" alt="Log In" title="Log In" /></a>
				<a href="http://recipes.betterrecipes.com/common/profile/regStep1.jsp?regSource=8260&absoluteLinkBrand=br" class="ML5"><img src="http://images.meredith.com/betterrecipes/images/template/buttons/joinnow.gif" alt="Join Now" title="Join Now" /></a>
				<div class="clearall"></div>
			</div>
		</div>
		<div class="clearall"></div>
	</div><!-- /header -->
	<div id="pagebody">
<!-- ---------[3 Column Layout]--------- -->
		<div id="contentwell">

			
			
			
			
			
		
			<!-- /contentwell -->	
		<!-- /pagebody -->
			
	<!-- /wrapper -->
<!-- /brbg -->	
<!-- /body -->
