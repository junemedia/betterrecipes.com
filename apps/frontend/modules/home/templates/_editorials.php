<? if ($categoryWonder && (sizeof($categoryWonder) > 0)): ?>
  <p class="title">Popular Categories</p>
  <div id="editorials" style="width:650px;">
    <? $cat1 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotOneCatId()); ?>
    <? $subcat1 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotOneSubcatOne()); ?>
    <? $subcat2 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotOneSubcatTwo()); ?>
    <div >
      <div class="header">
        <img src="<?= $cat1->getImgSrc() ?>" alt="<?= $cat1->getName() ?>"  />
        <p class="mb10"><a href="<?= getUrl($cat1) ?>" title="<?= $cat1->getName() ?>"><?= $cat1->getName() ?></a></p>
        <p><?= $categoryWonder->getSlotOneDescription() ?></p>
        <ul>
          <li><a href="<?= getUrl($subcat1) ?>" title="<?= $subcat1->getName() ?>"><?= $subcat1->getName() ?></a></li>	
          <li><a href="<?= getUrl($subcat2) ?>" title="<?= $subcat2->getName() ?>"><?= $subcat2->getName() ?></a></li>
        </ul>
      </div><!-- /.header -->
    </div><!-- /.mr40 -->
    <? $cat2 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotTwoCatId()); ?>
    <? $subcat1 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotTwoSubcatOne()); ?>
    <? $subcat2 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotTwoSubcatTwo()); ?>
    <div>
      <div class="header">
        <img src="<?= $cat2->getImgSrc() ?>" alt="<?= $cat2->getName() ?>"  />
        <p class="mb10"><a href="<?= getUrl($cat2) ?>" title="<?= $cat2->getName() ?>"><?= $cat2->getName() ?></a></p>
        <p><?= $categoryWonder->getSlotTwoDescription() ?></p>
        <ul>
          <li><a href="<?= getUrl($subcat1) ?>" title="<?= $subcat1->getName() ?>"><?= $subcat1->getName() ?></a></li>	
          <li><a href="<?= getUrl($subcat2) ?>" title="<?= $subcat2->getName() ?>"><?= $subcat2->getName() ?></a></li>
        </ul>
      </div><!-- /.header -->
    </div>
    <? $cat3 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotThreeCatId()); ?>
    <? $subcat1 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotThreeSubcatOne()); ?>
    <? $subcat2 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotThreeSubcatTwo()); ?>
    <div >
      <div class="header">
        <img src="<?= $cat3->getImgSrc() ?>" alt="<?= $cat3->getName() ?>"  />
        <p class="mb10"><a href="<?= getUrl($cat3) ?>" title="<?= $cat3->getName() ?>"><?= $cat3->getName() ?></a></p>
        <p><?= $categoryWonder->getSlotThreeDescription() ?></p>
        <ul>
          <li><a href="<?= getUrl($subcat1) ?>" title="<?= $subcat1->getName() ?>"><?= $subcat1->getName() ?></a></li>	
          <li><a href="<?= getUrl($subcat2) ?>" title="<?= $subcat2->getName() ?>"><?= $subcat2->getName() ?></a></li>
        </ul>
      </div><!-- /.header -->
    </div><!-- /.mr40 -->
    <? $cat4 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotFourCatId()); ?>
    <? $subcat1 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotFourSubcatOne()); ?>
    <? $subcat2 = Doctrine_Core::getTable('Category')->find($categoryWonder->getSlotFourSubcatTwo()); ?>
    <div>
      <div class="header">
        <img src="<?= $cat4->getImgSrc() ?>" alt="<?= $cat4->getName() ?>"  />
        <p class="mb10"><a href="<?= getUrl($cat4) ?>" title="<?= $cat4->getName() ?>"><?= $cat4->getName() ?></a></p>
        <p><?= $categoryWonder->getSlotFourDescription() ?></p>
        <ul>
          <li><a href="<?= getUrl($subcat1) ?>" title="<?= $subcat1->getName() ?>"><?= $subcat1->getName() ?></a></li>	
          <li><a href="<?= getUrl($subcat2) ?>" title="<?= $subcat2->getName() ?>"><?= $subcat2->getName() ?></a></li>
        </ul>
      </div><!-- /.header -->
    </div>
	
	<!--
	<div id="ERA_AD_BLOCK2" style="width:650px; float:left; clear:both;"></div>
	-->
	
	<!-- begin media.net 6 -->
	<script id="mNCC" language="javascript">  medianet_width='650';  medianet_height= '175';  medianet_crid='662071020';  </script>  <script id="mNSC" src="http://contextual.media.net/nmedianet.js?cid=8CU52X6SM" language="javascript"></script> 
	<!-- end media.net -->

	 <!-- ZERGNET ADS -->
	 <div style="font-family:Arial color:#000000; font-size:18px; font-weight:bold !important; margin-bottom:5px;">Around The Web</div>
	<div id="zergnet-widget-29018"></div>
	 
	<script language="javascript" type="text/javascript">
	(function() {
	var zergnet = document.createElement('script');
	zergnet.type = 'text/javascript'; zergnet.async = true;
	zergnet.src = 'http://www.zergnet.com/zerg.js?id=29018';
	var znscr = document.getElementsByTagName('script')[0];
	znscr.parentNode.insertBefore(zergnet, znscr);
	})();
	</script>
	
	<!-- ZERGNET NTENT ADS -->
	
	
	
  </div><!-- /#EDITORIALS -->	
<? endif; ?>



