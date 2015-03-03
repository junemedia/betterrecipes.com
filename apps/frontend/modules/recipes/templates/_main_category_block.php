<? if ($children = @$category->getSelectedChildren()): ?>
  <a href="<?= getUrl($category) ?>" title="<?= $category->getName() ?>" class="imgmask100 bordshad"><img src="<?= $category->getImgSrc() ?>" alt="<?= $category->getName() ?>" /></a>
  <p class="title"><a href="<?= getUrl($category) ?>" title="<?= $category->getName() ?>"><?= $category->getName() ?></a></p>
  <p><?= $category->getDescription() ?></p>
  <ul class="subcats hornav ovhid mt10">
    <? foreach ($children as $child): ?>
      <li><a href="<?= getUrl($child) ?>" title="Subcategory"><?= $child->getName() ?></a></li>
    <? endforeach; ?>
  </ul>
<? endif; ?>