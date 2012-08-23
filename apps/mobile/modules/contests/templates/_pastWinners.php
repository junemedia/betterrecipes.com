<? foreach ($pastWinners->getResults() as $i => $winner): ?>
<li>
  <a href="<?= getUrl($winner->getRecipe()) ?>" title="<?= $winner->getRecipe()->getName() ?>" class="img-wrap">
  	<img src="<?= ($winner->getRecipe()->hasPhoto()) ? $winner->getRecipe()->getPrimaryImageSrc() : '/img/recipe-img-placeholder-thumb.jpg' ?>" height="75" width="75" alt="<?= $winner->getRecipe()->getName() ?>" />
  </a>
  <p><a href="<?= getUrl($winner->getRecipe()) ?>" title="<?= $winner->getRecipe()->getName() ?>"><?= $winner->getRecipe()->getName() ?></a></p>
  <p class="fs11">By: <a href="<?= getRoute('cook_profile', array('subdir' => $winner->getUser()->getSubdir())) ?>" title="<?= $winner->getUser()->getDisplayName() ?>"><?= $winner->getUser()->getDisplayName() ?></a></p>
</li>
<? endforeach ?>

<? if ($pastWinners->haveToPaginate()): ?>
<? $currentPage = $pastWinners->getPage() ?>

<? if ($currentPage < $pastWinners->getLastPage()): ?>
<li class="pagination">
	<a onclick="ajaxPaginatePastWinners('#past-winners', '<?=url_for(@paginate_pastwinners) ?>', '<?=$pastWinners->getNextPage()?>')" title="Load more winners" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more winners</a>
</li>
<? endif; ?>

<? endif; ?>
