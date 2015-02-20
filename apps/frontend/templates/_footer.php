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
  <div class="banner"><center>

<!--/* OpenX Asynchronous JavaScript tag */-->

<!-- /*
 * The tag in this template has been generated for use on a
 * non-SSL page. If this tag is to be placed on an SSL page, change the
 * 'http://ox-d.junemedia.com/...'
 * to
 * 'https://ox-d.junemedia.com/...'
 */ -->

<div id="537278267_728x90_BTF" style="width:728px;height:90px;margin:0;padding:0">
  <noscript><iframe id="0c7bcf3452" name="0c7bcf3452" src="http://ox-d.junemedia.com/w/1.0/afr?auid=537278267&cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="728" height="90"><a href="http://ox-d.junemedia.com/w/1.0/rc?cs=0c7bcf3452&cb=INSERT_RANDOM_NUMBER_HERE" ><img src="http://ox-d.junemedia.com/w/1.0/ai?auid=537278267&cs=0c7bcf3452&cb=INSERT_RANDOM_NUMBER_HERE" border="0" alt=""></a></iframe></noscript>
</div>
<script type="text/javascript">
  var OX_ads = OX_ads || [];
  OX_ads.push({
     slot_id: "537278267_728x90_BTF",
     auid: "537278267"
  });
</script>

