<? include_partial('group_info', compact('my_group', 'group', 'blog_id', 'active', 'is_sponsor', 'sponsor')) ?>
<div class="mixingbowl">
	<? if (isset($group_activity)): ?>
  <div class="header">
    <p class="green">GROUP ACTIVITY</p>
		<? /* <a href="<?=getRoute('@search', array('page' => 'group'))?>" title="View All Groups">>> All</a> */ ?>
  </div>
  <ul class="img75left divider">
		<? $total = ( count($group_activity) > 4 ) ? 4 : count($group_activity); ?>
		<? for($i = 0; $i < $total; $i++): ?>
    <li>
			<? // if the activity is related to the forum, we need to display the user who last posted to the forum topic, NOT the user who initiated the forum thread ?>
			<? if ($group_activity[$i]['type'] == 'forum_thread' || $group_activity[$i]['type'] == 'forum_post'): ?>
      <a href="<?=getRoute('User', array('subdir' => $group_activity[$i]['content']['last_username']))?>" title="$group_activity[$i]['content']['last_username']" class="img-wrap">
        <img src="<?=$group_activity[$i]['content']['last_avatar']?>" height="75" width="75" alt="<?=$group_activity[$i]['content']['last_display_name']?>" />
      </a>
      <div>
        <p><a href="<?=getRoute('User', array('subdir' => $group_activity[$i]['content']['last_username']))?>" title="<?=$group_activity[$i]['content']['last_username']?>"><?=$group_activity[$i]['content']['last_display_name']?></a>
			<? else: ?>
      <div>
        <p><a href="<?=getRoute('User', array('subdir' => $group_activity[$i]['username']))?>" title="<?=$group_activity[$i]['username']?>"><?=$group_activity[$i]['display_name']?></a>
			<? endif; ?> 
			<?=Utilities::activityLabel($group_activity[$i]['type'])?> 
			<? if ($group_activity[$i]['type'] == 'forum_thread' || $group_activity[$i]['type'] == 'forum_post'): ?>
				<?
          $params = array(
          'category' => $group_activity[$i]['category'],
          'slug' => $group_activity[$i]['group_slug'],
          'title' => $group_activity[$i]['content']['slug'],
          'id' => $group_activity[$i]['content']['thread_id']
          );
        ?>
          <a href="<?=getRoute('@group_detail_discussions_detail', $params)?>"><?=$group_activity[$i]['content']['title']?></a></p>
        <? elseif ($group_activity[$i]['type'] == 'comment'): ?>
          <?=$group_activity[$i]['content']['comment']?></p>
        <? elseif ($group_activity[$i]['type'] == 'video'): ?>
          <a href="<?=getRoute('@video_detail', array('slug' => $group_activity[$i]['content']['slug'], 'id' => $group_activity[$i]['content']['id']))?>" title="<?=$group_activity[$i]['content']['title']?>"><?=$group_activity[$i]['content']['title']?></a></p>
        <? elseif ($group_activity[$i]['type'] == 'photo'): ?>
          <a href="<?= getRoute('@photo_detail', array('slug' => $group_activity[$i]['content']['slug'], 'id' => $group_activity[$i]['content']['id'])) ?>" title="<?=$group_activity[$i]['content']['caption']?>"><?=$group_activity[$i]['content']['caption']?></a></p>
        <? endif; ?>
        <p class="fs11"><?=$group_activity[$i]['timestamp']?></p>
      </div>
    </li>
    <? endfor; ?>
  </ul>
  <? endif; ?>
</div>
<? include_partial('link_people'); ?>
<? include_partial('link_discussions'); ?>
<? include_partial('link_recipes'); ?>
<? include_partial('link_polls'); ?>
<? include_partial('link_photos'); ?>
<? include_partial('link_videos'); ?>
