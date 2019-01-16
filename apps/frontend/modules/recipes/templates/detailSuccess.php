<?php slot('gpt') ?>
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
<?php end_slot() ?>

<?php session_cache_limiter('nocache'); ?>
<?php include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>

<?php if (isset($omniParams)): ?>
  <script>
    $(document).ready(function(){
      s.pageName = s.eVar9 = '<?php echo $omniParams['pageName'] ?>';
      s.server = 'www.betterrecipes.com';
      s.channel = 'Recipe';
      s.prop1 = '<?php echo $omniParams['prop1'] ?>';
      s.prop2 = '<?php echo $omniParams['prop2'] ?>';
      s.prop7 = s.eVar24 = <?php echo $omniParams['prop7'] ?>;
      s.prop11 = '<?php echo $omniParams['prop11'] ?>';
      s.prop18 = 'betterrecipes';
      s.prop19 = 'Food';
      s.prop20 = '<?php echo $omniParams['prop20'] ?>';
      s.eVar14 = 'Recipe';
      s.t();
    });
  </script>
<?php endif ?>

<div class="article has-breadcrumbs">

  <div style="margin:20px auto 30px; border-bottom: #ebebeb solid 1px;">
    <?php include_partial('global/adtags/adthrive_video'); ?>
  </div>

  <?php include_partial('recipe_detail', compact('recipe', 'is_saved', 'is_made', 'user_rating', 'currentContest', 'recipeNext', 'recipePrev', 'showVoteButton', 'showPopup', 'msg')) ?>
  <a name="write_review"></a>

  <div style="margin:20px auto;">
    <?php include_partial('global/adtags/lockerdome'); ?>
 </div>

  <?php include_partial('global/adtags/outbrain_AR_3', array('datasrc' => UrlToolkit::getUrl($recipe))); ?>

  <div id="recipe-comments" class="clear mt20">
    <fb:comments href="<?php echo $sf_request->getUri() ?>" num_posts="5" width="660"></fb:comments>
  </div><!-- /#recipe-comments -->
</div><!-- /.section -->

<?php include_partial('global/right_rail/right_rail') ?>
<?php include_partial('opengraph/facebook_login_modal') ?>
