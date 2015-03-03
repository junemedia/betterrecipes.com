<script>
  function updateRecentRecipes(pageno) {
    $.get("<?= url_for('recipes/updateRecentRecipes') ?>", { pageno: pageno, catid: <?= $category->getId() ?> }, function(data) {
      $('#recent-recipes ul li.pagination').hide();
      $('#recent-recipes ul').append(data);
    });
  }
</script>
<div class="category">
  <? // include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
  <? include_partial('catlevel_category_block', compact('category')) ?>
</div><!-- /.category -->
<? include_partial('catlevel_recipes_slideshows', compact('recipes', 'category')) ?>
<? if (count($recent_recipes) > 0): ?>
  <div id="recent-recipes" class="recipes-rating">
    <div class="header">
      <p class="green">RECIPES</p>
    </div>
    <div id="recent-recipes">
    <ul>
      <? include_partial('recent_recipes', compact('recent_recipes')) ?>
    </ul>
    </div>
  </div><!-- /.recipes-rating -->
<? endif; ?>
