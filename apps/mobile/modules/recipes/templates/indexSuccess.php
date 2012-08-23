<div class="landing">
  <p class="green fs15">RECIPES</p>
  <p>Our favorite recipes are tried-and-true favorites from kitchens just like yours. They've made lasting impressions at potlucks, picnics, and parties. They're shared over coffee and passed from neighbor to neighbor.</p>
  <? if (isset($recipes) && !is_null($recipes)): ?>
    <ul class="img75left pt10">
      <? foreach ($recipes as $recipe): ?>
        <li>
          <? if ($recipe->hasPhoto()): ?>
            <a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>" class="img-wrap">
              <img src="<?= $recipe->getMainImage()->getImgSrc() ?>" alt="<?= $recipe->getName() ?>" />
            </a>
          <? endif; ?>
          <p><a href="<?= getUrl($recipe) ?>" title="Recipe Name"><?= $recipe->getName() ?></a></p>
          <? $recipe_user = $recipe->getUser() ?>
          <p class="fs11">By: <a href="<?= getUrl($recipe_user) ?>" title="User Name"><?= $recipe_user->getDisplayName() ?></a></p>        
        </li>
      <? endforeach; ?>
    </ul>
  <? endif; ?>
</div>
<div class="recipe-landing">
  <? if (@$categories): ?>
    <ul class="hasimg">
      <? foreach ($categories as $category): ?>
        <li>
          <? include_partial('main_category_block', compact('category')) ?>
        </li>
      <? endforeach; ?>
    </ul>
  <? endif; ?>
</div>
