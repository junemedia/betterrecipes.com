<? if (isset($popgroups['items'])): ?>
<div class="groups hasad groupshome">
  <div class="header">
    <a href="<?= getDomainUri() . '/groups' ?>" title="View All Groups"><span class="green">TOP GROUPS</span><span class="all">>> All</span></a>
    <? /* ET#6549 - revert this when ad tags are ready 
    <div class="ad100x40">
      <a href="#" title="Faux Ad 100x40"><img src="/img/m/fauxad-100x40.jpg" height="40" width="100" alt="100x40 AD" /></a>
    </div> */ ?>
  </div>
  <ul class="hor-list">
  	<? for($i = 0; $i < count($popgroups['items']); $i++): ?>
    <?
			if( ($i + 1) % 3 == 0){
				echo '<li class="last">';
			} else if (($i + 1) % 3 == 1) {
				echo '<li class="first">';
			} else {
				echo '<li>';
			}
		?>
      <a href="<?=getRoute('@group_detail', array('category' => $popgroups['items'][$i]['category'], 'slug' => $popgroups['items'][$i]['slug']))?>" title="<?=$popgroups['items'][$i]['group_display_name']?>">
      <img src="<?=$popgroups['items'][$i]['group_photo']?>" height="75" width="75" alt="<?=$popgroups['items'][$i]['group_display_name']?>" />
      <p><?=Utilities::truncateHtml($popgroups['items'][$i]['group_display_name'], 26)?></p>
      <p class="fs11 grey"><?=$popgroups['items'][$i]['num_members']?> Members</p>
      </a>
    </li>
    <? endfor; ?>
  </ul>
</div>
<? endif; ?>