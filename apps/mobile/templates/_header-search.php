<header id="hd-search">
  <div class="ad320x40">
    <? include_partial('global/adtags/top'); ?>
  </div><!-- /.ad320x40 -->
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
</header><!-- /#search -->