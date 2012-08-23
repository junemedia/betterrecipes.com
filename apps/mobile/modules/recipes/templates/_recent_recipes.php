<? foreach ($recent_recipes as $recipe): ?>
  <? $recipe_user = $recipe->getUser() ?>
  <li>
    <p class="rating-wrap"><span class="rating">Rating:<span style="width:<?= $recipe->getRating() * 85 / 5 ?>px"></span></span><a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>"><?= $recipe->getName() ?></a></p>
    <p class="fs11">by: <a href="<?= getUrl($recipe_user) ?>" title="<?= $recipe_user->getDisplayName() ?>"><?= $recipe_user->getDisplayName() ?></a></p>
  </li>
<? endforeach; ?>
<? if ($recent_recipes != '' && $recent_recipes->haveToPaginate() && $recent_recipes->getPage() < $recent_recipes->getLastPage()): ?>
  <li id="pagination_link" class="pagination">
    <a style="margin-left:2%" onclick="updateRecentRecipes(<?= $recent_recipes->getNextPage() ?>)" title="Load more recipes" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more recipes</a>
  </li>
<? endif; ?>