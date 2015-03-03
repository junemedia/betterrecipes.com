<? $pages = $recipes->getLinks() ?>
<ul class="hornav pager">
  <li><a href="<?= getDomainUri() . url_for('@myrecipebox?folder=' . $sf_request->getParameter('folder', 'all') . '&order_by=' . $sf_request->getParameter('order_by', 'date-desc') . '&page_no=' . $recipes->getPreviousPage()) ?>"><<</a><li>
    <? if ($pages[0] > $recipes->getFirstPage()): ?>
    <li><a href="<?= getDomainUri() . url_for('@myrecipebox?folder=' . $sf_request->getParameter('folder', 'all') . '&order_by=' . $sf_request->getParameter('order_by', 'date-desc') . '&page_no=' . $recipes->getFirstPage()) ?>"><?= $recipes->getFirstPage() ?></a> ...<li>
    <li>
    <? endif ?>
    <? foreach ($pages as $page): ?>
      <? if ($page == $recipes->getPage()): ?>
        <span><?= $page ?></span>
      <? else: ?>
      </li>
      <li><a href="<?= getDomainUri() . url_for('@myrecipebox?folder=' . $sf_request->getParameter('folder', 'all') . '&order_by=' . $sf_request->getParameter('order_by', 'date-desc') . '&page_no=' . $page) ?>"><?= $page ?></a><li>
      <? endif; ?>
    <? endforeach ?>
    <? if ($pages[count($pages) - 1] < $recipes->getLastPage()): ?>
    <li>... <a href="<?= getDomainUri() . url_for('@myrecipebox?folder=' . $sf_request->getParameter('folder', 'all') . '&order_by=' . $sf_request->getParameter('order_by', 'date-desc') . '&page_no=' . $recipes->getLastPage()) ?>"><?= $recipes->getLastPage() ?></a><li>
    <? endif ?>
  <li><a href="<?= getDomainUri() . url_for('@myrecipebox?folder=' . $sf_request->getParameter('folder', 'all') . '&order_by=' . $sf_request->getParameter('order_by', 'date-desc') . '&page_no=' . $recipes->getNextPage()) ?>">>></a><li>
</ul>