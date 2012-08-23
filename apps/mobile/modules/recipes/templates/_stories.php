<div class="stories">
  <? if (count(@$stories) > 0): ?>
    <p class="header">
      <span class="green">TOP HOW TO STORIES</span>
    </p>  
    <ul class="img100left divider">
      <? foreach ($stories as $story): ?>
        <li>
          <? $image = $story->getImage() ?>
          <? if (!empty($image)): ?>
            <a href="<?= getUrl($story) ?>" title="<?= $story->getName() ?>" class="img-wrap"><img src="<?= $story->getImgSrc('100x100') ?>" height="100" width="100" alt="<?= $story->getName() ?>" /></a>
          <? endif; ?>
          <div class="desc">
            <p><a href="<?= getUrl($story) ?>" title="<?= $story->getName() ?>"><?= $story->getName() ?></a></p>
            <p><?= Utilities::truncateHtml($story->getSummary(), 800) ?></p>
            <? $author = $story->getUser() ?>
          </div>
        </li>
      <? endforeach; ?>
    </ul>
  <? endif; ?>
</div><!-- /#top-stories -->
