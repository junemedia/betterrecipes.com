<? for ($i = 0; $i < count($journal_popular); $i++): ?>
<li class="all-copy">
  <p><a href="<?=getRoute('@journal_detail', array('slug' => $journal_popular[$i]['title_url'], 'id' => $journal_popular[$i]['post_id']))?>" title="<?=$journal_popular[$i]['title']?>"><?=$journal_popular[$i]['title']?></a></p>
  <p><?=$journal_popular[$i]['summary']?></p>
  <p class="fs11">by <a href="<?=getRoute('User', array('subdir' => $journal_popular[$i]['username']))?>" title="<?=$journal_popular[$i]['username']?>"><?=$journal_popular[$i]['display_name']?></a> @ <?=$journal_popular[$i]['date_created']?></p>
</li>
<? endfor; ?>

<? if ($j_popular_pager != ''): ?>
<? if ($j_popular_pager->haveToPaginate()): ?>
<? $currentPage = $j_popular_pager->getPage() ?>

<? if ($currentPage < $j_popular_pager->getLastPage()): ?>
<li class="pagination">
  <a onclick="ajaxPaginateJournals('#popular', '/journals/paginate_popular_journal', '<?=$j_popular_pager->getNextPage()?>')" title="Load more journals" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more journals</a>
</li>
<? endif; ?>

<? endif; ?>
<? endif; ?>
