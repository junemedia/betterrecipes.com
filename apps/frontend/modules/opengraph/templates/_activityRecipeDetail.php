<? if (isset($activity) && $activityCount > 0): ?>
	<p>
		<? $i = 0; ?>
		<? foreach ($activity as $a): ?>
			<a href="http://www.facebook.com/<?= $a->getFbUserId() ?>"><?=$a->getUser()->getFirstName()?></a><? if ($i == 0 && $activityCount > 1): ?>, <? else: ?> <? endif; ?>
			<? if ($i == 1) { break; } ?>
			<? $i++; ?>
		<? endforeach; ?>
		<? if (isset($activityCount) && $activityCount > 1): ?>
			and <?=($activityCount - 1)?> 
			<? if (($activityCount - 1) > 1): ?>
				others are
			<? else: ?> 
				other is 
			<? endif; ?>  
		making this recipe. 
		<? else: ?> 
			is making this recipe. 
		<? endif; ?>
	</p>
	<!-- output FB avatars as list -->
	<ul>
		<? foreach ($activity as $a): ?>
			<li><a href="http://www.facebook.com/<?= $a->getFbUserId() ?>"><img src="<?= $a->getUser()->getAvatarSrc() ?>" alt="<?=$a->getUser()->getFirstName()?> <?=$a->getUser()->getLastName()?>" /></a></li>
		<? endforeach; ?>
	</ul>
<? endif; ?>
