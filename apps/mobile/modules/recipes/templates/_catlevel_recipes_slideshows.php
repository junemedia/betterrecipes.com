<div class="recipes">
  <p class="header"><span class="green">FAVORITE <?= strtoupper($category->getName()) ?></span></p>
  <? if (@$recipes || @$slideshows): ?>
    <ul class="img75left pb10">
      <? foreach (@$recipes as $recipe): ?>
        <? $recipe_user = $recipe->getUser() ?>
        <? if ($recipe->hasPhoto()): ?>
          <li>
          <? else: ?>
          <li class="no-img">
          <? endif; ?>
          <? if ($recipe->hasPhoto()): ?>
            <a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>" class="img-wrap">
              <img src="<?= $recipe->getMainImage()->getImgSrc() ?>" height="75" width="75" alt="<?= $recipe->getName() ?>" />
            </a>
          <? endif; ?>
          <p><a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>"><?= $recipe->getName() ?></a></p>
          <p><?= Utilities::truncateHtml($recipe->getDescription(), 100) ?></p>
        </li>
      <? endforeach; ?>
      <? if (isset($slideshows) && count($slideshows) > 0): ?>
        <? foreach ($slideshows as $slideshow): ?>
          <li>
            <a href="<?= getUrl($slideshow) ?>" title="<?= $slideshow->getName() ?>" class="img-wrap">
              <? $slides = $slideshow->getSortedSlides() ?>
              <img src="<?= url_for($slides[0]->getImgSrc()) ?>" height="75" width="75"  alt="<?= Utilities::truncateHtml($slideshow->getName(), 200) ?>" />
            </a>
            <p><a href="<?= getUrl($slideshow) ?>" title="<?= $slideshow->getName() ?>"><?= Utilities::truncateHtml($slideshow->getName(), 200) ?></a></p>
            <p><?= Utilities::truncateHtml($slideshow->getDescription(), 100) ?></p>
          </li>
        <? endforeach; ?>
      <? endif; ?>
    </ul>
  <? endif; ?>
</div>