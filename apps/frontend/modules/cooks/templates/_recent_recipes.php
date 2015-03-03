<? $recipes = @$user->getRecentRecipes(5) ?>
<? $saveds = @$user->getSaved(5) ?>
<div id="cooks-recent-recipes" class="border-bottom clear">
  <p class="title"><?= ($my_profile ? 'My' : $user->getDisplayName()) ?> RECENT RECIPES</p>
  <? if ($my_profile): ?>
    <ul class="hornav tabbednav fifty50">
      <li class="active"><a href="#my-recipes" title="Inbox">My recipes</a></li>
      <li><a href="#my-saved-recipes" title="Compose a new message">My saved recipes</a></li>
    </ul>
  <? endif ?>
  <div id="my-recipes" class="section-wrap active">
    <ul>
      <? if (empty($recipes)): ?>
      <? else : ?>
        <? foreach ($recipes as $recipe): ?>
          <li class="mb20">
            <p class="mb10"><a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>"><?= $recipe->getName() ?></a></p>
            <p class="mb10"><span><?= $recipe->getDescription() ?></span></p>
            <p class="fs11"><?= date('m/d/Y h:i A', strtotime($recipe->getCreatedAt())) ?></p>
          </li>
        <? endforeach ?>
      <? endif; ?>
    </ul>
    <? if (!empty($recipes) && count($recipes) >= 5): ?>
    <p class="cta-more"><a href="/search?recipeOwner=<?=$user->getDisplayName()?>&term=*&PageType=Recipe" title="See more" class="purple">see more&raquo;</a></p>
    <? endif ?>
  </div>
  <div id="my-saved-recipes" class="tab2 section-wrap">
    <ul>
      <? if (empty($saveds)): ?>
      <? else : ?>
        <? foreach ($saveds as $saved): ?>
          <? $saved_recipe = $saved->getRecipe() ?>
          <li class="mb20">
            <p class="mb10"><a href="<?= getUrl($saved_recipe) ?>" title="<?= $saved_recipe->getName() ?>"><?= $saved_recipe->getName() ?></a></p>
            <p class="mb10"><span><?= $saved_recipe->getDescription() ?></span></p>
            <p class="fs11"><?= date('m/d/Y h:i A', strtotime($saved_recipe->getCreatedAt())) ?></p>
          </li>
        <? endforeach ?>
      <? endif; ?>
    </ul>
    <? if (!empty($saveds) && count($saveds) >= 5): ?>
      <p class="cta-more"><a href="/search?recipeOwner=<?=$user->getDisplayName()?>&term=*&PageType=Recipe" title="See more" class="purple">see more&raquo;</a></p>
    <? endif ?>
  </div>
</div><!-- /#recent-recipes -->
