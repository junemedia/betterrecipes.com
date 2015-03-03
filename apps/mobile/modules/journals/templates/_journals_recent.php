<? for ($i = 0; $i < count($journal_recent); $i++): ?>
<li class="all-copy">
  <p><a href="<?=getRoute('@journal_detail', array('slug' => $journal_recent[$i]['title_url'], 'id' => $journal_recent[$i]['post_id']))?>" title="<?=$journal_recent[$i]['title']?>"><?=$journal_recent[$i]['title']?></a></p>
  <p><?=$journal_recent[$i]['summary']?></p>
  <p class="fs11">by <a href="<?=getRoute('User', array('subdir' => $journal_recent[$i]['username']))?>" title="<?=$journal_recent[$i]['username']?>"><?=$journal_recent[$i]['display_name']?></a> @ <?=$journal_recent[$i]['date_created']?></p>
</li>
<? endfor; ?>

<? if ($j_recent_pager != ''): ?>
<? if ($j_recent_pager->haveToPaginate()): ?>
<? $currentPage = $j_recent_pager->getPage() ?>

<? if ($currentPage < $j_recent_pager->getLastPage()): ?>
<li class="pagination">
  <a onclick="ajaxPaginateJournals('#recent', '/journals/paginate_recent_journal', '<?=$j_recent_pager->getNextPage()?>')" title="Load more journals" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more journals</a>
</li>
<? endif; ?>

<? endif; ?>
<? endif; ?>
