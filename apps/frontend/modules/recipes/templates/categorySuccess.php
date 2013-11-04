<? slot('gpt') ?>

unitValues: {
                	channel: 'Recipe', /* Set to the top level category id, if applicable */
                
                	parent: '<?=UrlToolkit::getSubDomain($sf_request)?>', /* Set to the secondary level category id, if applicable */
                
                	child: '' /* Set to the tertiary level category id, if applicable */
                
            },
            pageTargetingValues: { /* Additional key-values can be added to this section if needed */
            		id: '<?php echo md5($sf_request->getUri())?>', /* Set to a page-specific unique id*/
                	type: 'recipe', /* Set the content type ( 'category', 'recipe', 'slideshow', etc.) */
                	search: '' /* On search results, set to the search term */
                
            }


<? end_slot() ?>

<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div class="article">
  <? if ($sf_user->isAuthenticated() && $sf_user->getFbId() && $sf_user->getRegSourceAttribute('auth_token')): ?>
    <div id="friendRibbonContainer">
      <? include_component('opengraph', 'friendRibbon', array('results_per_page' => 10)) ?>
    </div><!-- // friendRibbonContainer -->
  <? endif; ?>
  <? include_partial('global/body_sharebar', compact('category')) ?>
  <? include_component('recipes', 'catlevel_category_block', compact('category')) ?>
  <?
  /* as per Jira ticket: MERBETTERR-29 -> please remove trending recipes 
  <div id="trending-recipes">
    <? include_component('opengraph', 'trendingRecipes', array('parent_category_id' => $category->getId())) ?>
  </div><!-- /#trending-recipes -->
  */
  ?>
  <? //include_component('recipes', 'catlevel_recipes_slideshows', array('category_id' => $category->getId(), 'category_name' => $category->getName(), 'is_main_cat' => true)) ?>
  <? //include_partial('stories', compact('stories', 'category')) ?>
  <? //include_partial('popular_stories', compact('category')) ?>
  <? include_partial('baynote_recipes', compact('category')) ?>
  <? include_partial('popular_blogs', compact('category')) ?>
  <? include_component('recipes', 'catlevel_slideshows', array('category_id' => $category->getId(), 'category_name' => $category->getName())) ?>
</div><!-- /.section -->
<? include_partial('global/right_rail/right_rail') ?>
<? include_partial('opengraph/facebook_login_modal') ?>