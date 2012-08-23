<? for ($i = 0; $i < count($recent); $i++): ?>
<li>
	<a href="<?=getRoute('@photo_detail', array('slug' => $recent[$i]['slug'], 'id' => $recent[$i]['photo_id']))?>" title="<?=$recent[$i]['caption']?>" class="img-wrap"><img src="<?=$recent[$i]['thumb_url']?>" alt="<?=$recent[$i]['caption']?>" width="75" height="75" /></a>
  <div class="desc">
    <p><a href="<?=getRoute('@photo_detail', array('slug' => $recent[$i]['slug'], 'id' => $recent[$i]['photo_id']))?>" title="<?=$recent[$i]['caption']?>"><?=Utilities::truncateHtml($recent[$i]['caption'], '36') ?></a></p>
    <p class="fs11">by: <a href="<?=getRoute('User', array('subdir' => $recent[$i]['username']))?>" title="<?=$recent[$i]['username']?>"><?=$recent[$i]['display_name']?></a></p>			
  </div>
</li>
<? endfor; ?>

<? if ($recent_pager != ''): ?>
<? if ($recent_pager->haveToPaginate()): ?>
<? $currentPage = $recent_pager->getPage() ?>

<? if ($currentPage < $recent_pager->getLastPage()): ?>
<li class="pagination">
  <a onclick="ajaxPaginatePhotos('#recent', '/photos/paginate_recent', '<?=$recent_pager->getNextPage()?>')" title="Load more photos" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more photos</a>
</li>
<? endif; ?>

<? endif; ?>
<? endif; ?>
