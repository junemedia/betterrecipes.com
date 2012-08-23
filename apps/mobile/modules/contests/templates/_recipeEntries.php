<? foreach ($contestants->getResults() as $i => $c): ?>
  <li>
  <a href="<?= getUrl($c->getRecipe()) ?>" title="<?= $c->getRecipe()->getName() ?>" class="img-wrap">
    <img src="<?= ($c->getRecipe()->hasPhoto()) ? $c->getRecipe()->getPrimaryImageSrc() : '/img/recipe-img-placeholder-thumb.jpg' ?>" height="75" width="75" alt="<?= $c->getRecipe()->getName() ?>" />
  </a>
  <div class="desc">
    <p><a href="<?= getUrl($c->getRecipe()) ?>" title="<?= $c->getRecipe()->getName() ?>"><?= $c->getRecipe()->getName() ?></a></p>
    <p class="fs11">By: <a href="<?= getRoute('cook_profile', array('subdir' => $c->getRecipe()->getUser()->getSubdir())) ?>" title="<?= $c->getRecipe()->getUser()->getDisplayName() ?>"><?= $c->getRecipe()->getUser()->getDisplayName() ?></a></p>
  </div>
  </li>
  <? endforeach ?>
  
  <? if ($contestants->haveToPaginate()): ?>
  <? $currentPage = $contestants->getPage() ?>
  
  <? if ($currentPage < $contestants->getLastPage()): ?>
  <li class="pagination">
    <a onclick="ajaxPaginateContestants('#recipe-entries', '<?=url_for(@paginate_contestants) ?>', '<?=$contestants->getNextPage()?>', '<?=$contestId?>')" title="Load more entries" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more entries</a>
  </li>
<? endif; ?>

<? endif; ?>
