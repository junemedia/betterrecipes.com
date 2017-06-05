<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:fb="http://ogp.me/ns/fb#">
  <head>
    <? include_http_metas() ?>
    <? include_metas() ?>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta property="og:site_name" content="Better Recipes"/>
    <meta property="fb:app_id" content="<?= sfConfig::get('app_facebook_appid'); ?>"/>
    <meta property="fb:admins" content="<?= sfConfig::get('app_facebook_admins'); ?>"/>
    <? if (has_slot('facebook_meta')): ?>
      <? include_slot('facebook_meta'); ?>
    <? endif; ?>
    <? include_title(); ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <? include_stylesheets() ?>
    <? include_javascripts() ?>

    <script src="http://cdn.gigya.com/JS/socialize.js?apikey=<?= sfConfig::get('app_gigya_api_key') ?>">  </script>
    <script>
      brmb.gigya.conf.APIKey = '<?= sfConfig::get('app_gigya_api_key') ?>';
    </script>

    <? include_component('adtags', 'header_code') ?>
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
      (function () {var k = document.createElement('script');k.type = 'text/javascript';k.async = true;var m, src = (m = location.href.match(/\bkxsrc=([^&]+)/)) && (m[1]);k.src = /^https?:\/\/([^\/]+\.)?krxd\.net(:\d{1,5})?\//i.test(src) ? src : src === "disable" ? "" : (location.protocol === "https:" ? "https:" : "http:") + "//cdn.krxd.net/controltag?confid=HzmEwRvl";var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(k, s);})(); </script>
    <!-- end krux tag -->

  <!-- Test comment -->

  <!-- Yieldbot.com Intent Tag -->
  <script type="text/javascript" src="https://cdn.yldbt.com/js/yieldbot.intent.js"></script>
  <script type="text/javascript">
      yieldbot.pub('d45f');
      yieldbot.defineSlot('LB');
      yieldbot.defineSlot('MR');
      yieldbot.defineSlot('LB_BTF');
      yieldbot.defineSlot('MR_BTF');
      yieldbot.defineSlot('MR_300x600');
      yieldbot.go();
  </script>
  <!-- END Yieldbot.com Intent Tag -->

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

  <? include_partial('global/header') ?>

  <div id="main-content">
    <div id="theme-wrap">
      <div class="wrapper">
        <div class="section">
          <? if ($sf_user->hasFlash('notice')): ?>
            <div class="flash notice">
              <?= $sf_user->getFlash('notice') ?>
            </div>
          <? elseif ($sf_user->hasFlash('error')): ?>
            <div class="flash error">
              <?= $sf_user->getFlash('error') ?>
            </div>
          <? endif ?>
          <?= $sf_content ?>
        </div><!-- /.section -->
      </div><!-- /.wrapper -->
    </div><!-- /#theme-wrap -->

    <div class="banner" style="padding-bottom:15px;">
      <center> <?php include_partial('global/adtags/outbrain_js') ?> </center>
    </div>
  </div><!-- /#main-content -->

  <? include_partial('global/footer') ?>
  <? include_partial('global/omniture') ?>
  <? include_partial('global/ga') ?>

  <script>
    /* <![CDATA[ */
    var _mb_site_guid = document.location.href.indexOf('resolute.com') > 0 ? '537a2a0e4370d27f28b3d4f6704f8ccb7f3f6a37cb35e81b058cb9a83642cc18' : '2dcab8563a168a3da605b518134a9fef5ede02393d2484f05f9727d7f5ee36f7';
    (function(d, t){
      var mb = d.createElement(t), s = d.getElementsByTagName(t)[0];
      mb.async = mb.src = '//cdn.linksmart.com/linksmart_2.3.0.min.js';
      s.parentNode.insertBefore(mb, s);
    }(document, 'script'));
    /* ]]> */
  </script>

  <script>
    var zflag_parent="zedo_loader";
    var zflag_vast_domain="http://xp1.zedo.com/";
    var zflag_nid="2340";
    var zflag_cid="127";
    var zflag_sz="85";
    var zflag_sid="44";
    var zflag_width="426";
    var zflag_height="340";
    var zflag_bchan="128";
    var zflag_breplay="1";
    var zflag_dimension="1";
  </script>
  <script src="http://c5.zedo.com/jsc/c5/frd.js"></script>


  <? include_partial('global/comscore') ?>
  <? include_partial('global/swoop') ?>
  <? include_partial('global/underdog') ?>
  <? include_partial('global/liveconnect') ?>
  <? include_partial('global/adtags/outbrain_js') ?>

</body>
</html>
