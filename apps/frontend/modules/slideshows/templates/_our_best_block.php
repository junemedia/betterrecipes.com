<div id="sidebar-ourbest">
  <p class="title">Our Best Recipe Collections</p>
  <? if (@$ob_slideshows): ?>
    <ul>
      <? //foreach ($ob_slideshows as $ob_slideshow): 

		//$recipe = $ob_slideshows[mt_rand(0,4)];
	  ?>
        <li>
			<div class="ourbest_image">
				<a href="<?= getUrl($ob_slideshow) ?>" title="<?= $ob_slideshow->getName() ?>"><img src="<?= $ob_slideshow->getImgSrc() ?>"/></a></a>
			</div>
          <p><a href="<?= getUrl($ob_slideshow) ?>" title="<?= $ob_slideshow->getName() ?>"><?= Utilities::truncateHtml($ob_slideshow->getName(), 45) ?></a></p>
        </li>
      <?// endforeach; ?>
    </ul>
  <? endif; ?>
</div><!-- /#sidebar-slideshows -->
