<? if (sizeof($posts) > 0): ?>
	<? for ($i = 0; $i < count($posts); $i++): ?>
  	<?
			if( ($i + 1) % 3 == 0){
			echo '<li class="last">';
		} else {
			echo '<li>';
		}
	?>
    <a href="<?= getRoute('User', array('subdir' => $posts[$i]['username'])) ?>" title="<?= $posts[$i]['username'] ?>" class="img-wrap">
    <img src="<?= $posts[$i]['avatar'] ?>" alt="<?= $posts[$i]['display_name'] ?>" width="75" height="75" />
    </a>
    <div class="replies-wrap">
      <div><?= $posts[$i]['content'] ?></div>
      <p class="fs11">by: <a href="<?= getRoute('User', array('subdir' => $posts[$i]['username'])) ?>" title="<?= $posts[$i]['username'] ?>"><?= $posts[$i]['display_name'] ?></a>, @ <?= $posts[$i]['created'] ?></p>
    </div>
  </li>
  <? endfor; ?>
<? endif; ?>


<? if ($posts_pager != ''): ?>
	<? if ($posts_pager->haveToPaginate()): ?>
		<? $currentPage = $posts_pager->getPage() ?>
    
    <? if ($currentPage < $posts_pager->getLastPage()): ?>
      <li class="pagination">
        <a onclick="ajaxPaginateDiscussionsDetails('#discussions-detail-list', '<?= url_for(@group_paginate_discussions_detail) ?>', '<?= $posts_pager->getNextPage() ?>', '<?= $group['subdir'] ?>', '<?= $thread_id ?>')" title="Load more replies" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more replies</a>
      </li>
    <? endif; ?>
  
  <? endif; ?>
<? endif; ?>
