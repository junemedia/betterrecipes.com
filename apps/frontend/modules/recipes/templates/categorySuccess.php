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

  <!-- begin media.net 3 -->
  <script id="mNCC" language="javascript">  medianet_width='650';  medianet_height= '175';  medianet_crid='223633310';  </script>  
  <script id="mNSC" src="http://contextual.media.net/nmedianet.js?cid=8CU52X6SM" language="javascript"></script> 
 
  <!-- end media.net -->
  
  <div class="OUTBRAIN" data-src="<?= $sf_request->getUri() ?>" data-widget-id="AR_3" data-ob-template="BetterRecipes"></div>
  <script type="text/javascript" async="async" src="http://widgets.outbrain.com/outbrain.js"></script>
  
  
  
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