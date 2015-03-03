<div class="paginationRow">
  <? if ($pager->haveToPaginate()): ?>
    <div class="pagination">
      <div class="pagination_link">
        <?= link_to('<<', 'wonders/index?page='.$pager->getPreviousPage().'&filter_type='.$filter_type) ?>
      </div>
      <? $links = $pager->getLinks(); foreach ($links as $page): ?>   
        <div class="pagination_link">
          <?= ($page == $pager->getPage()) ? $page : link_to($page, 'wonders/index?page='.$page.'&filter_type='.$filter_type) ?> 
        </div>
      <? endforeach; ?>
      <div class="pagination_link">
        <?= link_to('>>', 'wonders/index?page='.$pager->getNextPage().'&filter_type='.$filter_type) ?>
      </div>
    </div>
  <? endif; ?>
  </div>


<div id="pollsHeadings" class="headings big row">
  <ul>
    <li><span class="name nosort">Name</span></li>
    <li><span class="nosort" style="width:100px;">Active</span></li>
  </ul>
</div> 

<ul id="pollsRows" class="results border-bottom">
    <? foreach ($pager->getResults() as $i => $c): ?> 
      <li class="row <?= ($i % 2) == 0 ? "even" : "odd"; ?>">
        <span class="name">
          <a href="<?= url_for('wonders/category_edit?id=' . $c->getId()) ?>" title="<?= $c->getTitle() ?>"><?= $c->getTitle() ?></a>
        </span>
        
        <span style="width:100px;">
        	<? if ($c->getIsActive() == 0): ?>
        		No
        	<? else: ?>
        		Yes
        	<? endif; ?>
        </span>
      </li>
    <? endforeach; ?>
</ul>

<div class="paginationRow">
  <? if ($pager->haveToPaginate()): ?>
    <div class="pagination">
      <div class="pagination_link">
        <?= link_to('<<', 'wonders/index?page='.$pager->getPreviousPage().'&filter_type='.$filter_type) ?>
      </div>
      <? $links = $pager->getLinks(); foreach ($links as $page): ?>   
        <div class="pagination_link">
          <?= ($page == $pager->getPage()) ? $page : link_to($page, 'wonders/index?page='.$page.'&filter_type='.$filter_type) ?> 
        </div>
      <? endforeach; ?>
      <div class="pagination_link">
        <?= link_to('>>', 'wonders/index?page='.$pager->getNextPage().'&filter_type='.$filter_type) ?>
      </div>
    </div>
  <? endif; ?>
  </div>