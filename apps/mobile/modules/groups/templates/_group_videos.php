
<? if (isset($videos) && sizeof($videos) > 0): ?>
<? for ($i = 0; $i < count($videos); $i++): ?>
<?
if( ($i + 1) % 3 == 0){
echo '<li class="last">';
} else {
echo '<li>';
}
?>
  <a href="<?= getUrl('@video_detail', array('slug' => $videos[$i]['slug'], 'id' => $videos[$i]['video_id'])) ?>" class="img-wrap"><img src="<?= $videos[$i]['preview_url'] ?>" height="75" width="75" alt="<?= $videos[$i]['title'] ?>" /></a>
  <div class="desc">
  <p><a href="<?= getRoute('User', array('subdir' => $videos[$i]['username'])) ?>" title="<?= $videos[$i]['display_name'] ?>"><?= $videos[$i]['display_name'] ?></a></p>
  </div>
</li>
<? endfor; ?>
<? endif; ?>


<? if ($videos_pager != ''): ?>
<? if ($videos_pager->haveToPaginate()): ?>
<? $currentPage = $videos_pager->getPage() ?>

<? if ($currentPage < $videos_pager->getLastPage()): ?>
<li class="pagination">
  <a onclick="ajaxPaginateVideosGroups('#videos-list', '<?= url_for(@group_paginate_videos) ?>', '<?= $videos_pager->getNextPage() ?>', '<?= $group['subdir'] ?>', '<?= $sortby ?>')" title="Load more videos" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more videos</a>
</li>
<? endif; ?>

<? endif; ?>
<? endif; ?>
