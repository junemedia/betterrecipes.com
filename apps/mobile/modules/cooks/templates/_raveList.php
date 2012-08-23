<? foreach ($comments as $i): ?>
<li>
  <p><?= $i['content'] ?></p>
  <p class="fs11">by: <a href="<?= getRoute('User', array('subdir' => $i['username'])) ?>" title="<?= $i['username'] ?>"><?= $i['display_name'] ?></a> @ <?= $i['created'] ?></p>
</li>                               
<? endforeach; ?> 

<? if ($comments_pager->haveToPaginate()): ?>
<? $currentPage = $comments_pager->getPage() ?>

<? if ($currentPage < $comments_pager->getLastPage()): ?>
<li class="pagination">
	<? $route = url_for('@cook_profile_raves_paginate'); ?>
  <a onclick="ajaxPaginateUserRaves('#list', '<?=$route?>', '<?=$comments_pager->getNextPage()?>', '<?=$content_id?>')" title="Load more entries" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more entries</a>
</li>
<? endif; ?>

<? endif; ?>