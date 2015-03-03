<div class="landing">
  <p class="green fs15">GROUPS</p>
  <p>Swap recipes, kitchen war stories, and cooking advice in our member groups. With more than 1,000 groups on everything from gluten-free goodness and beyond-the-brown-bag lunch ideas to coupon cooking and backyard barbeque staples, there's sure to be one that'll whet your appetite.</p>
</div><!-- /.landing -->
<?/*
// Disabled featured group placeholder
<div class="featured">
  <img src="/img/m/img-group5.jpg" height="100" width="100" alt="Group Name" />
  <p class="fs15 green">Featured [Group Name]</p>
  <p>Lorem ipsum dolor sit amet, sectetur adipiscing elit. Mauris mi sapien, molestie dapibus vallis non...</p>
  <a href="#" title="Join this group" class="gray-btn">JOIN THIS GROUP</a>
</div>
*/?>
<? if (isset($popgroups['items'])): ?>
<div class="groups">
  <p class="header"><a href="<?=getRoute('@search', array('page' => 'group'))?>" title="View All Groups"><span class="green">TOP GROUPS</span><span class="all">>> All</span></a></p>
  <ul class="hor-list">
		<? for($i = 0; $i < count($popgroups['items']); $i++): ?>
			<? if ($i % 3 == 0): ?>
      <li class="row"><ul><li class="first">
      <? else: ?>
      <? if ($i % 3 == 2): ?>
      <li class="last">
      <? else: ?>
      <li>
				<? endif; ?>
        <? endif; ?>
        <a href="<?=getRoute('@group_detail', array('category' => $popgroups['items'][$i]['category'], 'slug' => $popgroups['items'][$i]['slug']))?>" title="<?=$popgroups['items'][$i]['group_display_name']?>">
        <img src="<?=$popgroups['items'][$i]['group_photo']?>" height="75" width="75" alt="<?=$popgroups['items'][$i]['group_display_name']?>" />
        <p><?=Utilities::truncateHtml($popgroups['items'][$i]['group_display_name'], 26)?></p>
        <p class="fs11 grey"><?=$popgroups['items'][$i]['num_members']?> Members</p>
        </a>
      </li>
      <? if ($i % 3 == 2): ?>
      </ul></li>
      <? endif; ?>
    <? endfor; ?>
  </ul>
</div><!-- /#groups -->
<? endif; ?>
