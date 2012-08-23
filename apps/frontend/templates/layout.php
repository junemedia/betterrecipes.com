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
    <meta http-equiv="X-UA-Compatible" content="IE=8" />
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
    <script type="text/javascript" src="http://cdn.gigya.com/JS/socialize.js?apikey=<?= sfConfig::get('app_gigya_api_key') ?>">  </script> 
    <script type="text/javascript">  
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
  </head>
  <body>
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
    </div><!-- /#main-content -->
    <? include_partial('global/footer') ?>   
    <!-- BEGIN BAYNOTE INCLUDE -->
    <script type="text/javascript" src="<?= getDomainUri() . '/js/baynote.js' ?>" ></script>
    <!-- END BAYNOTE INCLUDE -->
    <? include_partial('global/omniture') ?>
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
    <script type="text/javascript">Meebo('domReady');</script>
        <? if ($this->moduleName != 'contests'): ?>
      <!-- Kontera ContentLink(TM);-->
      <script type='text/javascript'>
      var dc_AdLinkColor = 'blue' ;
      var dc_PublisherID = 185845 ; 
      </script>
      <script type='text/javascript' src='http://kona.kontera.com/javascript/lib/KonaLibInline.js'>
      </script>
      <!-- Kontera ContentLink(TM) -->
    <? endif ?>
    <? /* Google Analytics */ ?>
    <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-29730487-1']);
    _gaq.push(['_setDomainName', 'betterrecipes.com']);
    _gaq.push(['_trackPageview']);
    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
    </script>
    <!-- BEGIN Krux Control Tag for betterrecipes -->
    <script class="kxct" data-id="HzmEwRvl" data-version="async:1.7" type="text/javascript">
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
  </body>
</html>

