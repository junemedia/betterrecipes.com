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

<script>
  $(document).ready(function() {
    pageno = parseInt(window.location.hash.replace("#",""));
    if (!isNaN(pageno)) {
      updateRecentRecipes(pageno);
    } else {
      updateRecentRecipes();
    }
  });  
  function updateRecentRecipes(pageno){
    if(pageno){
      window.location.hash = pageno;
    }
    $.ajax({
      url:      "<?= url_for('recipes/updateRecentRecipes') ?>",
      type:     "GET",
      dataType: "html",
      data:     { pageno: pageno || 1,
        catid: "<?= $category->getId() ?>",
        category_name: "<?= $category_name = $category->getName() ?>"
      },
      success:  function(data){ 
        $("#subcat-recipes").html(data);
        if(pageno){
          refreshAdtags('all');
          $('html, body').animate({ scrollTop: 0 }, 0);
          $('html,body').animate({scrollTop: $("#recent_recipes").offset().top}, 0);
        }
      }
    });
  }
</script>
<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div class="article">
  <? if ($sf_user->isAuthenticated() && $sf_user->getFbId() && $sf_user->getRegSourceAttribute('auth_token')): ?>
    <div id="friendRibbonContainer">
      <? include_component('opengraph', 'friendRibbon', array('results_per_page' => 10)) ?>
    </div><!-- // friendRibbonContainer -->
  <? endif; ?>
  <? include_partial('global/body_sharebar') ?>
  <? include_component('recipes', 'catlevel_category_block', compact('category')) ?>
  <div id="trending-recipes">
    <? include_component('opengraph', 'trendingRecipes', array('parent_category_id' => $category->getParentId())) ?>
  </div><!-- /#trending-recipes -->
  
  <!-- begin media.net 2 -->
  <script id="mNCC" language="javascript">  medianet_width='650';  medianet_height= '175';  medianet_crid='223633310';  </script>  <script id="mNSC" src="http://contextual.media.net/nmedianet.js?cid=8CU52X6SM" language="javascript"></script> 
  <!-- end media.net -->
  
  <div class="OUTBRAIN" data-src="<?= $sf_request->getUri() ?>" data-widget-id="AR_3" data-ob-template="BetterRecipes"></div>
  <script type="text/javascript" async="async" src="http://widgets.outbrain.com/outbrain.js"></script>
  
  
  
<? /*
  <? include_component('recipes', 'catlevel_recipes_slideshows', array('category_id' => $category->getId(), 'category_name' => $category->getName(), 'is_main_cat' => false)) ?>
*/ ?>
  <? include_partial('baynote_recipes', compact('category')) ?>
  <div id="subcat-recipes" class="mt20 clear"></div><!-- /#recipes -->
</div><!-- /.section -->
<? include_partial('global/right_rail/right_rail') ?>
<? include_partial('opengraph/facebook_login_modal') ?>