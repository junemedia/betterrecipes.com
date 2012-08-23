
<? if (isset($discussions) && sizeof($discussions) > 0): ?>
<? for ($i = 0; $i < count($discussions); $i++): ?>
<?
if( ($i + 1) % 3 == 0){
echo '<li class="last all-copy">';
} else {
echo '<li class="all-copy">';
}
?>
<p><a href="<?= url_for('@group_detail_discussions_detail?slug=' . $group['subdir'] . '&title=' . $discussions[$i]['slug'] . '&id=' . $discussions[$i]['thread_id']) ?>" title="<?= $discussions[$i]['title'] ?>"><?= $discussions[$i]['title'] ?></a></p>
<div>
<div><?= $discussions[$i]['last_post_content'] ?></div>
<p class="fs11"><?= $discussions[$i]['last_post_created'] ?><br />by: <a href="<?= getRoute('User', array('subdir' => $discussions[$i]['last_username'])) ?>" title="<?= $discussions[$i]['last_username'] ?>"><?= $discussions[$i]['last_display_name'] ?></a></p>
</div>
</li>
<? endfor; ?>
<? endif; ?>


<? if ($discussions_pager != ''): ?>
<? if ($discussions_pager->haveToPaginate()): ?>
<? $currentPage = $discussions_pager->getPage() ?>

<? if ($currentPage < $discussions_pager->getLastPage()): ?>
<li class="pagination">
<a href="javascript:;" style="cursor:pointer;" onclick="ajaxPaginateDiscussionsGroup('#discussions-list', '<?= url_for('@group_paginate_discussions') ?>', '<?= $discussions_pager->getNextPage() ?>', '<?= $group['subdir'] ?>')">&gt;&gt; Load more discussions</a>
</li>
<? endif; ?>

<? endif; ?>
<? endif; ?>

