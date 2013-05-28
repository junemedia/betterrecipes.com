<div id="popular-recipes">
  <p class="title">Your favorite <?= $category_name ?></p>
  <ul class="double-ul">
    <? if ($recipes): ?>
      <? $counter = 0; ?>
      <? foreach ($recipes as $recipe): ?>
        <li>
          <?
          $counter++;
          if ($counter % 2 == true) {
            echo"<ul><li>";
          }
          ?>
          <?
          /*
          * as per MERBETTERR-17 * 
          <? if ($recipe->hasPhoto()): ?>
            <a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>" class="imgmask100 flle mr10">
              <img src="<?= $recipe->getMainImageSrc() ?>" alt="<?= $recipe->getName() ?>" />
            </a>
          <? endif; ?>
          */
          ?>
          <p class="mb5"><a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>"><?= Utilities::truncateHtml($recipe->getName(), 50) ?></a></p>
          <p><?= Utilities::truncateHtml($recipe->getIntroduction(), 90) ?></p>
          <?
          if ($counter % 2 == false) {
            echo"</li></ul>";
          }
          ?>
        </li>
      <? endforeach; ?>
    <? endif; ?>
    <? if (@$slideshows): ?>
      <? foreach ($slideshows as $slideshow): ?>
        <li>
          <?
          $counter++;
          if ($counter % 2 == true) {
            echo"<ul><li>";
          }
          ?>
          <a href="<?= getUrl($slideshow) ?>" title="<?= $slideshow->getName() ?>" class="imgmask100 flle mr10">
            <? $slides = $slideshow->getSortedSlides() ?>
            <img src="<?= url_for($slides[0]->getImgSrc()) ?>" alt="<?= Utilities::truncateHtml($slideshow->getName(), 50) ?>" />
          </a>
          <p class="mb5">
            <a href="<?= getUrl($slideshow) ?>" title="<?= $slideshow->getName() ?>"><?= Utilities::truncateHtml($slideshow->getName(), 50) ?></a>
          </p>
          <p><?= Utilities::truncateHtml($slideshow->getDescription(), 90) ?></p>
          <?
          if ($counter % 2 == false) {
            echo"</li></ul>";
          }
          ?>
        </li>
      <? endforeach; ?>
    <? endif; ?>
  </ul>
</div><!-- /#popular-recipes -->