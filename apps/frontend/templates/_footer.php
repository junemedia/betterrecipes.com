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
      <form id="ft-search" action="<?= getDomainUri() . '/search' ?>" method="get" onsubmit="return validateSearch(this)">
        <input type="text" value="Search for recipe" name="term" onFocus="clearText(this)" onBlur="clearText(this)" />
        <input type="hidden" name="PageType" value="Recipe" />
        <input type="submit" value="SEARCH" class="cssbutton" />
      </form>
    </div>
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
          <li>&nbsp;|&nbsp;<a href="http://www.meredith.com/datapolicy.html" target="_blank">Data Policy</a></li>
          <li>&nbsp;|&nbsp;<a href="http://www.meredith.com/privacy.html" target="_blank">Privacy Policy</a></li>
          <li>&nbsp;|&nbsp;<a id="_bapw-link" href="#" target="_blank" style=""> <span style="vertical-align:middle !important;padding-right:2px;">AdChoices</span></a><img id="_bapw-icon" style="height:14px;border:0 !important;display:inline !important;vertical-align:middle !important"/><script>/*<![CDATA[*/(function(){var g=282,i=1333,a=false,h=document,j=h.getElementById("_bapw-link"),e=(h.location.protocol=="https:"),f=(e?"https":"http")+"://",c=f+(e?"a248.e.akamai.net/betterad.download.akamai.com/91609":"cdn.betrad.com")+"/pub/";function b(k){var d=new Image();d.src=f+"l.betrad.com/pub/p.gif?pid="+g+"&ocid="+i+"&i"+k+"=1&r="+Math.random()}h.getElementById("_bapw-icon").src=c+"icon1.png";j.onmouseover=function(){if(/#$/.test(j.href)){j.href="http://info.evidon.com/pub_info/"+g+"?v=1"}};j.onclick=function(){var k=window._bap_p_overrides;function d(n,q){var o=h.getElementsByTagName("head")[0]||h.documentElement,m=a,l=h.createElement("script");function p(){l.onload=l.onreadystatechange=null;o.removeChild(l);q()}l.src=n;l.onreadystatechange=function(){if(!m&&(this.readyState=="loaded"||this.readyState=="complete")){m=true;p()}};l.onload=p;o.insertBefore(l,o.firstChild)}if(k&&k.hasOwnProperty(g)){if(k[g].new_window){b("c");return true}}this.onclick="return "+a;d(f+"ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js",function(){d(c+"pub2.js",function(){BAPW.i(j,{pid:g,ocid:i})})});return a};b("i")}());/*]]>*/</script><script>/*<![CDATA[*/var _bap_p_overrides=_bap_p_overrides||{};if (document.location.protocol == 'https:'){_bap_p_overrides[282]={new_window:true};}/*]]>*/</script></li>
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
          <li>&copy; Copyright 2012, Meredith Corporation.  All Rights Reserved</li>
          <li>&nbsp;|&nbsp;By using this site, you agree to our <a href="<?= getUrl('@terms') ?>">Terms of Service</a>.</li>
        </ul>
      </div>
    </div>
  </div>
</div>
</div><!-- /#main-footer -->