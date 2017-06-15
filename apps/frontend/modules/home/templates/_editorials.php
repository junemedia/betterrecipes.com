<?php if ($categoryWonder && (sizeof($categoryWonder) > 0)): ?>
  <p class="title" style="margin-top:10px;">Popular Categories</p>
  <div id="editorials" style="width:650px;">
    <?php $cat1 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotOneCatId()); ?>
    <?php $subcat1 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotOneSubcatOne()); ?>
    <?php $subcat2 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotOneSubcatTwo()); ?>
    <div >
      <div class="header">
        <a href="<?php echo getUrl($cat1) ?>" title="<?php echo $cat1->getName() ?>"><img src="<?php echo $cat1->getImgSrc() ?>" alt="<?php echo $cat1->getName() ?>"  /></a>
        <p class="mb10"><a href="<?php echo getUrl($cat1) ?>" title="<?php echo $cat1->getName() ?>"><?php echo $cat1->getName() ?></a></p>
        <p><?php echo $categoryWonder->getSlotOneDescription() ?></p>

      </div><!-- /.header -->
    </div><!-- /.mr40 -->
    <?php $cat2 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotTwoCatId()); ?>
    <?php $subcat1 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotTwoSubcatOne()); ?>
    <?php $subcat2 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotTwoSubcatTwo()); ?>
    <div>
      <div class="header">
        <a href="<?php echo getUrl($cat2) ?>" title="<?php echo $cat2->getName() ?>"><img src="<?php echo $cat2->getImgSrc() ?>" alt="<?php echo $cat2->getName() ?>"  /></a>
        <p class="mb10"><a href="<?php echo getUrl($cat2) ?>" title="<?php echo $cat2->getName() ?>"><?php echo $cat2->getName() ?></a></p>
        <p><?php echo $categoryWonder->getSlotTwoDescription() ?></p>

      </div><!-- /.header -->
    </div>
    <?php $cat3 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotThreeCatId()); ?>
    <?php $subcat1 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotThreeSubcatOne()); ?>
    <?php $subcat2 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotThreeSubcatTwo()); ?>
    <div >
      <div class="header">
        <a href="<?php echo getUrl($cat3) ?>" title="<?php echo $cat3->getName() ?>"><img src="<?php echo $cat3->getImgSrc() ?>" alt="<?php echo $cat3->getName() ?>"  /></a>
        <p class="mb10"><a href="<?php echo getUrl($cat3) ?>" title="<?php echo $cat3->getName() ?>"><?php echo $cat3->getName() ?></a></p>
        <p><?php echo $categoryWonder->getSlotThreeDescription() ?></p>

      </div><!-- /.header -->
    </div><!-- /.mr40 -->
    <?php $cat4 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotFourCatId()); ?>
    <?php $subcat1 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotFourSubcatOne()); ?>
    <?php $subcat2 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotFourSubcatTwo()); ?>
    <div>
      <div class="header">
        <a href="<?php echo getUrl($cat4) ?>" title="<?php echo $cat4->getName() ?>"><img src="<?php echo $cat4->getImgSrc() ?>" alt="<?php echo $cat4->getName() ?>"  /></a>
        <p class="mb10"><a href="<?php echo getUrl($cat4) ?>" title="<?php echo $cat4->getName() ?>"><?php echo $cat4->getName() ?></a></p>
        <p><?php echo $categoryWonder->getSlotFourDescription() ?></p>
      </div><!-- /.header -->
    </div>
  </div><!-- /#EDITORIALS -->
<?php endif; ?>
