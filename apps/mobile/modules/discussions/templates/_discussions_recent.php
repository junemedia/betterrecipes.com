<? for($i = 0; $i < count($recent); $i++): ?>
<?
$params = array(
'category' => $recent[$i]['category'],
'slug' => $recent[$i]['group_slug'],
'title' => $recent[$i]['slug'],
'id' => $recent[$i]['thread_id']
);
?>
<li class="all-copy">
  <p><a href="<?=getRoute('@group_detail_discussions_detail', $params)?>" title="<?=$recent[$i]['title']?> " ><?=$recent[$i]['title']?></a></p>
  <p><?=Utilities::truncateHtml($recent[$i]['last_post_content'], 135)?></p>
</li>
<? endfor; ?>

<? if ($recent_pager != ''): ?>
<? if ($recent_pager->haveToPaginate()): ?>
<? $currentPage = $recent_pager->getPage() ?>

<? if ($currentPage < $recent_pager->getLastPage()): ?>
<li class="pagination">
  <a  onclick="ajaxPaginateDiscussions('#recent', '/discussions/paginate_recent_discussion', '<?=$recent_pager->getNextPage()?>')" title="Load more discussions" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more discussions</a>
</li>
<? endif; ?>
<? endif; ?>
<? endif; ?>
