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
    
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
	<!-- Google Tag Manager -->
	<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-W6SMSQ"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-W6SMSQ');</script>
	<!-- End Google Tag Manager -->
  	<!-- LAYOUT NAKED -->
        
    	<?php echo $sf_content ?>
        
   <? //include_partial('global/omniture') ?> 
   <!-- LAYOUT NAKED -->
  </body>
</html>
