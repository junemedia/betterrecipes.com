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
        <?php /* <li><a href="<?php echo url_for('@signup_newsletter');?>" title="Sign up for our newsletter" class="cta-nl">SIGN UP FOR OUR NEWSLETTER</a></li> //*/ ?>
	<li><a href="https://secure.recipes.betterrecipes.com/common/profile/quicksignup.jsp?regSource=8261" title="Sign up for our newsletter" class="cta-nl">SIGN UP FOR OUR NEWSLETTER</a></li>
      </ul><!-- /social nav -->
    </div><!-- /.sign-in -->
    <div class="logo-space">
      <h1><a href="<?= getHomepageUri() ?>" title="Better Recipes"><img src="/img/logo-betterrecipes.png" alt="BetterRecipes : better recipes - better meals" /></a></h1>
      <? if ($sf_context->getRouting()->getCurrentRouteName() == 'signin' || $sf_context->getRouting()->getCurrentRouteName() == 'signup'): ?>

      <? else: ?>
        <div class="hd-ad ad728x90">
			<!--/* OpenX Asynchronous JavaScript tag */-->

			<!-- /*
			 * The tag in this template has been generated for use on a
			 * non-SSL page. If this tag is to be placed on an SSL page, change the
			 * 'http://ox-d.junemedia.com/...'
			 * to
			 * 'https://ox-d.junemedia.com/...'
			 */ -->
			 
			 <script type="text/javascript">
				var LB_Params = {ybot_slot:"LB", ybot_size:"", ybot_cpm:""};
				try{
					LB_Params = yieldbot.getSlotCriteria('LB');
				}catch(e){/*ignore*/}
			</script>

			<div id="537278266_728x90_ATF" style="width:728px;height:90px;margin:0;padding:0">
			  <noscript><iframe id="0f4e0bd8bb" name="0f4e0bd8bb" src="http://ox-d.junemedia.com/w/1.0/afr?auid=537278266&cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="728" height="90"><a href="http://ox-d.junemedia.com/w/1.0/rc?cs=0f4e0bd8bb&cb=INSERT_RANDOM_NUMBER_HERE" ><img src="http://ox-d.junemedia.com/w/1.0/ai?auid=537278266&cs=0f4e0bd8bb&cb=INSERT_RANDOM_NUMBER_HERE" border="0" alt=""></a></iframe></noscript>
			</div>
			<script type="text/javascript">
			  var OX_ads = OX_ads || [];
			  OX_ads.push({
				 slot_id: "537278266_728x90_ATF",
				 auid: "537278266",
				 vars: {"ybot_slot":LB_Params.ybot_slot, "ybot_size": LB_Params.ybot_size, "ybot_cpm": LB_Params.ybot_cpm}
			  });
			</script>

			<script type="text/javascript" src="http://ox-d.junemedia.com/w/1.0/jstag"></script>			
			<!-- end openx -->
			
        </div>
      <? endif; ?>
    </div><!-- /.logo-space -->
    <div class="search-bar">
      <? include_partial('global/navigation') ?>
      <form id="hd-search" action="<?= getDomainUri() . '/search' ?>" method="get" onsubmit="return validateSearch(this)">
        <input type="text" value="Search for recipe" name="term" onFocus="clearText(this)" onBlur="clearText(this)" />
        <input type="hidden" name="PageType" value="Recipe" />
        <input type="submit" value="SEARCH" class="cssbutton" />
      </form>
    </div> <!-- /.search-bar -->
    <? if ($sf_context->getRouting()->getCurrentRouteName() == 'signin' || $sf_context->getRouting()->getCurrentRouteName() == 'signup'): ?>

    <? else: ?>
	  <!--
      <div class="banner ad1000x45">
        <? include_partial('global/adtags/1000x45') ?>
      </div><!-- /.banner -->
    <? endif; ?>
    <div class="clearfix"></div>
  </div><!-- /.wrapper -->
</div><!-- /#main-header -->
