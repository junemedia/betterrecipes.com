<?php slot('gpt') ?>
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
<?php end_slot() ?>

<div class="article homepage">
  <?php include_partial('featured_contents', compact('hpWonder')) ?>

  <?php if ($sf_user->isAuthenticated() && $sf_user->getFbId() && $sf_user->getRegSourceAttribute('auth_token')): ?>
  <div id="friends-activity">
    <?php include_component('opengraph', 'recipesByFriends', array('friends' => $friends, 'limit' => 15)) ?>
  </div><!-- /#todays-poll -->
  <div class="clear-both"></div>
  <?php endif; ?>

  <div id="trending-recipes">
    <?php include_component('opengraph', 'trendingRecipes', array('limit' => 15)) ?>
  </div><!-- /#trending-recipes -->
  <div class="clear-both"></div>

  <?php include_partial('featured_contests') ?>
  <div class="clear-both"></div>

  <?php include_partial('editorials', compact('categoryWonder')) ?>

  <!-- begin media.net 6 -->
  <script id="mNCC" language="javascript">  medianet_width='650';  medianet_height= '175';  medianet_crid='662071020';  </script>  <script id="mNSC" src="http://contextual.media.net/nmedianet.js?cid=8CU52X6SM" language="javascript"></script>
  <div class="clear-both"></div>
  <!-- end media.net -->

  <?php if (false) { // take out for now ?>
  <!-- DEFY VIDEO -->
  <div class="clear-both" style="margin: 30px auto;">
    <?php include_partial("global/adtags/defy-clip_1848") ?>
  </div>
  <div class="clear-both"></div>
  <?php } ?>

  <?php include_partial('global/adtags/outbrain_TF_4') ?>

  <?php include_partial('opengraph/facebook_login_modal') ?>
</div><!-- /.article -->

<?php include_partial('global/right_rail/right_rail') ?>
<div class="clear-both"></div>
