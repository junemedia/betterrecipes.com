<div class="summary">
	<img src="<?= $category->getImgSrc() ?>" height="100" width="100" alt="<?= $category->getName() ?>" />
  <div class="desc">
    <p class="green fs15"><?= $category->getName() ?></p>
    <p><?= $category->getDescription() ?></p>
  </div>
</div>
<? if ($children = @$category->getSelectedChildren()): ?>
	<ul>
		<? foreach ($children as $child): ?>
			<li><a href="<?= getUrl($child) ?>" title="<?= $child->getName() ?>"><?= $child->getName() ?></a></li>
		<? endforeach; ?>
	</ul>
<? endif; ?>
