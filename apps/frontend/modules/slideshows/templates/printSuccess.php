<style type="text/css">
  .slidesshowprint {
    width:900px;
    overflow:hidden;
  }
  .slidesshowprint > li {
    width:100%;
    overflow:hidden;
    margin-bottom:20px;
  }
  .slidesshowprint li.slide {
    display:inline-block;
    float:left;
    margin-left: 30px;
    width: 135px;
    height: 160px;
  }
  .slidesshowprint li.slide img {
    height:auto;
  }
</style>
<? $slides = @$slideshow->getSortedSlides() ?>
<? if (count($slides) > 0): ?>
  <h1><?= $slideshow->getName() ?></h1>
  <ul class="slidesshowprint">
    <? foreach ($slides as $key => $slide): ?>
      <li class="slide">
        <img src="<?= $slide->getImgSrc() ?>" width="135px" alt="Recipe Title" />
        <p class="mt10"><a href="<?= getUrl($slide->getImgParentObj()) ?>" title="Recipe Title"><?= $slide->getName() ?></a></p>
      </li>
    <? endforeach; ?>
  </ul>
<? endif; ?>
