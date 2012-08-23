<div class="paginationRow clearfix">
  <? if (is_object($pager) && $pager->haveToPaginate()): ?>
    <div class="pagination">
      <div class="pagination_link">
        <?= link_to('<<', $link_to . '?page=' . $pager->getPreviousPage() . $query) ?>
      </div>
      <? $links = $pager->getLinks() ?>
      <? foreach ($links as $page): ?>   
        <div class="pagination_link">
          <?= ($page == $pager->getPage()) ? $page : link_to($page, $link_to . '?page=' . $page . $query) ?> 
        </div>
      <? endforeach; ?>
      <div class="pagination_link">
        <?= link_to('>>', $link_to . '?page=' . $pager->getNextPage() . $query) ?>
      </div>
    </div>
  <? endif; ?>
</div>