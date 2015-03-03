<? for ($i = 0; $i < count($recent); $i++): ?>
<li>
  <a href="<?=getRoute('@video_detail', array('slug' => $recent[$i]['slug'], 'id' => $recent[$i]['video_id']))?>" title="<?=$recent[$i]['title']?>" class="img-wrap"><img src="<?=$recent[$i]['preview_url']?>" alt="<?=$recent[$i]['title']?>" width="75" height="75" /></a>
  <div class="desc">
    <p><a href="<?=getRoute('@video_detail', array('slug' => $recent[$i]['slug'], 'id' => $recent[$i]['video_id']))?>" title="<?=$recent[$i]['title']?>"><?=Utilities::truncateHtml($recent[$i]['title'], '36') ?></a></p>
    <p class="fs11">by: <a href="<?=getRoute('User', array('subdir' => $recent[$i]['username']))?>" title="<?=$recent[$i]['username']?>"><?=$recent[$i]['display_name']?></a></p>			
  </div>
</li>
<? endfor; ?>

<? if ($recent_pager != ''): ?>
<? if ($recent_pager->haveToPaginate()): ?>
<? $currentPage = $recent_pager->getPage() ?>

<? if ($currentPage < $recent_pager->getLastPage()): ?>
<li class="pagination">
  <a onclick="ajaxPaginateVideos('#recent', '/videos/paginate_recent', '<?=$recent_pager->getNextPage()?>')" title="Load more videos" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more videos</a>
</li>
<? endif; ?>

<? endif; ?>
<? endif; ?>
