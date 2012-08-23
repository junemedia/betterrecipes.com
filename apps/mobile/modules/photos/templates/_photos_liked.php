<? for ($i = 0; $i < count($liked); $i++): ?>
<li>
  <a href="<?=getRoute('@photo_detail', array('slug' => $liked[$i]['slug'], 'id' => $liked[$i]['photo_id']))?>" title="<?=$liked[$i]['caption']?>" class="img-wrap"><img src="<?=$liked[$i]['thumb_url']?>" alt="<?=$liked[$i]['caption']?>" width="75" height="75" /></a>
  <div class="desc">
    <p><a href="<?=getRoute('@photo_detail', array('slug' => $liked[$i]['slug'], 'id' => $liked[$i]['photo_id']))?>" title="<?=$liked[$i]['caption']?>"><?=Utilities::truncateHtml($liked[$i]['caption'], '36') ?></a></p>
    <p class="fs11">by: <a href="<?=getRoute('User', array('subdir' => $liked[$i]['username']))?>" title="<?=$liked[$i]['username']?>"><?=$liked[$i]['display_name']?></a></p>			
  </div>
</li>
<? endfor; ?>

<? if ($liked_pager != ''): ?>
<? if ($liked_pager->haveToPaginate()): ?>
<? $currentPage = $liked_pager->getPage() ?>

<? if ($currentPage < $liked_pager->getLastPage()): ?>
<li class="pagination">
  <a onclick="ajaxPaginatePhotos('#popular', '/photos/paginate_liked', '<?=$liked_pager->getNextPage()?>')" title="Load more photos" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more photos</a>
</li>
<? endif; ?>

<? endif; ?>
<? endif; ?>
