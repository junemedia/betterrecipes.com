<? for($i = 0; $i < count($f); $i++): ?>
  <?
		if($i % 3 == 2){
		echo '<li class="last">';
		} else if($i % 3 == 0){
		echo '<li class="first">';
		} else {
		echo '<li>';
		}
	?>
    <a href="<?=getRoute('User', array('subdir' => $f[$i]['username']))?>" title="<?=$f[$i]['display_name']?>" class="img-wrap"><img src="<?=$f[$i]['user_avatar']?>" alt="<?=$f[$i]['display_name']?>" width="75" height="75" /></a>
    <a href="<?=getRoute('User', array('subdir' => $f[$i]['username']))?>" title="<?=$f[$i]['display_name']?>"><?=$f[$i]['display_name']?></a>
  </li>                               
<? endfor; ?> 

<? if ($f_pager->haveToPaginate()): ?>
  	<? $currentPage = $f_pager->getPage() ?>

	<? if ($currentPage < $f_pager->getLastPage()): ?>
		<li class="pagination">
			<? $route = url_for('@cook_profile_friends_paginate'); ?>
	        <a style="margin-left:2%" onclick="ajaxPaginateUserFriends('#list', '<?=$route?>', '<?=$f_pager->getNextPage()?>', '<?=$userId?>')" title="Load more entries" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more entries</a>
        </li>
    <? endif; ?>

<? endif; ?>