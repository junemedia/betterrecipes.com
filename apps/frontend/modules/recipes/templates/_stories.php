<div id="top-stories">
  <? if (count(@$stories) > 0): ?>
    <p class="title">Top How To Stories</p>
    <ul class="imgleft">
      <? foreach ($stories as $story): ?>
        <li>
          <? $image = $story->getImage() ?>
          <? if (!empty($image)): ?>
            <a href="<?= getUrl($story) ?>" title="<?= $story->getName() ?>"><img src="<?= $story->getImgSrc('100x100') ?>" height="100" width="100" alt="<?= $story->getName() ?>" /></a>
          <? endif; ?>
          <p><a href="<?= getUrl($story) ?>" title="<?= $story->getName() ?>"><?= $story->getName() ?></a></p>
          <p><?= Utilities::truncateHtml($story->getSummary(), 800) ?></p>
          <? $author = $story->getUser() ?>
          
          <?
          /* removed by Rusty Cage, as per client ET # 5387
          <p class="fs11">by <a href="<?= getUrl($author) ?>" title="<?= $author->getDisplayName() ?>"><?= $author->getDisplayName() ?></a><?= date('@ m/d/Y h:i A', strtotime($story->getCreatedAt())) ?></p>
          */
          ?>
        </li>
      <? endforeach; ?>
    </ul>
  <? endif; ?>
</div><!-- /#top-stories -->
