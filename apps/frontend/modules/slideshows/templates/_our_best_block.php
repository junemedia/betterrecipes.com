<div id="sidebar-ourbest" style="margin-bottom:20px; margin-top:20px;">
  <!--INFOLINKS_OFF-->
  <p class="title" style="width:300px; margin-bottom:-17px;">Our Best Recipe Collections</p>
  <!--INFOLINKS_ON-->
  <? if (@$ob_slideshows): ?>
    <ul>
      <? //foreach ($ob_slideshows as $ob_slideshow): 

		//$recipe = $ob_slideshows[mt_rand(0,4)];
	  ?>
        <li>
			<div class="ourbest_image">
				<a href="<?= getUrl($ob_slideshow) ?>" title="<?= $ob_slideshow->getName() ?>"><img style="width:300px; height:134px; margin-right:30px;" src="<?= $ob_slideshow->getImgSrc() ?>"/></a></a>
			</div>
          <p class="title" style="width:300px;"><a href="<?= getUrl($ob_slideshow) ?>" title="<?= $ob_slideshow->getName() ?>"><?= Utilities::truncateHtml($ob_slideshow->getName(), 45) ?></a></p>
        </li>
      <?// endforeach; ?>
    </ul>
  <? endif; ?>
</div><!-- /#sidebar-slideshows -->
