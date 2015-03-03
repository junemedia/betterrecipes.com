<? for($i = 0; $i < count($popular); $i++): ?>
<?
$params = array(
'category' => $popular[$i]['category'],
'slug' => $popular[$i]['group_slug'],
'title' => $popular[$i]['slug'],
'id' => $popular[$i]['thread_id']
);
?>
<li class="all-copy">
  <p><a href="<?=getRoute('@group_detail_discussions_detail', $params)?>" title="<?=$popular[$i]['title']?> " ><?=$popular[$i]['title']?></a></p>
  <p><?=Utilities::truncateHtml($popular[$i]['last_post_content'], 135)?></p>
</li>
<? endfor; ?>

<? if ($popular_pager != ''): ?>
<? if ($popular_pager->haveToPaginate()): ?>
<? $currentPage = $popular_pager->getPage() ?>

<? if ($currentPage < $popular_pager->getLastPage()): ?>
<li class="pagination">
  <a onclick="ajaxPaginateDiscussions('#popular', '/discussions/paginate_popular_discussion', '<?=$popular_pager->getNextPage()?>')" title="Load more discussions" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more discussions</a>
</li>
<? endif; ?>

<? endif; ?>
<? endif; ?>
