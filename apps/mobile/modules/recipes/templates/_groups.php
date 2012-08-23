<? if (isset($groups) && sizeof($groups) > 0): ?>
  <div class="groups">
    <div class="header">
    	<a href="<?= getRoute('@search', array('page' => 'group')) ?>" title="View All Groups">
      <span class="green">POPULAR <?= strtoupper($category->getSlug()) ?> GROUPS</span><span class="all">>> All</span></a>
      <!-- NOT IN DESIGN...
      <div class="ad100x40">
        <a href="#" title="Faux Ad 100x40"><img src="/img/m/fauxad-100x40.jpg" height="40" width="100" alt="100x40 AD" /></a>
      </div>
      -->
    </div><!-- /.header -->
    <ul class="hor-list">
    <? for ($i = 0; $i < count($groups['items']); $i++): ?>
      <?
			if( ($i + 1) % 3 == 0){
				echo '<li class="last">';
			} else if (($i + 1) % 3 == 1) {
				echo '<li class="first">';
			} else {
				echo '<li>';
			}
		?>
        <a href="<?= getRoute('@group_detail', array('category' => $groups['items'][$i]['category'], 'slug' => $groups['items'][$i]['group_slug'])) ?>" title="<?= $groups['items'][$i]['group_display_name'] ?>" class="img-wrap"><img src="<?= $groups['items'][$i]['group_photo'] ?>" height="75" width="75" alt="<?= $groups['items'][$i]['group_display_name'] ?>" /></a>
        <p><a href="<?= getRoute('@group_detail', array('category' => $groups['items'][$i]['category'], 'slug' => $groups['items'][$i]['group_slug'])) ?>" title="<?= $groups['items'][$i]['group_display_name'] ?>"><?= $groups['items'][$i]['group_display_name'] ?></a></p>
        <p class="fs11"><?= $groups['items'][$i]['num_members'] ?> members</p>
      </li>
    <? endfor; ?>
    </ul>
	</div><!-- /.discussions hasad -->
<? endif; ?>