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
  	<div id="wrapper">
      <div id="masthead">
        <a href="<?= url_for('@homepage')?>"><img src="/img/meredithlogo.png" alt="meredith logo" /></a>
      </div>     
      <div class="auth-wrapper">
        <?= $sf_content ?>
      </div>
    </div>
  </body>
</html>
