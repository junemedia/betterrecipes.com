<? // note: we also use this partial on homepage, todo: transform into component ?>
<? //  include_partial('home/top-groups', compact('popgroups')) ?>
<div class="mixingbowl">
  <p class="header"><a href="<?= getDomainUri() . '/groups' ?>" title="View All Groups"><span class="green">THE MIXING BOWL</span><span class="all">>> All</span></a></p><!-- /.header -->
	<? if (isset($activity)): ?>
  <ul class="mixingbowl-list img75left">
		<? $total = ( count($activity) > 4 ) ? 4 : count($activity); ?>
    <? for($i = 0; $i < $total; $i++): ?>
    <li>
		<? // if the activity is related to the forum, we need to display the user who last posted to the forum topic, NOT the user who initiated the forum thread ?>
		<? if ($activity[$i]['type'] == 'forum_thread' || $activity[$i]['type'] == 'forum_post'): ?>
      <a href="<?=getRoute('User', array('subdir' => $activity[$i]['content']['last_username']))?>" title="$activity[$i]['content']['last_username']" class="img-wrap">
        <img src="<?=$activity[$i]['content']['last_avatar']?>" height="75" width="75" alt="<?=$activity[$i]['content']['last_display_name']?>" />
      </a>
      <div class="detail">
        <p><a href="<?=getRoute('User', array('subdir' => $activity[$i]['content']['last_username']))?>" title="<?=$activity[$i]['content']['last_username']?>"><?=$activity[$i]['content']['last_display_name']?></a>
		<? else: ?>
      <div>
      <p><a href="<?=getRoute('User', array('subdir' => $activity[$i]['username']))?>" title="<?=$activity[$i]['username']?>"><?=$activity[$i]['display_name']?></a>
		<? endif; ?> 
		<?=Utilities::activityLabel($activity[$i]['type'])?>
		<? if ($activity[$i]['type'] == 'forum_thread' || $activity[$i]['type'] == 'forum_post'): ?>
			<?
        $params = array(
        'category' => $activity[$i]['category'],
        'slug' => $activity[$i]['group_slug'],
        'title' => $activity[$i]['content']['slug'],
        'id' => $activity[$i]['content']['thread_id']
        );
      ?>
      <a href="<?=getRoute('@group_detail_discussions_detail', $params)?>"><?=$activity[$i]['content']['title']?></a></p>
		<? elseif ($activity[$i]['type'] == 'comment'): ?>
			<?=$activity[$i]['content']['comment']?></p>
		<? elseif ($activity[$i]['type'] == 'video'): ?>
      <a href="<?=getRoute('@video_detail', array('slug' => $activity[$i]['content']['slug'], 'id' => $activity[$i]['content']['id']))?>" title="<?=$activity[$i]['content']['title']?>"><?=$activity[$i]['content']['title']?></a></p>
		<? elseif ($activity[$i]['type'] == 'photo'): ?>
      <a href="<?= getRoute('@photo_detail', array('slug' => $activity[$i]['content']['slug'], 'id' => $activity[$i]['content']['id'])) ?>" title="<?=$activity[$i]['content']['caption']?>"><?=$activity[$i]['content']['caption']?></a></p>
		<? endif; ?>
    <p class="fs11"><?=$activity[$i]['timestamp']?></p>
      </div>
    </li>
    <? endfor; ?>
  </ul>
  <? endif; ?>
</div><!-- /.mixing-bowl -->