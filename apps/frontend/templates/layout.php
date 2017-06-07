<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:fb="http://ogp.me/ns/fb#">
<head>
  <?php include_http_metas() ?>
  <?php include_metas() ?>

  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta property="og:site_name" content="Better Recipes"/>
  <meta property="fb:app_id" content="<?= sfConfig::get('app_facebook_appid'); ?>"/>
  <meta property="fb:admins" content="<?= sfConfig::get('app_facebook_admins'); ?>"/>

  <?php if (has_slot('facebook_meta')): ?>
    <?php include_slot('facebook_meta'); ?>
  <?php endif; ?>
  <?php include_title(); ?>
  <link rel="shortcut icon" href="/favicon.ico" />
  <?php include_stylesheets() ?>
  <?php include_javascripts() ?>

  <script src="http://cdn.gigya.com/JS/socialize.js?apikey=<?= sfConfig::get('app_gigya_api_key') ?>">  </script>

  <script>
    brmb.gigya.conf.APIKey = '<?= sfConfig::get('app_gigya_api_key') ?>';
  </script>

  <?php include_component('adtags', 'header_code') ?>

  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  <!-- Facebook Conversion Code for BetterRecipes Tracker -->
  <script>
    var fb_param = {};
    fb_param.pixel_id = '6012117290081';
    fb_param.value = '0.00';
    fb_param.currency = 'USD';
    (function(){
      var fpw = document.createElement('script');
      fpw.async = true;
      fpw.src = '//connect.facebook.net/en_US/fp.js';
      var ref = document.getElementsByTagName('script')[0];
      ref.parentNode.insertBefore(fpw, ref);
    })();
  </script>
  <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/offsite_event.php?id=6012117290081&amp;value=0&amp;currency=USD" /></noscript>

  <!-- krux tag -->
  <script class="kxct" data-id="HzmEwRvl" data-version="async:1.7">window.Krux || ((Krux = function () {Krux.q.push(arguments)}).q = []);
    (function () {var k = document.createElement('script');k.type = 'text/javascript';k.async = true;var m, src = (m = location.href.match(/\bkxsrc=([^&]+)/)) && (m[1]);k.src = /^https?:\/\/([^\/]+\.)?krxd\.net(:\d{1,5})?\//i.test(src) ? src : src === "disable" ? "" : (location.protocol === "https:" ? "https:" : "http:") + "//cdn.krxd.net/controltag?confid=HzmEwRvl";var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(k, s);})();
  </script>
  <!-- end krux tag -->

  <?php include_partial('global/adtags/yieldbot_intent') ?>

</head>
<body>

  <!-- Google Tag Manager -->
  <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-5VTT4K"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-5VTT4K');</script>
  <!-- End Google Tag Manager -->

  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=120653551405606";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>

  <?php include_partial('global/header') ?>

  <div id="main-content">
    <div id="theme-wrap">
      <div class="wrapper">
        <div class="section">
          <?php if ($sf_user->hasFlash('notice')): ?>
            <div class="flash notice">
              <?= $sf_user->getFlash('notice') ?>
            </div>
          <?php elseif ($sf_user->hasFlash('error')): ?>
            <div class="flash error">
              <?= $sf_user->getFlash('error') ?>
            </div>
          <?php endif ?>
          <?= $sf_content ?>
        </div><!-- /.section -->
      </div><!-- /.wrapper -->
    </div><!-- /#theme-wrap -->

    <div class="banner" style="padding-bottom:15px;">
      <center> <?php include_partial('global/adtags/outbrain_js') ?> </center>
    </div>
  </div><!-- /#main-content -->

  <?php include_partial('global/footer') ?>

  <?php include_partial('global/omniture') ?>
  <?php include_partial('global/ga') ?>

  <?php include_partial('global/adtags/swoop') ?>
  <?php include_partial('global/adtags/underdog') ?>
  <?php include_partial('global/adtags/liveconnect') ?>
  <?php include_partial('global/adtags/tynt') ?>
  <?php include_partial('global/adtags/outbrain_js') ?>

</body>
</html>
