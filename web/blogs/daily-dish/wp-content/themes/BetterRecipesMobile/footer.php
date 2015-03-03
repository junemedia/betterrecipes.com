</div><!-- /#main-content -->



<footer id="main-footer">
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
  <div class="ad320x40">
    <!-- BEGIN: Bottom ad tag: -->
	<script type="text/javascript" src="http://ad.mo.doubleclick.net/N3865/dartproxy/mobile.handler?k=br.mob/;site=br;id=br1000;pos=bot;tile=2;sz=3x3;ord=[?];dw=1"></script>
	<!-- END: Bottom ad tag: -->
  </div><!-- /.ad320x40 -->
  <p><a href="http://www.betterrecipes.com/auth/viewfullsite" title="View the full version of this website" class="pt5 pb5 block">View Full Site</a></p>
  <p>&copy; Copyright 2011, <a href="http://www.meredith.com" target="_blank" title="Learn more about the Meredith Coporation">Meredith Corporation</a></p>
  <p>All Rights Reserved. <a href="http://www.betterrecipes.com/privacy-policy" title="Read our Privacy Policy">Privacy Policy</a></p>
  <p>By using this site, you agree to our <a href="http://www.betterrecipes.com/terms" title="Read our Terms of Service">Terms of Service</a></p>
  <p id="resolution"></p><!-- FOR TESTING PORPOSES, needs to be deleted before launch -->
</footer><!-- /#main-footer -->
           
           
<?php wp_footer(); ?>
<?php
	$jspath = "http://win.betterrecipes.com/js/s_code_br.js";
	//$jspath = "http://www.bhg.com/web/bhg/js/s_code_bhgH.js";
	$servername = "www.betterrecipes.com";
	include(ABSPATH . 'wp-content/omniture.php');
?>

<? if (strpos($_SERVER['HTTPS'], 'on') === false): ?>
  <!-- BEGIN CROWD_SCIENCE INCLUDE -->
  <script type="text/javascript">
    (function() {
      var cs = document.createElement('script'); cs.type = 'text/javascript';
      cs.async = true;
      cs.src = ('https:' == document.location.protocol ?  'https://secure-' : 'http://') +
        'static.crowdscience.com/start-fa76ad0aab.js'
      var s = document.getElementsByTagName('script')[0];          
      s.parentNode.insertBefore(cs,s);
    })();
  </script>
  <!-- END CROWD_SCIENCE INCLUDE -->
<? endif ?>
</body>
</html>