<? if (isset($edit)): ?>
  <li class="bold bp5">
    Current Categories / Subcategories
  </li>
<? endif; ?>
<? $recipe_cats = $recipe->getRecipeCategories() ?>
<? $cat_count = count($recipe_cats) ?>
<? foreach ($recipe_cats as $recipe_category): ?>
  <li>
    <? $sub_cat = $recipe_category->getCategory() ?>
    <? $cat_name = $sub_cat->getParent()->getName() . ' / ' . $sub_cat->getName() ?>
    <?= $cat_name ?>
    <? if ($cat_count > 1 && isset($edit)): ?>
      <a class="removeCategory" alt="Remove Category" title="Remove '<?= $cat_name ?>'" onclick="removeCategory(<?= $recipe_category->getId() ?>)"></a>
    <? endif; ?>
  </li>
<? endforeach; ?>