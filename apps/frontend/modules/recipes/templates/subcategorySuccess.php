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
      url:      "<?php echo url_for('recipes/updateRecentRecipes') ?>",
      type:     "GET",
      dataType: "html",
      data:     { pageno: pageno || 1,
        catid: "<?php echo $category->getId() ?>",
        category_name: "<?php echo $category_name = $category->getName() ?>"
      },
      success:  function(data){
        $("#subcat-recipes").html(data);
      }
    });
  }
</script>

<?php include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>

<div class="article">
  <?php if ($sf_user->isAuthenticated() && $sf_user->getFbId() && $sf_user->getRegSourceAttribute('auth_token')): ?>
  <div id="friendRibbonContainer">
    <?php include_component('opengraph', 'friendRibbon', array('results_per_page' => 10)) ?>
  </div><!-- // friendRibbonContainer -->
  <?php endif; ?>

  <?php include_partial('global/body_sharebar') ?>

  <?php include_component('recipes', 'catlevel_category_block', compact('category')) ?>

  <div id="trending-recipes">
    <?php include_component('opengraph', 'trendingRecipes', array('parent_category_id' => $category->getParentId())) ?>
  </div><!-- /#trending-recipes -->


  <?php include_partial('baynote_recipes', compact('category')) ?>
  <div id="subcat-recipes" class="mt20 clear"></div><!-- /#subcat-recipes -->

  <div class="clear-both" style="margin:20px auto;">
    <?php include_partial('global/adtags/lockerdome'); ?>
  </div>

  <?php include_partial('global/adtags/outbrain_AR_3', array('datasrc' => $sf_request->getUri())); ?>

</div><!-- /.article -->

<?php include_partial('global/right_rail/right_rail') ?>
<?php include_partial('opengraph/facebook_login_modal') ?>
