<script>
  $(document).ready(function() {
    $(":checkbox").each(function(){
      $(this).bind("click", function(e) {
          e.preventDefault();
      });
    });
  });
</script>
<div id="mainHeading">
  <h1>Polls</h1>
  <a href="/admin/polls/new" style="float:right;">Add New Poll</a>
</div>  


<div class="paginationRow">
  <? if ($pager->haveToPaginate()): ?>
    <div class="pagination">
      <div class="pagination_link">
        <?= link_to('<<', 'polls/index?page='.$pager->getPreviousPage()) ?>
      </div>
      <? $links = $pager->getLinks(); foreach ($links as $page): ?>   
        <div class="pagination_link">
          <?= ($page == $pager->getPage()) ? $page : link_to($page, 'polls/index?page='.$page) ?> 
        </div>
      <? endforeach; ?>
      <div class="pagination_link">
        <?= link_to('>>', 'polls/index?page='.$pager->getNextPage()) ?>
      </div>
    </div>
  <? endif; ?>
  </div>


<div id="pollsHeadings" class="headings big row">
  <ul>
    <li><span class="name nosort">Poll Name</span></li>
    <li><span class="voteCount nosort">Vote Count</span></li>
    <li><span class="nosort" style="width:100px;">Active</span></li>
    <li><span class="hpFeatured nosort">Home-page Featured</span></li>
  </ul>
</div> 

<ul id="pollsRows" class="results border-bottom">
    <? foreach ($pager->getResults() as $i => $c): ?> 
      <li class="row <?= ($i % 2) == 0 ? "even" : "odd"; ?>">
        <span class="name">
          <a href="<?= url_for('@poll_detail?id=' . $c->getId()) ?>" title="<?= $c->getPollTitle() ?>"><?= $c->getPollTitle() ?></a>
        </span>
        <span class="voteCount">
          <?= $c->getTotalVotes() ?>
        </span>
        <span style="width:100px;">
        	<? if ($c->getActive() == 0): ?>
        		No
        	<? else: ?>
        		Yes
        	<? endif; ?>
        </span>
        <span class="hpFeatured">
          <input type="checkbox"<? if ($hp_featured == $c->getId()): ?> checked='checked'<? endif; ?> id="cb_<?= $c->getId() ?>" />
        </span>
      </li>
    <? endforeach; ?>
</ul>



<div class="paginationRow">
  <? if ($pager->haveToPaginate()): ?>
    <div class="pagination">
      <div class="pagination_link">
        <?= link_to('<<', 'polls/index?page='.$pager->getPreviousPage()) ?>
      </div>
      <? $links = $pager->getLinks(); foreach ($links as $page): ?>   
        <div class="pagination_link">
          <?= ($page == $pager->getPage()) ? $page : link_to($page, 'polls/index?page='.$page) ?> 
        </div>
      <? endforeach; ?>
      <div class="pagination_link">
        <?= link_to('>>', 'polls/index?page='.$pager->getNextPage()) ?>
      </div>
    </div>
  <? endif; ?>
  </div>
