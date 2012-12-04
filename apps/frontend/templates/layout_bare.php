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