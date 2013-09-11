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
<? /*
  <? include_component('recipes', 'catlevel_recipes_slideshows', array('category_id' => $category->getId(), 'category_name' => $category->getName(), 'is_main_cat' => false)) ?>
*/ ?>
  <? //include_partial('baynote_recipes', compact('category')) ?>
  <div id="subcat-recipes" class="mt20 clear"></div><!-- /#recipes -->
</div><!-- /.section -->
<? include_partial('global/right_rail/right_rail') ?>
<? include_partial('opengraph/facebook_login_modal') ?>