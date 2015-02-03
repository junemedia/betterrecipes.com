<?php
/**
 * @package WordPress
 * @subpackage BetterRecipes2011
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <!-- Begin Meebo sharebar -->
    <span id="meeboAfterBody"></span>
    <!-- End Meebo sharebar -->
    <!--  profile="http://gmpg.org/xfn/11" -->
    <title>
      <?php wp_title('&laquo;', true, 'right'); ?>
      <?php bloginfo('name'); ?>
    </title>
    <script type='text/javascript'>
        var Muscula = Muscula || {};
        Muscula.settings = {
            logId:"1497"
        };
        (function () {
            var m = document.createElement('script'); m.type = 'text/javascript'; m.async = true;
            m.src = (window.location.protocol == 'https:' ? 'https:' : 'http:') +
                '//musculahq.appspot.com/Muscula.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(m, s);
            Muscula.run = function (s) { eval(s); Muscula.run = function () { }; };
        })();
    </script>
    <!-- [Meta] -->
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <!-- [Stylesheets] -->
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory'); ?>/dev-assets/betterrecipes.css" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css"/>
    <link rel="stylesheet" type="text/css" media="print" href="<?php bloginfo('template_directory'); ?>/css/print.css" />
    <?php $brand = 'br'; ?>
	<?php include(ABSPATH . 'wp-content/krux.php'); ?>
    <!-- [WP HEAD] -->
    <?php if (is_singular()) wp_enqueue_script('comment-reply'); wp_head(); ?>
    <!-- [Scripts] -->
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/dev-assets/jquery.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/dev-assets/betterrecipes.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/dailydish.js"></script>
    <script type="text/javascript" src="http://cdn.gigya.com/js/socialize.js?apiKey=2_t7ugJniPXN32-uUr2BkBDPmTa-oo6VVzt2Gl2MFyw-N8bgqbxzpADm4C1F_6gD51"></script>
    <script type="text/javascript">
      var conf=
        { 
        APIKey: '2_t7ugJniPXN32-uUr2BkBDPmTa-oo6VVzt2Gl2MFyw-N8bgqbxzpADm4C1F_6gD51'
      }
    </script>
    <? $category = get_the_category(); ?>
    <? $blogname = get_bloginfo('name'); ?>
    <? $blogname = htmlspecialchars_decode($blogname, ENT_QUOTES); ?>
    <? $blogname = preg_replace('/[^a-zA-Z0-9-]/', '', $blogname); ?>
    <? $blogcat = $category[0]->cat_name; ?>
    <? $blogcat = htmlspecialchars_decode($blogcat, ENT_QUOTES); ?>
    <? $blogcat = preg_replace('/[^a-zA-Z0-9-]/', '', $blogcat); ?>

    <script type="text/javascript">
gigya.reporting = gigya.reporting || {};
//Legacy Gigya event, do not use
//gigya.reporting.onShareButtonClicked = function(event) {
//		if (event.shareItem.provider) {
//			var provider = event.shareItem.provider;
//			s.linkTrackVars = "events,eVar37,eVar44";
//			s.linkTrackEvents = "event37";
//			s.events = "event37";
//			s.eVar37 = provider + ": Share Button Clicked";
//			s.eVar44 = s.prop11;
//			s.tl(this, 'o', s.eVar37);
//			s.linkTrackVars = s.linkTrackEvents = "None";
//			s.events = s.eVar37 = s.eVar44 = "";
//		}
//};
gigya.reporting.onSendDone = function(event) {
		if (event.providers) {
			var providers = event.providers.split(",");
			for (i = 0; i < providers.length; i++) {
				var provider = providers[i];
				s.linkTrackVars = "events,eVar37,eVar44";
				s.linkTrackEvents = "event37";
				s.events = "event37";
				s.eVar37 = provider + ": Share Published";
				s.eVar44 = s.prop11;
				s.tl(this, 'o', s.eVar37);
				s.linkTrackVars = s.linkTrackEvents = "None";
				s.events = s.eVar37 = s.eVar44 = "";
			}
		}
};
gigya.socialize.addEventHandlers({ onConnectionAdded: gigya.reporting.onSendDone });
</script>
  </head>
  <body>
    <!-- start body -->
    <!-- Begin Meebo sharebar open span -->
    <span id="meeboAfterBody"></span>
    <!-- End Meebo sharebar open span -->
    <div id="main-header">
      <div class="wrapper">
        <div class="sign-in">
          <ul class="hornav members">
            <li><a href="http://www.betterrecipes.com/signin" title="Log into your Better Recipes account" class="first">LOGIN</a></li>
            <li><a href="http://www.betterrecipes.com/signup" title="Create your Better Recipes account" >REGISTER</a></li>
			<li style="margin-left:10px;"><a href="http://www.betterrecipes.com/recipes/new" title="Add your own recipe">ADD RECIPE</a></li>
          </ul>
          <!-- /members nav -->
          <ul class="hornav social">
            <li>FOLLOW US:</li>
            <li><a href="http://www.facebook.com/betterrecipes" title="Follow us on Facebook" class="cta-fb">Facebook</a></li>
            <li class="bdrt"><a href="http://www.twitter.com/betterrecipes" title="Follow us on Twitter" class="cta-tw">Twitter</a></li>
            <li><a href="https://secure.recipes.betterrecipes.com/common/profile/quicksignup.jsp?regSource=8261" title="Sign up for our newsletter" class="cta-nl">SIGN UP FOR OUR NEWSLETTER</a></li>
          </ul>
          <!-- /social nav -->
        </div>
        <!-- /.sign-in -->
        <div class="logo-space">
          <h1><a href="http://www.betterrecipes.com" title="Better Recipes"><img src="/blogs/daily-dish/wp-content/themes/BetterRecipes2/dev-assets/img/logo-betterrecipes.png" alt="BetterRecipes : better recipes - better meals"  /></a></h1>
          <div class="hd-ad">
		  	
				<!--/* OpenX Asynchronous JavaScript tag */-->

				<!-- /*
				 * The tag in this template has been generated for use on a
				 * non-SSL page. If this tag is to be placed on an SSL page, change the
				 * 'http://ox-d.junemedia.com/...'
				 * to
				 * 'https://ox-d.junemedia.com/...'
				 */ -->

				<div id="537278266_728x90_ATF" style="width:728px;height:90px;margin:0;padding:0">
				  <noscript><iframe id="0f4e0bd8bb" name="0f4e0bd8bb" src="http://ox-d.junemedia.com/w/1.0/afr?auid=537278266&cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="728" height="90"><a href="http://ox-d.junemedia.com/w/1.0/rc?cs=0f4e0bd8bb&cb=INSERT_RANDOM_NUMBER_HERE" ><img src="http://ox-d.junemedia.com/w/1.0/ai?auid=537278266&cs=0f4e0bd8bb&cb=INSERT_RANDOM_NUMBER_HERE" border="0" alt=""></a></iframe></noscript>
				</div>
				<script type="text/javascript">
				  var OX_ads = OX_ads || [];
				  OX_ads.push({
					 slot_id: "537278266_728x90_ATF",
					 auid: "537278266"
				  });
				</script>

				<script type="text/javascript" src="http://ox-d.junemedia.com/w/1.0/jstag"></script>			
				<!-- end openx -->
				
			
		  </div>
        </div>
        <!-- /.logo-space -->
        
                                   
                                   
                 <div class="search-bar">
       
