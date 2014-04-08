<? slot('gpt') ?>

unitValues: {
                	channel: 'Recipe', /* Set to the top level category id, if applicable */
                
                	parent: '<?=$sub?>', /* Set to the secondary level category id, if applicable */
                
                	child: '<?=$recipe->getSlug()?>' /* Set to the tertiary level category id, if applicable */
                
            },
            pageTargetingValues: { /* Additional key-values can be added to this section if needed */
            		id: '<?php echo md5($sf_request->getUri())?>', /* Set to a page-specific unique id*/
                	type: 'recipe', /* Set the content type ( 'category', 'recipe', 'slideshow', etc.) */
                	search: '' /* On search results, set to the search term */
                
            }


<? end_slot() ?>

<? slot('infolinks') ?>
<script type="text/javascript">
var infolinks_pid = 1790157;
var infolinks_wsid = 14;
</script>
<script type="text/javascript" src="http://resources.infolinks.com/js/infolinks_main.js"></script>
<? end_slot() ?>

<? session_cache_limiter('nocache'); ?>
<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<? if (isset($omniParams)): ?>
  <script>
    $(document).ready(function(){
      s.pageName = s.eVar9 = '<?= $omniParams['pageName'] ?>';
      s.server = 'www.betterrecipes.com';
      s.channel = 'Recipe';
      s.prop1 = '<?= $omniParams['prop1'] ?>';
      s.prop2 = '<?= $omniParams['prop2'] ?>';
      s.prop7 = s.eVar24 = <?= $omniParams['prop7'] ?>;
      s.prop11 = '<?= $omniParams['prop11'] ?>';
      s.prop18 = 'betterrecipes';
      s.prop19 = 'Food';
      s.prop20 = '<?= $omniParams['prop20'] ?>';
      s.eVar14 = 'Recipe';
      s.t();
    });
  </script>
<? endif ?>
<div class="article has-breadcrumbs">
  <? // include_partial('contest') ?>
  <? include_partial('recipe_detail', compact('recipe', 'is_saved', 'is_made', 'user_rating', 'currentContest', 'recipeNext', 'recipePrev', 'showVoteButton', 'showPopup', 'msg')) ?>
  <a name="write_review"></a>
  
  <script id="mNCC" language="javascript"> medianet_width='656'; medianet_height= '175'; medianet_crid='342352778'; </script> <script id="mNSC" src="http://contextual.media.net/nmedianet.js?cid=8CUPTG615" language="javascript"></script>
  <div class="OUTBRAIN" data-src="<?= UrlToolkit::getUrl($recipe) ?>" data-widget-id="AR_3" data-ob-template="BetterRecipes"></div>
  <script type="text/javascript" async="async" src="http://widgets.outbrain.com/outbrain.js"></script>
  
  <div id="recipe-comments" class="clear mt20">
    <fb:comments href="<?= $sf_request->getUri() ?>" num_posts="5" width="660"></fb:comments>
  </div><!-- /#recipe-comments -->
  
  
  
  <?
  /* MBR-57 -> Remove
  <p class="title">Trending Food</p>
  <div id="trendingFood">
    <script type='text/javascript'>
    var _CI = _CI || {};
    (function() {
    var script = document.createElement('script');
    ref = document.getElementsByTagName('script')[0];
    _CI.counter = (_CI.counter) ? _CI.counter + 1 : 1;
    document.write('<div id="_CI_widget_');
    document.write(_CI.counter+'"></div>');
    script.type = 'text/javascript';
    script.src = 'http://widget.crowdignite.com/widgets/26045?_ci_wid=_CI_widget_'+_CI.counter;
    script.async = true;
    ref.parentNode.insertBefore(script, ref);
    })(); </script>
  </div>
  */
  ?>
</div><!-- /.section -->
<? include_partial('global/right_rail/right_rail') ?>
<? include_partial('opengraph/facebook_login_modal') ?>