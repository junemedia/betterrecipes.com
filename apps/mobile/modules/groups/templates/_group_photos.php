

<? if (isset($photos) && sizeof($photos) > 0): ?>
<? for ($i = 0; $i < count($photos); $i++): ?>
<?
if( ($i + 1) % 3 == 0){
echo '<li class="last">';
} else {
echo '<li>';
}
?>
  <a href="<?= getUrl('@photo_detail', array('slug' => $photos[$i]['slug'], 'id' => $photos[$i]['photo_id'])) ?>" class="img-wrap"><img src="<?= $photos[$i]['thumb_url'] ?>" height="75" width="75" alt="<?= $photos[$i]['caption'] ?>" /></a>
  <div class="desc">
    <p><a href="<?= getRoute('User', array('subdir' => $photos[$i]['username'])) ?>" title="<?= $photos[$i]['display_name'] ?>"><?= $photos[$i]['display_name'] ?></a></p>
  </div>
</li>
<? endfor; ?>
<? endif; ?>


<? if ($photos_pager != ''): ?>
<? if ($photos_pager->haveToPaginate()): ?>
<? $currentPage = $photos_pager->getPage() ?>

<? if ($currentPage < $photos_pager->getLastPage()): ?>
<li class="pagination">
  <a onclick="ajaxPaginatePhotosGroups('#photos-list', '<?= url_for(@group_paginate_photos) ?>', '<?= $photos_pager->getNextPage() ?>', '<?= $group['subdir'] ?>', '<?= $sortby ?>')" title="Load more photos" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more photos</a>
</li>
<? endif; ?>

<? endif; ?>
<? endif; ?>
