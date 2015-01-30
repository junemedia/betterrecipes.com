<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <? include_http_metas() ?>
    <? include_metas() ?>
    <? include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <? include_stylesheets() ?>
    <? include_javascripts() ?>
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
    <div id="main-content">
      <div class="wrapper">
        <div class="section">
          <?= $sf_content ?>
        </div>
      </div>
    </div>
    <? include_partial('global/omniture') ?>
  </body>
</html>
