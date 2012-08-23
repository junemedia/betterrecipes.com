<div class="paginationRow">
  <div class="pagination">
    <? if ($polls_pager != ''): ?>
      <? if ($polls_pager->haveToPaginate()): ?>
        <? $currentPage = $polls_pager->getPage(); ?>
        <? $links = $polls_pager->getLinks(); ?>
        <div class="pagination_link">
          <? if ($currentPage == 1): ?> 
            &laquo;
          <? else: ?>
            <a href="?page=<?= $polls_pager->getPreviousPage() ?>">&laquo;</a>
          <? endif; ?>
        </div>
        <? foreach ($links as $page): ?>
          <div class="pagination_link">
            <? if ($page == $polls_pager->getPage()): ?> 
              <?= $page ?>
            <? else: ?>
              <a  href="?page=<?= $page ?>"><?= $page ?></a>
            <? endif; ?>
          </div>
        <? endforeach ?>
        <div class="pagination_link">
          <? if ($currentPage == $polls_pager->getCurrentMaxLink()): ?>
            &raquo;
          <? else: ?>
            <a href="?page=<?= $polls_pager->getNextPage() ?>">&raquo;</a>      
          <? endif; ?>
        </div>   
      <? endif; ?>
    <? endif; ?>
  </div>
</div>