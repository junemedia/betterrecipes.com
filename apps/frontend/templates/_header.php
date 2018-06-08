<script>
  $(document).ready(function() {
    $("#header_user_area").load("<?= url_for('@refresh_user_area?template=header&referrer=' . urlencode($sf_request->getPathInfo())) ?>");
    $("#rr_user_area").load("<?= url_for('@refresh_user_area?template=rr&referrer=' . urlencode($sf_request->getPathInfo())) ?>");
  });
</script>

<div class="theme-facts">
  <p class="white ttupp fs16"><span class="first">Follow us:</span><a href="http://www.facebook.com/betterrecipes" title="Friend BetterRecipes on Facebook" class="second">Facebook</a><a href="http://www.twitter.com/betterrecipes" title="Follow BetterRecipes on Twitter" class="third">Twitter</a></p>
</div>

<div id="main-header">
  <div class="wrapper">
    <div class="sign-in">
      <ul id="header_user_area" class="hornav members"></ul><!-- /members nav -->
      <ul class="hornav social">
        <li>FOLLOW US:</li>
        <li><a href="http://pinterest.com/BetterRecipes/" target="_blank"><img src="http://passets-cdn.pinterest.com/images/small-p-button.png" width="16" height="16" alt="Follow us on Pinterest" style="padding:7px 7px 0 7px;" /></a></li>
        <li><a href="http://www.facebook.com/betterrecipes" title="Follow us on Facebook" class="cta-fb" target="_blank">Facebook</a></li>
        <li class="bdrt"><a href="http://www.twitter.com/betterrecipes" title="Follow us on Twitter" class="cta-tw" target="_blank">Twitter</a></li>
        <!--<li><a href="/email-signup" title="Sign up for our newsletter" class="cta-nl">SIGN UP FOR OUR NEWSLETTER</a></li>-->
      </ul><!-- /social nav -->
    </div><!-- /.sign-in -->

    <div class="logo-space">
      <h1><a href="<?= getHomepageUri() ?>" title="Better Recipes"><img src="/img/logo_betterrecipes.png" alt="BetterRecipes : better recipes - better meals" style="margin-top:35px; margin-left:10px"/></a></h1>

      <?php
      if ($sf_context->getRouting()->getCurrentRouteName() == 'signin' ||
          $sf_context->getRouting()->getCurrentRouteName() == 'signup') {
        // no op
      }
      else { ?>
      <div class="hd-ad ad728x90">
        <?php include_partial('global/adtags/openx_728x90atf') ?>
      </div>
      <?php } ?>
    </div><!-- /.logo-space -->

    <style>
      #main-header .wrapper .search-bars {
        background:url(/img/bg-mh-searchbar.jpg) repeat-y top left;
        width:100%;
        height:46px;
        margin-top:15px;
      }
      .search-bars form input[type=submit] {
        float:left;
        margin:10px 0 0 5px;
        max-width:78px;
        padding:3px 6px;
        background:#ebebeb url(/img/copy-search.png) no-repeat center;
        text-indent:-9999px;
        width:55px;
        filter:none;
        -ms-filter:none;
      }
      .search-bars form input[type=text] {
        margin:10px 0 0 21px;
        *margin:10px 0 0 13px;
        float:left;
      }
    </style>

    <div class="search-bars">
      <?php include_partial('global/navigation') ?>
      <form id="hd-search" action="<?= getDomainUri() . '/search' ?>" method="get" onsubmit="return validateSearch(this)">
        <input type="text" value="Search for recipe" name="term" onFocus="clearText(this)" onBlur="clearText(this)" />
        <input type="hidden" name="PageType" value="Recipe" />
        <input type="submit" value="SEARCH" class="cssbutton" />
      </form>
    </div> <!-- /.search-bar -->
    <div class="clearfix"></div>
  </div><!-- /.wrapper -->
</div><!-- /#main-header -->
