<?php slot('gpt') ?>
  unitValues: {
    channel: 'recipe', /* Set to the top level category id, if applicable */
    parent: '', /* Set to the secondary level category id, if applicable */
    child: '' /* Set to the tertiary level category id, if applicable */
  },
  pageTargetingValues: { /* Additional key-values can be added to this section if needed */
    id: '<?php echo md5($sf_request->getUri())?>', /* Set to a page-specific unique id*/
    type: 'slideshow', /* Set the content type ( 'category', 'recipe', 'slideshow', etc.) */
    search: '' /* On search results, set to the search term */
  }
<?php end_slot() ?>

<?php include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>

<div class="article">
  <div id="slideshow-wrap">
    <?php if ($slideshow->getSponsorId()): ?>
      <?php $sponsor = $slideshow->getSponsor() ?>
      <div id="sponsor_<?php echo $sponsor->getId() ?>"class="sponsor adsponsor">
        <?php include_partial('global/adtags/sponsor', compact('sponsor')) ?>
      </div>
    <?php endif; ?>
    <?php if ($sf_user->isAuthenticated()): ?>
      <?php include_partial('thumbnails', compact('slides', 'showall')) ?>
    <?php endif; ?>
    <?php include_partial('slideshow', compact('slideshow', 'slides', 'showall')) ?>
    <?php include_partial('groups', compact('groups')) ?>

    <?php
    // JS: turn defy video off 06/14/2017
    /* <!-- DEFY VIDEO --> */
    /* <div style="margin: 30px auto;"> */
    /*   <?php include_partial("global/adtags/defy-clip_1847") ?> */
    /* </div> */
    ?>
    <div style="margin:20px auto;">
      <?php include_partial('global/adtags/lockerdome'); ?>
    </div>

    <?php include_partial('global/adtags/outbrain_AR_4', array('datasrc' => getUrl($slideshow))); ?>

    <?php include_partial('recipes_slideshows', compact('recipes', 'slideshows', 'category')) ?>
  </div><!-- /#slideshow -->
</div><!-- /.section -->

<?php include_partial('right_rail', compact('rr_recipes')) ?>
