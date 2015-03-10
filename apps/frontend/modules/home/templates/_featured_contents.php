<? if ($hpWonder && (sizeof($hpWonder) > 0)): ?>
  <div id="gallery">
    
    <div class="picture">
      <div class="picts">
        <? if ($hpWonder->getSlotOneImg() != ''): ?><img src="<?= $hpWonder->getImgSrc('one') ?>" alt="<?= $hpWonder->getSlotOneTitle() ?>" style="height:263px;"/><? endif; ?>
        <? if ($hpWonder->getSlotTwoImg() != ''): ?><img src="<?= $hpWonder->getImgSrc('two') ?>" alt="<?= $hpWonder->getSlotTwoTitle() ?>" style="height:263px;"/><? endif; ?>
        <? if ($hpWonder->getSlotThreeImg() != ''): ?><img src="<?= $hpWonder->getImgSrc('three') ?>" alt="<?= $hpWonder->getSlotThreeTitle() ?>" style="height:263px;"/><? endif; ?>
        <? if ($hpWonder->getSlotFourImg() != ''): ?><img src="<?= $hpWonder->getImgSrc('four') ?>" alt="<?= $hpWonder->getSlotFourTitle() ?>" style="height:263px;"/><? endif; ?>
        <? if ($hpWonder->getSlotFiveImg() != ''): ?><img src="<?= $hpWonder->getImgSrc('five') ?>" alt="<?= $hpWonder->getSlotFiveTitle() ?>" style="height:263px;"/><? endif; ?>
      </div>
    </div>
    <ul>
      <? if ($hpWonder->getSlotOneUrl() != ''): ?><li><a href="<?= $hpWonder->getSlotOneUrl() ?>"><?= $hpWonder->getSlotOneTitle() ?></a></li><? endif; ?>
      <? if ($hpWonder->getSlotTwoUrl() != ''): ?><li><a href="<?= $hpWonder->getSlotTwoUrl() ?>"><?= $hpWonder->getSlotTwoTitle() ?></a></li><? endif; ?>
      <? if ($hpWonder->getSlotThreeUrl() != ''): ?><li><a href="<?= $hpWonder->getSlotThreeUrl() ?>"><?= $hpWonder->getSlotThreeTitle() ?></a></li><? endif; ?>
      <? if ($hpWonder->getSlotFourUrl() != ''): ?><li><a href="<?= $hpWonder->getSlotFourUrl() ?>"><?= $hpWonder->getSlotFourTitle() ?></a></li><? endif; ?>
      <? if ($hpWonder->getSlotFiveUrl() != ''): ?><li><a href="<?= $hpWonder->getSlotFiveUrl() ?>"><?= $hpWonder->getSlotFiveTitle() ?></a></li><? endif; ?>
    </ul>
  </div><!-- /#gallery -->		
<? endif; ?>