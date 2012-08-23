<? foreach ($personal_recipes as $recipe): ?>
	<li>
		<? if ($recipe->hasPhoto()): ?>
			<? $main_img = $recipe->getMainImage(); ?>
        	<img src="?= $main_img->getImgSrc() ?>" height="75" width="75" alt="<?= $recipe->getName() ?>" />
        <? else: ?>
        	<img src="/img/recipe-img-placeholder.jpg" alt="No Image" height="75" width="75" />
        <? endif; ?>
        <p><a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>"><?= $recipe->getName() ?></a></p>
        <? $recipe_user = $recipe->getUser() ?>
        <p class="fs11">By: <a href="<?= getUrl($recipe_user) ?>" title="<?= $recipe_user->getDisplayName() ?>"><?= $recipe_user->getDisplayName() ?></a></p>
    </li>
<? endforeach ?>

<? if ($personal_recipes->haveToPaginate()): ?>
  	<? $currentPage = $personal_recipes->getPage() ?>

	<? if ($currentPage < $personal_recipes->getLastPage()): ?>
		<li class="pagination">
	        <a style="margin-left:2%" onclick="ajaxPaginatePersonal('#personal-recipes', '<?=url_for(@paginate_personal) ?>', '<?=$personal_recipes->getNextPage()?>')" title="Load more personal recipes" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more personal recipes</a>
        </li>
    <? endif; ?>

<? endif; ?>
