<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <? include_http_metas() ?>
    <? include_metas() ?>
    <? include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <? include_stylesheets() ?>
    <? include_javascripts() ?>
    <? if (sfConfig::get('sf_web_debug')): ?>
    <script>
      $(document).ready(function() {
        //sfWebDebugToggleMenu();
      });
    </script>
    <? endif ?>    
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
  	<div id="wrapper">
      <!-- Masthead -->
      <div id="masthead">
        <ul style="float:right">
          <li>Signed in as <?= $sf_user->getDisplayName() ?></li>
          <li><?= link_to('Signout' ,'signout') ?></li>
        </ul>
        <a href="<?=url_for('@homepage')?>"><img src="/img/meredithlogo.png" alt="meredith logo" /></a>
        <div id="searchBar">
          <form id="recipeSearch" action="<?=url_for("recipes/index") ?>">
            <input type="text" value="Search Recipe Titles" name="keywords" id="keywords"/>
            <input type="submit" class="btn-grey28" value="Search" />
          </form>
        </div>
      </div>
      <!-- End Masthead -->
        <!-- Navigation Bar -->
        <div id="navBar">
          <ul class="navButtons">
            <li><a href="<?=url_for("@rightrail_index") ?>" <? if ($this->moduleName == 'rightrail'): ?>class="selected"<? endif; ?>><div class="navText">Right Rail</div></a></li>
            <li><a href="<?=url_for("@category_index") ?>" class="<? if ($this->moduleName == 'categories'): ?> selected<? endif; ?>"><div class="navText">Recipe Categories</div></a></li>
            <li><a href="<?=url_for("@recipes_index") ?>" <? if ($this->moduleName == 'recipes' || $this->moduleName == 'recipephotos'): ?>class="selected"<? endif; ?>><div class="navText">Recipes</div></a></li>
            <li><a href="<?=url_for("@slideshows_index") ?>" <? if ($this->moduleName == 'slideshows'): ?>class="selected"<? endif; ?>><div class="navText">Slideshows</div></a></li>
            <li><a href="<?=url_for("@contests_index") ?>" <? if ($this->moduleName == 'contests'): ?>class="selected"<? endif; ?>><div class="navText">Contests</div></a></li>
            <li><a href="<?=url_for("@articles_index") ?>" <? if ($this->moduleName == 'articles'): ?>class="selected"<? endif; ?>><div class="navText">Articles</div></a></li>
            <li><a href="<?=url_for("@meta_index") ?>" <? if ($this->moduleName == 'meta'): ?>class="selected"<? endif; ?>><div class="navText">Meta</div></a></li>
            <li><a href="<?=url_for("@sponsors_index") ?>" <? if ($this->moduleName == 'sponsors'): ?>class="selected"<? endif; ?>><div class="navText">Sponsors</div></a></li>
            <li><a href="<?=url_for("administrators") ?>" <? if ($this->actionName == 'administrators'): ?>class="selected"<? endif; ?>><div class="navText">Admins</div></a></li>
            <li><a href="<?=url_for("@users_index") ?>" <? if ($this->moduleName == 'users' && $this->actionName == 'index'): ?>class="selected"<? endif; ?>><div class="navText">Users</div></a></li>
            <li><a href="<?=url_for("@polls_list") ?>" <? if ($this->moduleName == 'polls' && $this->actionName == 'index'): ?>class="selected"<? endif; ?>><div class="navText">Polls</div></a></li>
            <li><a href="<?=url_for("@wonders_index") ?>" <? if ($this->moduleName == 'wonders'): ?>class="selected"<? endif; ?>><div class="navText">Wonders</div></a></li>
            <li><a href="<?=url_for("@tips_index") ?>" <? if ($this->moduleName == 'tips'): ?>class="selected"<? endif; ?>><div class="navText">Tips</div></a></li>
          </ul>
        </div> <!-- end navbar -->  
      <?= $sf_content ?>
      <div id="footer"></div>
    </div> <!-- end wrapper -->
    
  </body>
</html>
