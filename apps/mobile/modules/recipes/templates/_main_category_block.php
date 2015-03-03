<div class="header">
	<a href="<?= getUrl($category) ?>" title="View All Recipes">
    <span class="green"><?= $category->getName() ?></span><span class="all">>> All</span></a>
</div>
<a href="<?= getUrl($category) ?>" class="img-wrap"><img src="<?= $category->getImgSrc() ?>" height="75" width="75" alt="<?= $category->getName() ?>" /></a>
<p class="desc"><?= $category->getDescription() ?></p>