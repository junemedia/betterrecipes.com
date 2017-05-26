<? slot('gpt') ?>
  unitValues: {
    channel: 'Homepage', /* Set to the top level category id, if applicable */
    parent: '', /* Set to the secondary level category id, if applicable */
    child: '' /* Set to the tertiary level category id, if applicable */
  },
  pageTargetingValues: { /* Additional key-values can be added to this section if needed */
    id: '<?php echo md5($sf_request->getUri())?>', /* Set to a page-specific unique id*/
    type: '', /* Set the content type ( 'category', 'recipe', 'slideshow', etc.) */
    search: '' /* On search results, set to the search term */
  }
<? end_slot() ?>

<div class="article homepage">
  <? include_partial('featured_contents', compact('hpWonder')) ?>

  <? if ($sf_user->isAuthenticated() && $sf_user->getFbId() && $sf_user->getRegSourceAttribute('auth_token')): ?>
  <div id="friends-activity">
    <? include_component('opengraph', 'recipesByFriends', array('friends' => $friends, 'limit' => 15)) ?>
  </div><!-- /#todays-poll -->
  <div class="clear-both"></div>
  <? endif; ?>

  <div id="trending-recipes">
    <? include_component('opengraph', 'trendingRecipes', array('limit' => 15)) ?>
  </div><!-- /#trending-recipes -->
  <div class="clear-both"></div>

  <? include_partial('featured_contests') ?>
  <div class="clear-both"></div>

  <? include_partial('editorials', compact('categoryWonder')) ?>

  <!-- DEFY VIDEO -->
  <div class="clear-both" style="margin: 30px auto;">
    <?php include_partial("global/adtags/defy-clip_1848") ?>
  </div>
  <div class="clear-both"></div>

  <?php include_partial('global/adtags/outbrain_TF_4') ?>

  <? include_partial('opengraph/facebook_login_modal') ?>
</div><!-- /.article -->

<? include_partial('global/right_rail/right_rail') ?>
<div class="clear-both"></div>
