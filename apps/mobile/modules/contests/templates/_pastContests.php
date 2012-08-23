<? foreach ($past_contests->getResults() as $i => $c): ?>
<li>
  <a href="<?= getRoute('contests_detail', array('slug' => $c->getSlug())) ?>" title="<?= $c->getName() ?>" class="img-wrap">
    <img src="<?= $c->getImgSrc() ?>" height="75" width="75" alt="<?= $c->getName() ?>" />
  </a>
  <p><a href="<?= getRoute('contests_detail', array('slug' => $c->getSlug())) ?>" title="<?= $c->getName() ?>"><?= $c->getName() ?></a></p>
</li>
<? endforeach ?>

<? if ($past_contests->haveToPaginate()): ?>
<? $currentPage = $past_contests->getPage() ?>

<? if ($currentPage < $past_contests->getLastPage()): ?>
<li class="pagination">
  <a onclick="ajaxPaginatePastContests('#past-contests', '<?=url_for(@paginate_pastcontests) ?>', '<?=$past_contests->getNextPage()?>')" title="Load more contests" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more contests</a>
</li>
<? endif; ?>

<? endif; ?>
