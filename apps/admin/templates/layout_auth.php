<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <? include_http_metas() ?>
  <? include_metas() ?>
  <? include_title() ?>
  <link rel="shortcut icon" href="/img/favicon.ico" />
  <? include_stylesheets() ?>
  <? include_javascripts() ?>
  <? if (sfConfig::get('sf_web_debug')): ?>
  <script>
    $(document).ready(function() {
      sfWebDebugToggleMenu();
    });
  </script>
  <? endif ?>
</head>
<body>
  <!-- Google Tag Manager -->
  <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-5VTT4K" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-5VTT4K');</script>
  <!-- End Google Tag Manager -->

  <div id="wrapper">
    <!-- Masthead -->
    <div id="masthead">
      <a href="<?= url_for('@homepage')?>"><img src="/img/logo_betterrecipes.png" alt="BetterRecipes logo" /></a>
    </div>
    <!-- End Masthead -->

    <div class="auth-wrapper">
      <?= $sf_content ?>
    </div>
  </div>
</body>
</html>
