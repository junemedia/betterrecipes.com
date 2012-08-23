<? include_partial('top-groups', compact('popgroups')) ?>
<div class="recipes hasad">
  <div class="header">
    <a href="<?= getDomainUri() . '/recipes' ?>" title="View All Groups"><span class="green">TOP RECIPES</span><span class="all">>> All</span></a>
    <? /* ET#6549 - revert this when ad tags are ready
    <div class="ad100x40">
      <a href="#" title="Faux Ad 100x40"><img src="/img/m/fauxad-100x40.jpg" height="40" width="100" alt="100x40 AD" /></a>
    </div> */ ?>
  </div>
  <? if (isset($recipes) && count($recipes)): ?>
    <ul class="img75left pt10 pb10">
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