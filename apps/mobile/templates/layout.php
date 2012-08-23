<!doctype html>
  <!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
  <!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
  <!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
  <!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame. Remove this if you use the .htaccess -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <?php //include_http_metas() ?>
    <?php include_metas() ?>
    <meta name="viewport" content="width=device-width, user-scalable=1, initial-scale=1.0, minimal-scale=1, maximum-scale=1, target-densityDpi=device-dpi" />
    <meta property="og:site_name" content="Better Recipes"/>
    <meta property="fb:app_id" content="<?= sfConfig::get('app_facebook_appid'); ?>"/>
    <? if (has_slot('facebook_meta')): ?>
      <? include_slot('facebook_meta'); ?>
    <? endif; ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
     <? if (has_slot('video')): ?>
      <? include_slot('video') ?>
    <? endif; ?>
    <script type="text/javascript" src="http://cdn.gigya.com/JS/socialize.js?apikey=<?= sfConfig::get('app_gigya_api_key') ?>">  </script>  
    <script type="text/javascript">  
      brmb.gigya.conf.APIKey = '<?= sfConfig::get('app_gigya_api_key') ?>';  
    </script> 
  </head>
  <body>
  	<? include_partial('global/header-main') ?>
  	<? include_partial('global/header-search') ?>
  	<? if ($this->moduleName != 'auth'): ?>
  		<? include_partial('global/header-jump') ?>
  	<? endif; ?>
  	<div id="main-content">
  		<? if ($sf_user->hasFlash('notice')): ?>
          <div class="flash notice">
            <?= $sf_user->getFlash('notice') ?>
          </div>
        <? elseif ($sf_user->hasFlash('error')): ?>
          <div class="flash error">
            <?= $sf_user->getFlash('error') ?>
          </div>
        <? endif ?>
        <? //include_partial('global/header_user_area') ?>
        <? include_component('auth', 'header_user_area') ?>
        
    	<?php echo $sf_content ?>
    </div><!-- /#main-content -->
    <? include_partial('global/footer-main') ?>
    
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

  </body>
</html>
