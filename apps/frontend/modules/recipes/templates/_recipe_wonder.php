<? if ($rWonder): ?>
  <div id="gallery">
    <div class="marker"></div>
    <div class="picture">
      <div class="picts">
        <? if ($rWonder->getSlotOneImg() != ''): ?><img src="<?= $rWonder->getImgSrc('one') ?>" alt="<?= $rWonder->getSlotOneTitle() ?>" /><? endif; ?>
        <? if ($rWonder->getSlotTwoImg() != ''): ?><img src="<?= $rWonder->getImgSrc('two') ?>" alt="<?= $rWonder->getSlotTwoTitle() ?>" /><? endif; ?>
        <? if ($rWonder->getSlotThreeImg() != ''): ?><img src="<?= $rWonder->getImgSrc('three') ?>" alt="<?= $rWonder->getSlotThreeTitle() ?>" /><? endif; ?>
        <? if ($rWonder->getSlotFourImg() != ''): ?><img src="<?= $rWonder->getImgSrc('four') ?>" alt="<?= $rWonder->getSlotFourTitle() ?>" /><? endif; ?>
        <? if ($rWonder->getSlotFiveImg() != ''): ?><img src="<?= $rWonder->getImgSrc('five') ?>" alt="<?= $rWonder->getSlotFiveTitle() ?>" /><? endif; ?>
      </div>
    </div>
    <ul>
      <? if ($rWonder->getSlotOneUrl() != ''): ?><li><a href="<?= $rWonder->getSlotOneUrl() ?>"><?= $rWonder->getSlotOneTitle() ?></a></li><? endif; ?>
      <? if ($rWonder->getSlotTwoUrl() != ''): ?><li><a href="<?= $rWonder->getSlotTwoUrl() ?>"><?= $rWonder->getSlotTwoTitle() ?></a></li><? endif; ?>
      <? if ($rWonder->getSlotThreeUrl() != ''): ?><li><a href="<?= $rWonder->getSlotThreeUrl() ?>"><?= $rWonder->getSlotThreeTitle() ?></a></li><? endif; ?>
      <? if ($rWonder->getSlotFourUrl() != ''): ?><li><a href="<?= $rWonder->getSlotFourUrl() ?>"><?= $rWonder->getSlotFourTitle() ?></a></li><? endif; ?>
      <? if ($rWonder->getSlotFiveUrl() != ''): ?><li><a href="<?= $rWonder->getSlotFiveUrl() ?>"><?= $rWonder->getSlotFiveTitle() ?></a></li><? endif; ?>
    </ul>
  </div><!-- /#gallery -->		
<? endif; ?>
