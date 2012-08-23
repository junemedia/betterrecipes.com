<script>
  $(document).ready(function() { 
    logged_in = '<a href="<?= getSignoutUri($sf_request->getUri()) ?>">Log Out</a>';
    logged_out = '';
    $.getJSON("<?= url_for('@get_auth_info') ?>", function(data) {
      if(data["is_authenticated"]){
        $("#footer_login").html(logged_in);
      } else {
        $("#footer_login").html(logged_out);
      }
    });
  });
</script>
<footer id="main-footer">
  <div class="searchbox">
    <form action="<?= getDomainUri() . '/search' ?>" method="get">
      <input type="text" value="" placeholder="Search for recipe" name="term" onFocus="clearText(this)" onBlur="clearText(this)" />
      <input type="hidden" name="PageType" value="Recipe" />
      <input type="submit" value="SEARCH" />
    </form>
    <ul>
      <li><a href="http://www.facebook.com/betterrecipes" title="Find us on Facebook"><img src="/img/m/cta-facebook.jpg" height="28" width="28" alt="Facebook" /></a></li>
      <li><a href="http://www.twitter.com/betterrecipes" title="Find us on Twitter"><img src="/img/m/cta-twitter.jpg" height="30" width="29" alt="Twitter" /></a></li>
    </ul>
  </div><!-- /.searchbox -->
  <div class="ad320x40">
    <? include_partial('global/adtags/bottom'); ?>
  </div><!-- /.ad320x40 -->
  <p><a href="<?= url_for('@view_full_site') ?>" title="View the full version of this website" class="pt5 pb5 block">View Full Site</a></p>
  <p>&copy; Copyright 2011, <a href="http://www.meredith.com" target="_blank" title="Learn more about the Meredith Coporation">Meredith Corporation</a></p>
  <p>All Rights Reserved.&nbsp;
    <a href="http://www.meredith.com/privacy.html" target="_blank" title="Privacy Policy">Privacy Policy</a>,&nbsp;
    <a id="_bapw-link" href="#" target="_blank" style=""> <span style="vertical-align:middle !important;padding-right:2px;">AdChoices</span></a><img id="_bapw-icon" style="height:14px;border:0 !important;display:inline !important;vertical-align:middle !important"/><script>/*<![CDATA[*/(function(){var g=282,i=1333,a=false,h=document,j=h.getElementById("_bapw-link"),e=(h.location.protocol=="https:"),f=(e?"https":"http")+"://",c=f+(e?"a248.e.akamai.net/betterad.download.akamai.com/91609":"cdn.betrad.com")+"/pub/";function b(k){var d=new Image();d.src=f+"l.betrad.com/pub/p.gif?pid="+g+"&ocid="+i+"&i"+k+"=1&r="+Math.random()}h.getElementById("_bapw-icon").src=c+"icon1.png";j.onmouseover=function(){if(/#$/.test(j.href)){j.href="http://info.evidon.com/pub_info/"+g+"?v=1"}};j.onclick=function(){var k=window._bap_p_overrides;function d(n,q){var o=h.getElementsByTagName("head")[0]||h.documentElement,m=a,l=h.createElement("script");function p(){l.onload=l.onreadystatechange=null;o.removeChild(l);q()}l.src=n;l.onreadystatechange=function(){if(!m&&(this.readyState=="loaded"||this.readyState=="complete")){m=true;p()}};l.onload=p;o.insertBefore(l,o.firstChild)}if(k&&k.hasOwnProperty(g)){if(k[g].new_window){b("c");return true}}this.onclick="return "+a;d(f+"ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js",function(){d(c+"pub2.js",function(){BAPW.i(j,{pid:g,ocid:i})})});return a};b("i")}());/*]]>*/</script><script>/*<![CDATA[*/var _bap_p_overrides=_bap_p_overrides||{};if (document.location.protocol == 'https:'){_bap_p_overrides[282]={new_window:true};}/*]]>*/</script>
  </p>
  <p>By using this site, you agree to our <a href="<?= getUrl('@terms') ?>" title="Read our Terms of Service">Terms of Service</a></p>
  <p id="footer_login"></p>
  <p id="resolution"></p><!-- FOR TESTING PORPOSES, needs to be deleted before launch -->
</footer><!-- /#main-footer -->