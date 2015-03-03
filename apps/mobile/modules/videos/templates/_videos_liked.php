<? for ($i = 0; $i < count($liked); $i++): ?>
<li>
  <a href="<?=getRoute('@video_detail', array('slug' => $liked[$i]['slug'], 'id' => $liked[$i]['video_id']))?>" title="<?=$liked[$i]['title']?>" class="img-wrap"><img src="<?=$liked[$i]['preview_url']?>" alt="<?=$liked[$i]['title']?>" width="75" height="75" /></a>
  <div class="desc">
  <p><a href="<?=getRoute('@video_detail', array('slug' => $liked[$i]['slug'], 'id' => $liked[$i]['video_id']))?>" title="<?=$liked[$i]['title']?>"><?=Utilities::truncateHtml($liked[$i]['title'], '36') ?></a></p>
  <p class="fs11">by: <a href="<?=getRoute('User', array('subdir' => $liked[$i]['username']))?>" title="<?=$liked[$i]['username']?>"><?=$liked[$i]['display_name']?></a></p>			
  </div>
</li>
<? endfor; ?>

<? if ($liked_pager != ''): ?>
<? if ($liked_pager->haveToPaginate()): ?>
<? $currentPage = $liked_pager->getPage() ?>

<? if ($currentPage < $liked_pager->getLastPage()): ?>
<li class="pagination">
  <a onclick="ajaxPaginateVideos('#popular', '/videos/paginate_liked', '<?=$liked_pager->getNextPage()?>')" title="Load more videos" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more videos</a>
</li>
<? endif; ?>

<? endif; ?>
<? endif; ?>
