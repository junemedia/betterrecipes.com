<div id="activity_completed">
<? if ( @$activity && sizeof($activity) > 0 ): ?>
	<p class="header">Added to Your Activity</p>
	<p>Your Facebook and Better Recipe friends can now see that you've <?=$activity->getActions()->getActionDescription()?></p>
<? endif; ?>
<? if (isset($activityFriends) && sizeof($activityFriends) > 0): ?>
	<ul>
		<? $i = 0; ?>
		<? foreach($activityFriends as $f): ?>
			<li>
				<a href="#" title="<?=$f->getUser()->getFirstName()?> <?=$f->getUser()->getLastName()?>">
					<img src="<?=$f->getUser()->getAvatarSrc()?>" />
				</a>
			</li>
			<? if ($i == 6) { break; } ?>
			<? $i++; ?>
		<? endforeach; ?>
	</ul>
	<p> 
		<?=$activityFriends[0]->getUser()->getFirstName()?> <?=$activityFriends[0]->getUser()->getLastName()?> <? if( count($activityFriends) > 2): ?> and  <?=( count($activityFriends) - 1)?>  others<? endif; ?> <?=$activity->getActions()->getActionDescription()?>
	</p> 
<? endif; ?>
<? if ( @$activity && sizeof($activity) > 0 ): ?>
	<a href="javascript:;" onclick="closeActivityCompleted()">Okay</a> | <a href="javascript:;" onclick="deleteActivityCompleted(<?=$activity->getId()?>)">Delete this activity</a>
<? endif; ?>
</div><!-- // activityCompleted -->
<div class="seperator" />