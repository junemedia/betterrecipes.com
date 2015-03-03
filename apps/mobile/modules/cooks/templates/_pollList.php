<? foreach ($polls as $i): ?>
<li class="all-copy">
  <p><a href="<?= getRoute('@group_detail_polls_detail', array('category' => $i['category'], 'slug' => $i['group_slug'], 'poll_slug' => $i['poll_slug'], 'id' => $i['poll_id'])) ?>" title="<?= $i['title'] ?>"><?= $i['title'] ?></a></p>
  <p><?= $i['num_votes'] ?> votes</p>
  <p class="fs11">by: <a href="<?= getRoute('User', array('subdir' => $i['subdir'])) ?>" title="<?= $i['display_name'] ?>"><?= $i['display_name'] ?></a></p>
</li>                               
<? endforeach; ?> 

<? if ($polls_pager->haveToPaginate()): ?>
<? $currentPage = $polls_pager->getPage() ?>

<? if ($currentPage < $polls_pager->getLastPage()): ?>
<li class="pagination">
<? $route = url_for('@cook_profile_polls_paginate'); ?>
  <a onclick="ajaxPaginateUserPolls('#list', '<?=$route?>', '<?=$polls_pager->getNextPage()?>', '<?=$userId?>')" title="Load more entries" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more entries</a>
</li>
<? endif; ?>

<? endif; ?>