<ul class="hornav upsell">
  <li class="recipes"><a href="http://www.betterrecipes.com/recipes" >RECIPES</a></li>
  <li class="dd"><a href="http://www.betterrecipes.com/blogs/daily-dish" >THE DAILY DISH</a></li>
  <li class="contests"><a href="http://www.betterrecipes.com/contests" >CONTEST</a></li>
  <li class="sweeps"><a href="http://win.betterrecipes.com">SWEEPSTAKES</a></li>
</ul>
<!--</div><!-- /.search-bar -->
<!--<ul class="mb-nav hornav">-->
<!--</ul>-->      <form id="hd-search" action="http://www.betterrecipes.com/search" method="get" onsubmit="return validateSearch(this)">
        <input type="text" value="Search for recipe" name="term" onFocus="clearText(this)" onBlur="clearText(this)" />
        <input type="hidden" name="PageType" value="Recipe" />
        <input type="submit" value="SEARCH" class="cssbutton" />
      </form>
    </div> <!-- /.search-bar -->
                  
                                   
                  <!--                 
                  <div class="banner">
                    <? //include('ad-1000x45.php'); ?>
                  </div><!-- /.banner -->
				  
                  </div><!-- /.wrapper -->
                  </div><!-- /#main-header -->
                  <div id="main-content" class="recipe-detail">
                    <div id="theme-wrap">
                      <div class="wrapper">
                        <div class="section">
                          <div class="masthead">
                            <a href="http://www.betterrecipes.com/blogs/daily-dish/"> <img title="The Daily Dish" alt="The Daily Dish" src="/img/br_dd_logo.png"> </a>
                          </div>
                          <!-- /.theme-wrap in footer.php -->        
                          <!-- /.section in footer.php -->
                          <!-- /.wrapper in footer.php -->
