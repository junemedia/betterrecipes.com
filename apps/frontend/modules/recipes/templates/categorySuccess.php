<?php slot('gpt') ?>
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
<?php end_slot() ?>

<?php include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>

<div class="article">
  <?php if ($sf_user->isAuthenticated() && $sf_user->getFbId() && $sf_user->getRegSourceAttribute('auth_token')): ?>
  <div id="friendRibbonContainer">
    <?php include_component('opengraph', 'friendRibbon', array('results_per_page' => 10)) ?>
  </div><!-- // friendRibbonContainer -->
  <?php endif; ?>

  <?php include_partial('global/body_sharebar', compact('category')) ?>

  <?php include_component('recipes', 'catlevel_category_block', compact('category')) ?>

  <?php
  // JS: turn defy video off 06/14/2017
  /* <!-- DEFY VIDEO --> */
  /* <div class="clear-both" style="margin: 30px auto;"> */
  /*   <?php include_partial("global/adtags/defy-clip_1847") ?> */
  /* </div> */
  ?>
  <div class="clear-both" style="margin:20px auto;">
    <?php include_partial('global/adtags/lockerdome'); ?>
  </div>

  <?php include_partial('global/adtags/outbrain_AR_3', array('datasrc' => $sf_request->getUri())); ?>

  <?php include_partial('baynote_recipes', compact('category')) ?>
  <?php include_partial('popular_blogs', compact('category')) ?>
  <?php include_component('recipes', 'catlevel_slideshows', array('category_id' => $category->getId(), 'category_name' => $category->getName())) ?>
</div><!-- /.article -->

<?php include_partial('global/right_rail/right_rail') ?>
<?php include_partial('opengraph/facebook_login_modal') ?>
