<? if ($categoryWonder && (sizeof($categoryWonder) > 0)): ?>
  <p class="title" style="margin-top:10px;">Popular Categories</p>
  <div id="editorials" style="width:650px;">
    <? $cat1 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotOneCatId()); ?>
    <? $subcat1 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotOneSubcatOne()); ?>
    <? $subcat2 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotOneSubcatTwo()); ?>
    <div >
      <div class="header">
        <a href="<?= getUrl($cat1) ?>" title="<?= $cat1->getName() ?>"><img src="<?= $cat1->getImgSrc() ?>" alt="<?= $cat1->getName() ?>"  /></a>
        <p class="mb10"><a href="<?= getUrl($cat1) ?>" title="<?= $cat1->getName() ?>"><?= $cat1->getName() ?></a></p>
        <p><?= $categoryWonder->getSlotOneDescription() ?></p>

      </div><!-- /.header -->
    </div><!-- /.mr40 -->
    <? $cat2 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotTwoCatId()); ?>
    <? $subcat1 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotTwoSubcatOne()); ?>
    <? $subcat2 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotTwoSubcatTwo()); ?>
    <div>
      <div class="header">
        <a href="<?= getUrl($cat2) ?>" title="<?= $cat2->getName() ?>"><img src="<?= $cat2->getImgSrc() ?>" alt="<?= $cat2->getName() ?>"  /></a>
        <p class="mb10"><a href="<?= getUrl($cat2) ?>" title="<?= $cat2->getName() ?>"><?= $cat2->getName() ?></a></p>
        <p><?= $categoryWonder->getSlotTwoDescription() ?></p>

      </div><!-- /.header -->
    </div>
    <? $cat3 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotThreeCatId()); ?>
    <? $subcat1 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotThreeSubcatOne()); ?>
    <? $subcat2 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotThreeSubcatTwo()); ?>
    <div >
      <div class="header">
        <a href="<?= getUrl($cat3) ?>" title="<?= $cat3->getName() ?>"><img src="<?= $cat3->getImgSrc() ?>" alt="<?= $cat3->getName() ?>"  /></a>
        <p class="mb10"><a href="<?= getUrl($cat3) ?>" title="<?= $cat3->getName() ?>"><?= $cat3->getName() ?></a></p>
        <p><?= $categoryWonder->getSlotThreeDescription() ?></p>

      </div><!-- /.header -->
    </div><!-- /.mr40 -->
    <? $cat4 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotFourCatId()); ?>
    <? $subcat1 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotFourSubcatOne()); ?>
    <? $subcat2 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotFourSubcatTwo()); ?>
    <div>
      <div class="header">
        <a href="<?= getUrl($cat4) ?>" title="<?= $cat4->getName() ?>"><img src="<?= $cat4->getImgSrc() ?>" alt="<?= $cat4->getName() ?>"  /></a>
        <p class="mb10"><a href="<?= getUrl($cat4) ?>" title="<?= $cat4->getName() ?>"><?= $cat4->getName() ?></a></p>
        <p><?= $categoryWonder->getSlotFourDescription() ?></p>
      </div><!-- /.header -->
    </div>
  </div><!-- /#EDITORIALS -->
<? endif; ?>
