<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div class="article">
  <div id="recipe-landing">
    <h3 class="title green">Recipes</h3>
    <p class="summary"><a href="<?= getUrl('@add_recipe') ?>" title="Upload Recipe" class="btn-grey28 w140 ml20">Upload Recipe</a>Our favorite recipes are tried-and-true favorites from kitchens just like yours. They've made lasting impressions at potlucks, picnics, and parties. They're shared over coffee and passed from neighbor to neighbor.</p>
  </div><!-- /#recipe-landing -->
  <? include_partial('recipe_wonder', compact('rWonder')) ?>
  <? include_partial('categories', compact('categories')) ?>
  <? include_partial('opengraph/facebook_login_modal') ?>
</div><!-- /.section -->
<? include_partial('global/right_rail/right_rail') ?>