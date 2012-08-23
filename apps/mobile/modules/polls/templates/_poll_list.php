<? if (sizeof($polls)>0): ?>
<? for ($i = 0; $i < count($polls); $i++): ?>
<li class="all-copy">
  <p>
  <? if ($polls[$i]['type'] == 'network'): ?>
  <a href="<?=getDomainUri().url_for('@polls_network_detail?slug='.$polls[$i]['poll_slug'].'&id='.$polls[$i]['poll_id'])?>" title="<?=$polls[$i]['title']?>"><?=$polls[$i]['title']?></a><a href="<?=getDomainUri().url_for('@polls_network_detail?slug='.$polls[$i]['poll_slug'].'&id='.$polls[$i]['poll_id'])?>" title="Vote For This!" class="btn-grey28 flri">Vote</a>
  <? else: ?>
  <a href="<?=getRoute('@group_detail_polls_detail', array('category' => $polls[$i]['category'], 'slug' => $polls[$i]['group_slug'], 'poll_slug' => $polls[$i]['poll_slug'], 'id' => $polls[$i]['poll_id']))?>" title="<?=$polls[$i]['title']?>"><?=$polls[$i]['title']?></a>
  <a href="<?=getRoute('@group_detail_polls_detail', array('category' => $polls[$i]['category'], 'slug' => $polls[$i]['group_slug'], 'poll_slug' => $polls[$i]['poll_slug'], 'id' => $polls[$i]['poll_id']))?>" title="Vote For This!" class="btn-grey28 flri">Vote</a>
  <? endif; ?>
  </p>
  <p class="mt10 clri"><img src="/img/bg-poll-check.png" /> <? if ($polls[$i]['num_votes'] != '') { echo $polls[$i]['num_votes']; } else { echo '0'; } ?> votes</p>
</li>
<? endfor; ?>
<? endif; ?>

<? if ($polls_pager != ''): ?>
<? if ($polls_pager->haveToPaginate()): ?>
<? $currentPage = $polls_pager->getPage() ?>

<? if ($currentPage < $polls_pager->getLastPage()): ?>
<li class="pagination">
  <a onclick="ajaxPaginatePolls('#poll-list', '/polls/paginatepolls', '<?=$polls_pager->getNextPage()?>')" title="Load more polls" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more polls</a>
</li>
<? endif; ?>

<? endif; ?>
<? endif; ?>
