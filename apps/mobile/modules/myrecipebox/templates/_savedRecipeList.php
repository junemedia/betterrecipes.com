<? foreach ($saved_recipes as $recipe): ?>
	<li>
		<? if ($recipe->hasPhoto()): ?>
			<? $main_img = $recipe->getMainImage(); ?>
        	<img src="?= $main_img->getImgSrc() ?>" height="75" width="75" alt="<?= $recipe->getName() ?>" />
        <? else: ?>
        	<img src="/img/recipe-img-placeholder.jpg" alt="No Image" height="75" width="75" />
        <? endif; ?>
        <a onclick="deleteSavedRecipe(this, '<?=url_for(@delete_saved_recipe)?>', <?= $recipe->getId() ?>)" style="cursor:pointer;" title="Delete this recipe" class="gray-btn">REMOVE</a>
        <p><a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>"><?= $recipe->getName() ?></a></p>
        <? $recipe_user = $recipe->getUser() ?>
        <p class="fs11">By: <a href="<?= getUrl($recipe_user) ?>" title="<?= $recipe_user->getDisplayName() ?>"><?= $recipe_user->getDisplayName() ?></a></p>
    </li>
<? endforeach ?>

<? if ($saved_recipes->haveToPaginate()): ?>
  	<? $currentPage = $saved_recipes->getPage() ?>

	<? if ($currentPage < $saved_recipes->getLastPage()): ?>
		<li class="pagination">
	        <a style="margin-left:2%" onclick="ajaxPaginateSaved('#saved-recipes', '<?=url_for(@paginate_saved) ?>', '<?=$saved_recipes->getNextPage()?>')" title="Load more saved recipes" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more saved recipes</a>
        </li>
    <? endif; ?>

<? endif; ?>
