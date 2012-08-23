<? if (isset($members)): ?>
<? for ($i = 0; $i < count($members); $i++): ?>
<?
if( ($i + 1) % 3 == 0){
echo '<li class="last">';
} else if (($i + 1) % 3 == 1) {
echo '<li class="first">';
} else {
echo '<li>';
}
?>
<a href="<?= getRoute('User', array('subdir' => $members[$i]['username'])) ?>"><img src="<?= $members[$i]['avatar'] ?>" height="75" width="75" alt="<?= $members[$i]['display_name'] ?>" /></a>
<div>
<p><a href="<?= getRoute('User', array('subdir' => $members[$i]['username'])) ?>" title="<?= $members[$i]['display_name'] ?>"><?= $members[$i]['display_name'] ?></a></p>
</div>
</li>
<? endfor; ?>
<? endif; ?>
<? if ($members_pager != ''): ?>
<? if ($members_pager->haveToPaginate()): ?>
<? $currentPage = $members_pager->getPage() ?>
<? if ($currentPage < $members_pager->getLastPage()): ?>
<li class="pagination">
<a onclick="ajaxPaginateMembers('#members', '<?= url_for(@group_paginate_members) ?>', '<?= $members_pager->getNextPage() ?>', '<?= $group['subdir'] ?>', '<?= $group_cat ?>')" title="Load more people" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more people</a>
</li>
<? endif; ?>
<? endif; ?>
<? endif; ?>