<? slot('gpt') ?>

unitValues: {
                	channel: '', /* Set to the top level category id, if applicable */
                
                	parent: '', /* Set to the secondary level category id, if applicable */
                
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
  <div id="recipe-landing">
    <h3 class="title green">Recipes</h3>
    <p class="summary"><a href="<?= getUrl('@add_recipe') ?>" title="Upload Recipe" class="btn-grey28 w140 ml20">Upload Recipe</a>Our favorite recipes are tried-and-true favorites from kitchens just like yours. They've made lasting impressions at potlucks, picnics, and parties. They're shared over coffee and passed from neighbor to neighbor.</p>
  </div><!-- /#recipe-landing -->
  <? include_partial('recipe_wonder', compact('rWonder')) ?>
  <? include_partial('categories', compact('categories')) ?>
  <? include_partial('opengraph/facebook_login_modal') ?>
</div><!-- /.section -->
<? include_partial('global/right_rail/right_rail') ?>