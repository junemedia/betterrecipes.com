<?php
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
    <div class="header search-bar"> </div>

    <?php include_component('recipes', 'footer_categories') ?>

    <div class="nav lower pt20" id="ftr-acct">
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

    <div class="nav lower" id="ftr-social">
      <div class="title">BETTER RECIPES</div>
      <div class="links">
        <ul>
          <li><a href="http://twitter.com/BetterRecipes">Follow Us on Twitter</a></li>
          <li>&nbsp;|&nbsp;<a href="http://www.facebook.com/betterrecipes">Find Us on Facebook</a></li>
        </ul>
      </div>
    </div>

    <div class="nav lower pb20" id="ftr-recbox">
       <div class="title">&nbsp;</div>
      <div class="links">
        <ul>
          <li><a href="<?= getUrl('@myrecipebox') ?>">My Recipe Box</a></li>
        </ul>
      </div>
    </div>

    <div class="nav lower pt20" id="ftr-legal">
      <div class="title">&nbsp;</div>
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
