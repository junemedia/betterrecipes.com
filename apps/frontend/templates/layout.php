<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:fb="http://ogp.me/ns/fb#">
  <head>
    <? include_http_metas() ?>
    <? include_metas() ?>

    <?
    /*
      <script type='text/javascript'>
      var Muscula = Muscula || {};
      Muscula.settings = {
      logId:"1497"
      };
      (function () {
      var m = document.createElement('script'); m.type = 'text/javascript'; m.async = true;
      m.src = (window.location.protocol == 'https:' ? 'https:' : 'http:') +
      '//musculahq.appspot.com/Muscula.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(m, s);
      Muscula.run = function (s) { eval(s); Muscula.run = function () { }; };
      })();
      </script>
     */
    ?>
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
    <? //if (has_slot('video')): ?>
    <? //include_slot('video') ?>
    <? //endif; ?>
    <? //if (has_slot('multiselect')): ?>
    <? //include_slot('multiselect') ?>
    <? //endif; ?>
    <script src="http://cdn.gigya.com/JS/socialize.js?apikey=<?= sfConfig::get('app_gigya_api_key') ?>">  </script>
    <script>
      brmb.gigya.conf.APIKey = '<?= sfConfig::get('app_gigya_api_key') ?>';
    </script>
    <? if (sfConfig::get('sf_web_debug')): ?>
      <script>
        /*$(document).ready(function() {
          sfWebDebugToggleMenu();
        });*/
      </script>
    <? endif ?>
    <? include_component('adtags', 'header_code') ?>
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <?
    /*
    <!-- BEGIN Krux Control Tag for betterrecipes -->
    <script class="kxct" data-id="HzmEwRvl" data-version="async:1.7">
    window.Krux||((Krux=function(){Krux.q.push(arguments)}).q=[]);
    (function(){
      var k=document.createElement('script');k.type='text/javascript';k.async=true;
      var m,src=(m=location.href.match(/\bkxsrc=([^&]+)/))&&decodeURIComponent(m[1]);
      k.src = /^https?:\/\/([^\/]+\.)?krxd\.net(:\d{1,5})?\//i.test(src) ? src : src === "disable" ? "" :
        (location.protocol==="https:"?"https:":"http:")+"//cdn.krxd.net/controltag?confid=HzmEwRvl";
      var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(k,s);
    })();
    </script>
    <!-- END Krux Controltag -->
    <!-- BEGIN Krux Interchange Tag config -->
    <script>
    window.Krux||((Krux=function(){Krux.q.push(arguments);}).q=[]);
    (function(){
      function retrieve(n){
        var m, k='kx'+n;
        if (window.localStorage){
          return window.localStorage[k] || "";
        } else if (navigator.cookieEnabled) {
          m = document.cookie.match(k+'=([^;]*)');
          return (m && unescape(m[1])) || "";
        } else {
          return '';
        }
      }
      var kvs = [];
      Krux.user = retrieve('user');
      if (Krux.user) {
        kvs.push('u=' + Krux.user);
      }
      Krux.segments = retrieve('segs') && retrieve('segs').split(',') || [];
      for (var i = 0; i < Krux.segments.length; i++){
        kvs.push('ksgmnt=' + Krux.segments[i]);
      }
      Krux.dartKeyValues = kvs.length ? kvs.join(';') + ';': '';
    })();
    </script>
    <!-- END Krux Interchange config -->
    */
    ?>

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
    <? /*<script src="http://cdn.yb0t.com/p/d45f/js/interstitial-config.js"></script>*/ ?>
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
	  
	  <div class="banner" style="padding-bottom:15px;"><center>

      <!--/* OpenX Asynchronous JavaScript tag */-->

      <script type="text/javascript">
        var LB_BTF_Params = {ybot_slot:"LB_BTF", ybot_size:"", ybot_cpm:""};
        try{
          LB_BTF_Params = yieldbot.getSlotCriteria('LB_BTF');
        }catch(e){/*ignore*/}
      </script>

      <div id="537278267_728x90_BTF" style="width:728px;height:90px;margin:0;padding:0">
        <noscript>
          <iframe id="68f77ad32d" name="68f77ad32d" src="//junemedia-d.openx.net/w/1.0/afr?auid=537278267&cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="728" height="90">
            <a href="//junemedia-d.openx.net/w/1.0/rc?cs=68f77ad32d&cb=INSERT_RANDOM_NUMBER_HERE" >
              <img src="//junemedia-d.openx.net/w/1.0/ai?auid=537278267&cs=68f77ad32d&cb=INSERT_RANDOM_NUMBER_HERE" border="0" alt="">
            </a>
          </iframe>
        </noscript>
      </div>
      <script type="text/javascript">
        var OX_ads = OX_ads || [];
        OX_ads.push({
          slot_id: "537278267_728x90_BTF",
          auid: "537278267",
          vars: {"ybot_slot":LB_BTF_Params.ybot_slot, "ybot_size": LB_BTF_Params.ybot_size, "ybot_cpm": LB_BTF_Params.ybot_cpm}
        });
      </script>

      <script type="text/javascript" src="//junemedia-d.openx.net/w/1.0/jstag"></script>
		</center></div>
	  
    </div><!-- /#main-content -->
    <? include_partial('global/footer') ?>
    <!-- BEGIN BAYNOTE INCLUDE -->
<!--
    <script src="<?= getDomainUri() . '/js/baynote.js' ?>" ></script>
-->
    <!-- END BAYNOTE INCLUDE -->
    <? include_partial('global/omniture') ?>
    <? include_partial('global/ga') ?>
    
    <!--<script>Meebo('domReady');</script>-->

   
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

    <!-- Begin comScore Tag -->
    <script>
      var _comscore = _comscore || [];
      _comscore.push({ c1: "2", c2: "6036305" });
      (function() {
        var s = document.createElement("script"), el = document.getElementsByTagName("script")[0]; s.async = true;
        s.src = (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js";
        el.parentNode.insertBefore(s, el);
      })();
    </script>
    <noscript>
      <img src="http://b.scorecardresearch.com/p?c1=2&amp;c2=6036305&amp;cv=2.0&amp;cj=1" />
    </noscript>
    <!-- End comScore Tag -->

    <? include_partial('global/swoop') ?>
    <? include_partial('global/underdog') ?>
    <? include_partial('global/liveconnect') ?>

  </body>
</html>
