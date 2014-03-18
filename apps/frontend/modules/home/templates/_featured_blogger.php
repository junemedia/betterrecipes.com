<? if ($featured_blogger && (sizeof($featured_blogger) > 0)): ?>
	<? //var_dump($featured_blogger); ?>
	<p class="title">Featured Blogger</p>
	
	<? foreach( $featured_blogger as $index => $value ): ?>
	<? if ( $index == 0): ?>
	<div class="blogger">
		<div class="blogger_gallery">
			<? if ( $value->getUser()->getAvatarSrc() == '/uploads/avatars/' || $value->getUser()->getAvatarSrc() == '/img/avatars/' ): ?>
			<a href="<?= getUrl('User', array('display_name' => $value->getUser()->getDisplayName())) ?>"><img src="/img/avatars/default_1.jpg" alt="<?= $value->getUser()->getDisplayName() ?>" /></a>
			<? else: ?>
			<a href="<?= getUrl('User', array('display_name' => $value->getUser()->getDisplayName())) ?>"><img src="<?= $value->getUser()->getAvatarSrc() ?>" alt="<?= $value->getUser()->getDisplayName() ?>" /></a>
			<? endif; ?>
		</div>
		<h3><a href="<?= getUrl('User', array('display_name' => $value->getUser()->getDisplayName())) ?>"><?= $value->getUser()->getDisplayName() ?></a></h3>
		
	</div>
	<? break; ?>
	<? endif; ?>
	<? endforeach; ?>
	
	<div class="blogger_recipes cfix">
			<? foreach( $featured_blogger as $index => $recipe ): ?>
					<div class="recipe-block">
					<a class="img-link" title="<?= $recipe->getName() ?>" href="<?= getUrl($recipe) ?>"><img width="100" height="100" src="<?= $recipe->getMainImageSrc() ?>"/></a>
					<a class="link" href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>"><?= $recipe->getName() ?></a>
					</div>
			<? endforeach; ?>
	</div><!-- // blogger_recipes -->
	
<? endif; ?>