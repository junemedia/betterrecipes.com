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
  <? include_partial('recipe_detail', compact('recipe', 'is_saved', 'is_made', 'user_rating', 'currentContest', 'recipeNext', 'recipePrev', 'showVoteButton', 'showPopup', 'msg')) ?>
  <a name="write_review"></a>

  <!-- DEFY VIDEO -->
  <div style="margin: 30px auto;">
    <?php include_partial("global/adtags/defy-clip_1848") ?>
  </div>

  <?php include_partial('global/adtags/outbrain_AR_3', array('datasrc' => UrlToolkit::getUrl($recipe))); ?>

  <div id="recipe-comments" class="clear mt20">
    <fb:comments href="<?= $sf_request->getUri() ?>" num_posts="5" width="660"></fb:comments>
  </div><!-- /#recipe-comments -->
</div><!-- /.section -->

<? include_partial('global/right_rail/right_rail') ?>
<? include_partial('opengraph/facebook_login_modal') ?>
