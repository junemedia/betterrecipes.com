<? foreach ($videos as $i): ?>
  <li>
    <a href="<?= getDomainUri() . url_for('@video_detail?slug=' . $i['slug'] . '&id=' . $i['video_id']) ?>" title="<?= $i['title'] ?>" class="img-wrap"><img src="<?= $i['preview_url'] ?>" alt="<?= $i['title'] ?>" width="75" height="75" /></a>
    <p class="desc"><a href="<?= getDomainUri() . url_for('@video_detail?slug=' . $i['slug'] . '&id=' . $i['video_id']) ?>" title="<?= $i['title'] ?>"><?= $i['title'] ?></a></p>
  </li>                               
<? endforeach; ?> 

<? if ($videos_pager->haveToPaginate()): ?>
  	<? $currentPage = $videos_pager->getPage() ?>

	<? if ($currentPage < $videos_pager->getLastPage()): ?>
  <li class="pagination">
  <? $route = url_for('@cook_profile_videos_paginate'); ?>
  	<a onclick="ajaxPaginateUserVideos('#list', '<?=$route?>', '<?=$videos_pager->getNextPage()?>', '<?=$userId?>')" title="Load more entries" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more entries</a>
  </li>
  <? endif; ?>

<? endif; ?>