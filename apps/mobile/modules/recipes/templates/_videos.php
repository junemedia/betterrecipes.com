<? if (isset($videos) && sizeof($videos) > 0): ?>
<div class="videos">
  <div class="header">
    <a href="<?=getRoute('@search', array('page' => 'video'))?>" title="View All Videos">
    <span class="green">TOP <?= strtoupper($category->getName()) ?> VIDEOS</span><span class="all">>> All</span></a>
    <!-- NOT IN DESIGN...
    <div class="ad100x40">
      <a href="#" title="Faux Ad 100x40"><img src="/img/m/fauxad-100x40.jpg" height="40" width="100" alt="100x40 AD" /></a>
    </div>
    -->
  </div>
  <ul class="hor-list">
  <? for ($i = 0; $i < count($videos['items']); $i++): ?>
    <?
			if( ($i + 1) % 3 == 0){
				echo '<li class="last">';
			} else if (($i + 1) % 3 == 1) {
				echo '<li class="first">';
			} else {
				echo '<li>';
			}
		?>
      <a href="<?=getRoute('@video_detail', array('slug' => $videos['items'][$i]['video_slug'], 'id' => $videos['items'][$i]['video_id']))?>" title="<?= $videos['items'][$i]['title'] ?>" class="img-wrap"><img src="<?= $videos['items'][$i]['preview_url'] ?>" height="75" width="75" alt="<?= $videos['items'][$i]['title'] ?>" /></a>
      <p><a href="<?=getRoute('@video_detail', array('slug' => $videos['items'][$i]['video_slug'], 'id' => $videos['items'][$i]['video_id']))?>" title="<?= $videos['items'][$i]['title'] ?>"><?= $videos['items'][$i]['title'] ?></a></p>
      <p class="fs11">By: <a href="<?=getRoute('User', array('subdir' => $videos['items'][$i]['username']))?>" title="<?= $videos['items'][$i]['display_name'] ?>"><?= $videos['items'][$i]['display_name'] ?></a></p>
    </li>
  <? endfor; ?>
  </ul>
</div>
<? endif; ?>