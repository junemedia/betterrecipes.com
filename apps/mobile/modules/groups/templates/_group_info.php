<? if (isset($group)): ?>
<div class="grp-detail">
	<p id="displayTitle" class="fs15 green pb10 pt10"><?=$group['display_name']?></p>
	<? if ($group['photo'] != ''): ?>
		<img src="<?=$group['photo']?>" height="100" width="100" alt="<?=$group['display_name']?>" />
	<? endif; ?>
    <p class="desc"><?=$group['desc_full']?></p>
    
    <? if (is_null($blog_id)): ?>
    	<a href="<?= getUrl('@group_join', array('slug'=>$group['subdir']))?>" title="Join this group" class="gray-btn flle ml10">JOIN THIS GROUP</a>
    <? endif; ?>
</div>
<? endif; ?>