<script type="text/javascript" src="http://ox-d.junemedia.com/w/1.0/jstag"></script>
    </center></div>
    <? include_component('recipes', 'footer_categories') ?>
    <div class="nav lower pt20">
      <div class="title">YOUR ACCOUNT</div>
      <div class="links">
        <ul>
          <li><a href="<?= getUrl('@help') ?>">Help Resources</a></li>
          <li>&nbsp;|&nbsp;<a href="https://w1.buysub.com/servlet/CSGateway?cds_mag_code=BHG">Update Your Account</a></li>
          <li>&nbsp;|&nbsp;<a href="<?= getSignupUri($sf_request->getUri()) ?>">Register</a></li>
          <li>&nbsp;|&nbsp;<a href="https://secure.recipes.betterrecipes.com/common/profile/quicksignup.jsp?regSource=8261">Free Newsletters</a></li>
          <li>&nbsp;|&nbsp;<a href="https://w1.buysub.com/servlet/CSGateway?cds_mag_code=BHG">Customer Service</a></li>
          <li id="footer_login"></li>
          <li>&nbsp;|&nbsp;<a href="http://www.meredith.com/datapolicy.html">Data Policy</a></li>
          <li>&nbsp;|&nbsp;<a href="http://www.meredith.com/privacy.html">Privacy Policy - New!</a></li>
          <li>&nbsp;|&nbsp;
            <!--
             Ghostery Inc tag
             cid: 1333
             pid: 282
            -->
            <a id="_bapw-link" href="#" target="_blank"><img id="_bapw-icon" style="border:0 !important;display:inline !important;vertical-align:middle !important;padding-right:5px !important;"/><span style="vertical-align:middle !important">AdChoices</span></a>
            <script type="text/javascript">
            (function() {
                var ev = document.createElement('script'); ev.type = 'text/javascript'; ev.async = true; ev.setAttribute('data-ev-tag-pid', 282); ev.setAttribute('data-ev-tag-ocid', 1333);
                ev.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'c.betrad.com/pub/tag.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ev, s);
            })();
            </script>
          </li>
        </ul>
      </div>
    </div>
    <div class="nav lower">
      <div class="title">BETTER RECIPES</div>
      <div class="links">
        <ul>
          <li><a href="http://twitter.com/BetterRecipes">Follow Us on Twitter</a></li>
          <li>&nbsp;|&nbsp;<a href="http://www.facebook.com/betterrecipes">Find Us on Facebook</a></li>
          <li>&nbsp;|&nbsp;<a href="http://www.bhg.com/bhg/file.jsp?item=/partner/srds/index&temp=noo">Advertise</a></li>
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
    <? if ($is_hp): ?>
      <div class="nav lower">
        <div class="title">BETTER HOME & GARDENS NETWORK</div>
        <div class="links">
          <ul>
            <li><a href="http://www.bhg.com/" title="">BHG.com</a></li>
            <li>&nbsp;|&nbsp;<a href="http://www.midwestliving.com">MidwestLiving.com</a></li>
            <li>&nbsp;|&nbsp;<a href="http://www.traditionalhome.com">TraditionalHome.com</a></li>
            <li>&nbsp;|&nbsp;<a href="http://www.scrapbooksetc.com">ScrapbooksEtc.com</a></li>
            <li>&nbsp;|&nbsp;<a href="http://www.allpeoplequilt.com">AllPeopleQuilt.com</a></li>
            <li>&nbsp;|&nbsp;<a href="http://www.diyadvice.com">DIYAdvice.com</a></li>
            <li>&nbsp;|&nbsp;<a href="http://www.homeandfamilynetwork.com">HomeAndFamilyNetwork.com</a></li>
          </ul>
        </div>
      </div>
    <? endif; ?>
    <div class="nav lower">
      <div class="title">FOOD & RECIPE NETWORK</div>
      <div class="links">
        <ul>
          <li><a href="http://www.recipe.com/" title="">Recipe.com</a></li>
          <li>&nbsp;|&nbsp;<a href="http://www.eatingwell.com/">EatingWell.com</a></li>
          <li>&nbsp;|&nbsp;<a href="<?= getDomainUri() ?>">BetterRecipes.com</a></li>
          <li>&nbsp;|&nbsp;<a href="http://www.rachaelraymag.com/">RachaelRayMag.com</a></li>
          <li>&nbsp;|&nbsp;<a href="http://www.diabeticlivingonline.com/">DiabeticLivingOnline.com</a></li>
        </ul>
      </div>
    </div>
    <? if ($is_hp): ?>
      <div class="nav lower">
        <div class="title">PARENTS NETWORK</div>
        <div class="links">
          <ul>
            <li><a href="http://www.parents.com" title="">Parents.com</a></li>
            <li>&nbsp;|&nbsp;<a href="http://www.familycircle.com">FamilyCircle.com</a></li>
            <li>&nbsp;|&nbsp;<a href="http://www.topbabynames.com">TopBabyNames.com</a></li>
            <li>&nbsp;|&nbsp;<a href="http://serpadres.com">SerPadres.com</a></li>
          </ul>
        </div>
      </div>
      <div class="nav lower">
        <div class="title">REAL GIRLS NETWORK</div>
        <div class="links">
          <ul>
            <li><a href="http://www.fitnessmagazine.com" title="">FitnessMagazine.com</a></li>
            <li>&nbsp;|&nbsp;<a href="http://www.divinecaroline.com">DivineCaroline.com</a></li>
            <li>&nbsp;|&nbsp;<a href="http://www.more.com">More.com</a></li>
            <li>&nbsp;|&nbsp;<a href="http://lhj.com">LHJ.com</a></li>
            <li>&nbsp;|&nbsp;<a href="http://siempremujer.com">SiempreMujer.com</a></li>
          </ul>
        </div>
      </div>
    <? endif; ?>
    <div class="nav lower pt20">
      <div class="title"><img src="/img/logo-womens-network.png" alt="Meredith Women's Network" class="mb0 pb20" style="vertical-align: middle;" /></div>
      <div class="links">
        <ul>
          <li>© Copyright <?= date('Y') ?>, Meredith Corporation.  All Rights Reserved</li>
          <li>&nbsp;|&nbsp;<a href="http://www.meredith.com/privacy.html">Privacy Policy - Your California Rights</a>&nbsp;|&nbsp;<a href="http://www.meredith.com/datapolicy.html">Data Policy</a>&nbsp;|&nbsp;<a href="<?= getUrl('@terms') ?>">Terms of Service</a>.</li>
        </ul>
      </div>
    </div>
  </div>
</div>
</div><!-- /#main-footer -->

<!-- BEGIN SiteCTRL Script tynt tag -->
<script type="text/javascript">
if(document.location.protocol=='http:'){
 var Tynt=Tynt||[];Tynt.push('cvyMIgHsSr5lQVacwqm_6l');
 (function(){var s=document.createElement('script');s.async="async";s.type="text/javascript";s.src='http://tcr.tynt.com/ti.js';var h=document.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);})();
}
</script>
<!-- END SiteCTRL Script -->



<!-- infolinks -->
<script type="text/javascript">
var infolinks_pid = 1863387;
var infolinks_wsid = 3;
</script>
<script type="text/javascript" src="http://resources.infolinks.com/js/infolinks_main.js"></script>
<!-- end infolinks -->