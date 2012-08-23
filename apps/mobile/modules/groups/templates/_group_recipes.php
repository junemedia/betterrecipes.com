<? if ($pager->getNbResults() > 0): ?>
<? $i = 0; ?>
<? foreach ($pager->getResults() as $recipe): ?>
<?
if( ($i + 1) % 3 == 0){
echo '<li class="last all-copy ovhid">';
} else {
echo '<li class="all-copy ovhid">';
}
$i++;
?>
<? /* not sure if we will display a recipe photo, a lot of recipes don't have one
<?
if ($recipe->hasPhoto()) {
$main_img = $recipe->getMainImage();
$img_src = $main_img->getImgSrc();
?>
<a href="<?= getUrl($recipe) ?>"><img src="<?= $img_src ?>" height="75" width="75" /></a>
<?
}
?>
*/?>
  <p><a href="<?= getUrl($recipe) ?>" class="pb5"><?= $recipe->getName() ?></a></p>
  <p class="fs11">by <a href="<?= getRoute('User', array('subdir' => $recipe->getUser()->getSubdir())) ?>" title="<?= $recipe->getUser()->getDisplayName() ?>"><?= $recipe->getUser()->getDisplayName() ?></a> @ <?= $recipe->getDateTimeObject('created_at')->format('m/d/Y g:i A') ?></p>
  
  <? if ($sf_user->isAuthenticated() && ($recipe->getUserId() != $sf_user->getAttribute('id'))): ?>
  <? 
  $is_saved = SavedTable::isSaved($recipe->getId(), $sf_user->getAttribute('id')); 
  $id = $recipe->getId();
  ?>
  <p class="pt10 save-share">
		<? include_partial('save_recipe', compact('is_saved', 'id')) ?>
    <a class="gray-btn" onclick="">SHARE</a>
  </p>
  <? endif; ?>
</li>
<? endforeach; ?>
<? endif; ?>


<? if ($pager->haveToPaginate()): ?>
<? $currentPage = $pager->getPage() ?>

<? if ($currentPage < $pager->getLastPage()): ?>
<li class="pagination">
  <a onclick="ajaxPaginateRecipes('#recipes', '<?= url_for(@group_paginate_recipes) ?>', '<?= $pager->getNextPage() ?>', '<?= $group['subdir'] ?>', '<?= $group_cat ?>', '<?= $sortby ?>')" title="Load more recipes" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more recipes</a>
</li>
<? endif; ?>

<? endif; ?>
