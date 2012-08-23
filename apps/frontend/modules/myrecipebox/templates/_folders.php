<div class="sidebar horflip">
  <ul class="folder-options underlines">
    <li>Folders:<a title="New Folder" class="flri" onclick="addFolder()">New Folder</a></li>
    <li><a href="<?= getDomainUri() . url_for('@myrecipebox?folder=personal') ?>" title="My Personal Recipes">My Personal Recipes (<?= $personal_recipe_count ?>)</a></li>
    <li><a href="<?= getDomainUri() . url_for('@myrecipebox?folder=saved') ?>" title="">All My Saved Recipes (<?= $saved_recipe_count ?>)</a></li>
    <li><a href="<?= getDomainUri() . url_for('@myrecipebox?folder=made') ?>" title="">Recipes I've Made (<?= $made_recipe_count ?>)</a></li>
    <? if (count($folders) > 0): ?>
      <? foreach ($folders as $folder): ?>
        <? $count = $folder->getActiveCollectionRecipe($folder->getId()); ?>
        <li><a href="<?= getDomainUri() . url_for('@myrecipebox?folder=' . $folder->getId()) ?>" title="<?= $folder->getName() ?> ?>"><?= $folder->getName() ?> (<?
    if (isset($count) && sizeof($count) > 0) {
      echo sizeof($count);
    } else {
      echo '0';
    }
        ?>)</a></li>
      <? endforeach; ?>
    <? endif; ?> 
  </ul>
  <? if (@$viewed): ?>
    <div class="sidebar horflip">
      <p class="title">Recently Viewed Recipes</p>
      <ul>
        <? foreach ($viewed as $viewed_item): $recipe = $viewed_item->getRecipe() ?>
          <li class="recently-viewed">
            <a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>" class="imgmask100 flle mr10">
              <img src="<?= $recipe->getMainImageSrc() ?>" alt="<?= $recipe->getName() ?>" />
            </a>
            <p><a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>"><?= Utilities::truncateHtml($recipe->getName(), 45) ?></a> <?= date('m/d/y @ g:i a', strtotime($recipe->getCreatedAt())) ?></p>
            <? $made = UserActionsTable::isMade($recipe->getId(), $sf_user->getId()); ?>
            <? if (!$made): ?>
              <a class="graphic-button" href="javascript:;" onclick="savedRecipeMade(this, <?= $recipe->getId() ?>, '<?= urlencode($recipe->getName()) ?>', '<?= getUrl($recipe) ?>')">Made This!</a>
            <? endif; ?>
          </li>
        <? endforeach; ?>
      </ul>
    </div><!-- /#sidebar-recipes -->
  <? endif; ?>
</div>