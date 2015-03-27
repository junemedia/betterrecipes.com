<?
$host_parts = explode('.', $sf_request->getHost());
$is_hp = ($sf_request->getParameter('module') == 'home' && $host_parts[0] == 'www') ? true : false;
?>
<script>
  $(document).ready(function() {
    logged_in = '&nbsp;|&nbsp;<a href="<?= getSignoutUri($sf_request->getUri()) ?>">Log Out</a>';
    logged_out = '&nbsp;|&nbsp;<a href="<?= getSigninUri($sf_request->getUri()) ?>">Log in</a>';
    $.getJSON("<?= url_for('@get_auth_info') ?>", function(data) {
      if(data["is_authenticated"]){
        $("#footer_login").html(logged_in);
      } else {
        $("#footer_login").html(logged_out);
      }
    });
  });
</script>
<!--INFOLINKS_OFF-->
<div id="main-footer">
  <div class="wrapper pb60">
    <div class="header search-bar">
	<!--
      <form id="ft-search" action="<?= getDomainUri() . '/search' ?>" method="get" onsubmit="return validateSearch(this)">
        <input type="text" value="Search for recipe" name="term" onFocus="clearText(this)" onBlur="clearText(this)" />
        <input type="hidden" name="PageType" value="Recipe" />
        <input type="submit" value="SEARCH" class="cssbutton" />
      </form>
	-->
    </div>
  
    <? include_component('recipes', 'footer_categories') ?>
    <div class="nav lower pt20">
      <div class="title">YOUR ACCOUNT</div>
      <div class="links">
        <ul>
          <li><a href="<?= getUrl('@help') ?>">Help Resources</a></li>
          <li>&nbsp;|&nbsp;<a href="<?= getSignupUri($sf_request->getUri()) ?>">Register</a></li>
          <li>&nbsp;|&nbsp;<a href="/email-signup">Free Newsletters</a></li>
          <li id="footer_login"></li>         
          <li>&nbsp;|&nbsp;<a href="<?= getUrl('@privacy-policy') ?>">Privacy Policy - New!</a></li>
          
        </ul>
      </div>
    </div>
    <div class="nav lower">
      <div class="title">BETTER RECIPES</div>
      <div class="links">
        <ul>
          <li><a href="http://twitter.com/BetterRecipes">Follow Us on Twitter</a></li>
          <li>&nbsp;|&nbsp;<a href="http://www.facebook.com/betterrecipes">Find Us on Facebook</a></li>          
        </ul>
      </div>
    </div>
    <div class="nav lower pb20">
       <div class="title">&nbsp;</div>
      <div class="links">
        <ul>
         <?php /* <li><a href="<?= getUrl('@rewards') ?>">Challenges</a></li> */ ?>
          <li><a href="<?= getUrl('@myrecipebox') ?>">My Recipe Box</a></li>
        </ul>
      </div>
    </div>
      
    <div class="nav lower pt20">
      <div class="title"><img src="/img/logo-womens-network.png" alt="Meredith Women's Network" class="mb0 pb20" style="vertical-align: middle; visibility: hidden;" /></div>
      <div class="links">
        <ul>
          <li>© Copyright <?= date('Y') ?>, June Media Inc.  All Rights Reserved</li>
          <li>&nbsp;|&nbsp;<a href="<?= getUrl('@privacy-policy') ?>">Privacy Policy </a>&nbsp;|&nbsp;<a href="<?= getUrl('@terms') ?>">Terms of Service</a>.</li>
        </ul>
      </div>
    </div>
  </div>
</div>
</div><!-- /#main-footer -->
<!--INFOLINKS_ON-->

<!-- BEGIN SiteCTRL Script tynt tag -->
<script type="text/javascript">
/*
if(document.location.protocol=='http:'){
 var Tynt=Tynt||[];Tynt.push('cvyMIgHsSr5lQVacwqm_6l');
 (function(){var s=document.createElement('script');s.async="async";s.type="text/javascript";s.src='http://tcr.tynt.com/ti.js';var h=document.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);})();
}
*/
</script>
<!-- END SiteCTRL Script -->



<!-- infolinks -->
<script type="text/javascript">
var infolinks_pid = 1863387;
var infolinks_wsid = 3;
</script>
<script type="text/javascript" src="http://resources.infolinks.com/js/infolinks_main.js"></script>
<!-- end infolinks -->