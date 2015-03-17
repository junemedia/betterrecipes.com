<div id="sidebar-ourbest" style="margin-bottom:20px; margin-top:20px;">
<style>
#sidebar-ourbest, #sidebar-ourbest ul {
    clear: both;
    margin-top: 10px;
    text-align: center;
	background: none repeat scroll 0 0 transparent;
    border: 0 none;
    font-size: 100%;
    margin: 0;
    outline: 0 none;
    padding: 0;
    vertical-align: baseline;
}
#sidebar-ourbest{
	width:325px;
}

#sidebar-ourbest ol, #sidebar-ourbest ul {
    list-style: outside none none;	
}

#sidebar-ourbest a {
    color: #660066;
    cursor: pointer;
	text-decoration: none;
}
#sidebar-ourbest a:hover{
	text-decoration: underline;
}

#sidebar-ourbest .ourbest_image {
    margin-bottom: 5px;
	margin-top: 20px;
}
#sidebar-ourbest .title {
    font-size: 18px;
    font-weight: normal;
    line-height: 22px;
    margin-bottom: 5px;
    text-transform: uppercase;
}

#sidebar-ourbest p{
	margin:0px;
}
</style>
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
				<a href="<?= getUrl($ob_slideshow) ?>" title="<?= $ob_slideshow->getName() ?>"><img style="width:300px; height:134px; margin-right:30px;" src="<?= "http://".UrlToolkit::getDomain().$ob_slideshow->getImgSrc() ?>"/></a></a>
			</div>
          <p class="title" style="width:300px;"><a href="<?= getUrl($ob_slideshow) ?>" title="<?= $ob_slideshow->getName() ?>"><?= Utilities::truncateHtml($ob_slideshow->getName(), 62) ?></a></p>
        </li>
      <?// endforeach; ?>
    </ul>
  <? endif; ?>
</div><!-- /#sidebar-slideshows -->
