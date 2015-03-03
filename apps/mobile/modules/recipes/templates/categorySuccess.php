<div class="category pb10">
  <? include_partial('catlevel_category_block', compact('category')) ?>
</div>
<? include_partial('catlevel_recipes_slideshows', compact('recipes', 'slideshows', 'category')) ?>
<? include_partial('stories', compact('stories', 'category')) ?>
