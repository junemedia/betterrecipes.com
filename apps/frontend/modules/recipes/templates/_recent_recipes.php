<p id ="recent_recipes" class="title">Recent recipes in <?= $category_name ?></p>
<? if ($recent_recipes->haveToPaginate()): ?>
  <div class="sorting shift-right">
    <? include_partial('paginator', compact('recent_recipes')) ?>
  </div>
<? endif; ?>
<ul class="border-bottom recipe_list">
  <? if (count($recent_recipes) > 0): ?>
    <? foreach ($recent_recipes as $recipe): ?>
      <li>
        <a title="<?= $recipe->getName() ?>" href="<?= getUrl($recipe) ?>"><img src="<?= $recipe->getMainImageSrc() ?>"/></a>
        <div class="recipe_title_and_desc">
          <p><a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>"><?= $recipe->getName() ?></a></p>
          <p><?= Utilities::truncateHtml($recipe->getIntroduction(), 200) ?></p>
        </div>
        <div class="rating">
          <p>Rating: <span style="width:<?= $recipe->getRating() * 85 / 5 ?>px" ></span></p>
        </div>
      </li>
    <? endforeach; ?>
  <? else: ?>
    <li>
      No recent recipes in <?= $category_name ?>
    </li>    
  <? endif; ?>
</ul>
<? if ($recent_recipes->haveToPaginate()): ?>
  <div class="sorting">
    <? include_partial('paginator', compact('recent_recipes')) ?>
  </div>
<? endif; ?>
