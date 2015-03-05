<div id="popular-recipes">
  <p class="title">Your favorite <?= $category->getName() ?></p>
  <ul>
  <? if($recipes): ?>
    <? foreach($recipes as $recipe): ?>
    <li>
      <p class="mb5"><a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>"><?= $recipe->getName() ?></a></p>
      <p><?= Utilities::truncateHtml($recipe->getIntroduction(), 95) ?></p>
    </li>
    <? endforeach; ?>
  <? endif; ?>
  <? if(@$slideshows): ?>
    <? foreach($slideshows as $slideshow): ?>
    <li>
      <p class="mb5"><a href="<?= getUrl($slideshow) ?>" title="<?= $slideshow->getName() ?>"><?= $slideshow->getName() ?></a></p>
      <p><?= Utilities::truncateHtml($slideshow->getDescription(), 95) ?></p>
    </li>
    <? endforeach; ?>
  <? endif; ?>
  </ul>
</div><!-- /#popular-recipes -->