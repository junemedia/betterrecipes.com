<? if (isset($photos) && sizeof($photos) > 0): ?>
<div class="photos">
  <div class="header">
  	<a href="<?=getRoute('@search', array('page' => 'photo'))?>" title="View All Photos">
    <span class="green">TOP <?= strtoupper($category->getName()) ?> PHOTOS</span><span class="all">>> All</span></a>
    <!-- NOT IN DESIGN...
    <div class="ad100x40">
      <a href="#" title="Faux Ad 100x40"><img src="/img/m/fauxad-100x40.jpg" height="40" width="100" alt="100x40 AD" /></a>
    </div>
    -->
  </div>
  <ul class="hor-list">
  <? for ($i = 0; $i < count($photos['items']); $i++): ?>
    <?
			if( ($i + 1) % 3 == 0){
				echo '<li class="last">';
			} else if (($i + 1) % 3 == 1) {
				echo '<li class="first">';
			} else {
				echo '<li>';
			}
		?>
      <a href="<?=getRoute('@photo_detail', array('slug' => $photos['items'][$i]['photo_slug'], 'id' => $photos['items'][$i]['photo_id']))?>" title="<?= $photos['items'][$i]['caption'] ?>" class="img-wrap"><img src="<?= $photos['items'][$i]['thumb_url'] ?>" height="75" width="75" alt="<?= $photos['items'][$i]['caption'] ?>" /></a>
      <p><a href="<?=getRoute('@photo_detail', array('slug' => $photos['items'][$i]['photo_slug'], 'id' => $photos['items'][$i]['photo_id']))?>" title="<?= $photos['items'][$i]['caption'] ?>"><?= $photos['items'][$i]['caption'] ?></a></p>
      <p class="fs11">By: <a href="<?=getRoute('User', array('subdir' => $photos['items'][$i]['username']))?>" title="<?= $photos['items'][$i]['display_name'] ?>"><?= $photos['items'][$i]['display_name'] ?></a></p>
    </li>
  <? endfor; ?>
  </ul>
</div>
<? endif; ?>