<? foreach ($discussions as $i): ?>
<?
          $params = array(
            'category' => $i['category'],
            'slug' => $i['group_slug'],
            'title' => $i['slug'],
            'id' => $i['thread_id']
          );
          ?>          
  <li>
    <p><a href="<?= getRoute('@group_detail_discussions_detail', $params) ?>" title="<?= $i['title'] ?>"><?= $i['title'] ?></a></p>
    <p><?= $i['last_post_content'] ?></p>
    <p class="fs11">On <?= $i['created'] ?></p>
  </li>                               
<? endforeach; ?> 

<? if ($discussions_pager->haveToPaginate()): ?>
  	<? $currentPage = $discussions_pager->getPage() ?>

	<? if ($currentPage < $discussions_pager->getLastPage()): ?>
		<li class="pagination">
			<? $route = url_for('@cook_profile_discussions_paginate'); ?>
	        <a style="margin-left:2%" onclick="ajaxPaginateUserDiscussions('#list', '<?=$route?>', '<?=$discussions_pager->getNextPage()?>', '<?=$userId?>')" title="Load more entries" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more entries</a>
        </li>
    <? endif; ?>

<? endif; ?>
