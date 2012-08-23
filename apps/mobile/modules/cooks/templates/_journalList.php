<? foreach ($journals as $i): ?>
  <li>
    <p><a href="<?= getRoute('@journal_detail', array('slug' => $i['title_url'], 'id' => $i['post_id'])) ?>" title="<?= $i['title'] ?>"><?= $i['title'] ?></a></p>
    <p><?= $i['summary'] ?></p>
    <p class="fs11">by: <a href="<?= getRoute('User', array('subdir' => $i['username'])) ?>" title="<?= $i['username'] ?>"><?= $i['display_name'] ?></a> @ <?= $i['date_created'] ?></p>
  </li>                               
<? endforeach; ?> 

<? if ($journals_pager->haveToPaginate()): ?>
  	<? $currentPage = $journals_pager->getPage() ?>

	<? if ($currentPage < $journals_pager->getLastPage()): ?>
		<li class="pagination">
			<? $route = url_for('@cook_profile_journals_paginate'); ?>
	        <a style="margin-left:2%" onclick="ajaxPaginateUserJournals('#list', '<?=$route?>', '<?=$journals_pager->getNextPage()?>', '<?=$userId?>')" title="Load more entries" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more entries</a>
        </li>
    <? endif; ?>

<? endif; ?>