<? foreach ($photos as $p): ?>
  <li>
    <a href="<?= getDomainUri() . url_for('@photo_detail?slug=' . $p['slug'] . '&id=' . $p['photo_id']) ?>" title="<?= $p['caption'] ?>" class="img-wrap"><img src="<?= $p['thumb_url'] ?>" alt="<?= $p['caption'] ?>" width="75" height="75" /></a>
    <a href="<?= getDomainUri() . url_for('@photo_detail?slug=' . $p['slug'] . '&id=' . $p['photo_id']) ?>" title="<?= $p['caption'] ?>"><?= $p['caption'] ?></a>
  </li>                               
<? endforeach; ?> 

<? if ($photos_pager->haveToPaginate()): ?>
  	<? $currentPage = $photos_pager->getPage() ?>

	<? if ($currentPage < $photos_pager->getLastPage()): ?>
		<li class="pagination">
			<? $route = url_for('@cook_profile_photos_paginate'); ?>
	        <a onclick="ajaxPaginateUserPhotos('#list', '<?=$route?>', '<?=$photos_pager->getNextPage()?>', '<?=$userId?>')" title="Load more entries" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more entries</a>
        </li>
    <? endif; ?>

<? endif; ?>