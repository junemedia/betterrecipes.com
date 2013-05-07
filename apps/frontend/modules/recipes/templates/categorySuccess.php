<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div class="article">
  <? if ($sf_user->isAuthenticated() && $sf_user->getFbId() && $sf_user->getRegSourceAttribute('auth_token')): ?>
    <div id="friendRibbonContainer">
      <? include_component('opengraph', 'friendRibbon', array('results_per_page' => 10)) ?>
    </div><!-- // friendRibbonContainer -->
  <? endif; ?>
  <? include_partial('global/body_sharebar', compact('category')) ?>
  <? include_component('recipes', 'catlevel_category_block', compact('category')) ?>
  <div id="trending-recipes">
    <? include_component('opengraph', 'trendingRecipes', array('parent_category_id' => $category->getId())) ?>
  </div><!-- /#trending-recipes -->
  <? include_component('recipes', 'catlevel_recipes_slideshows', array('category_id' => $category->getId(), 'category_name' => $category->getName(), 'is_main_cat' => true)) ?>
  
  <? include_component('recipes', 'catlevel_slideshows', array('category_id' => $category->getId(), 'category_name' => $category->getName())) ?>
  
  <? //include_partial('stories', compact('stories', 'category')) ?>
  <? //include_partial('popular_stories', compact('category')) ?>
  <? include_partial('popular_blogs', compact('category')) ?>
</div><!-- /.section -->
<? include_partial('global/right_rail/right_rail') ?>
<? include_partial('opengraph/facebook_login_modal') ?>