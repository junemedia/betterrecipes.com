<? if (@$slideshows): ?>
<script>
  $('#top-friends-recipes').cycle({ 
    fx:     'scrollHorz', 
    prev:   '#previous_fr', 
    next:   '#next_fr', 
    timeout: 0
  });   
</script>

 <p class="title">Top <?= $category_name ?> Slideshows</p>
 <div class="recipe-slidesshow-container">
    <img src="/img/prev.png" id="previous_fr" class="previous-img" <? if(count($slideshows) <= 3): ?> style="display:none;" <? endif; ?> />
    <div id="top-friends-recipes" class="recipe-slidesshow">
       <? foreach ($slideshows as $k => $slideshow): ?>
        <? if (($k % 3) == 0): ?>
          <div class="img-group">
          <? endif; ?>
          <div class="activity-container">
            <div class="img-mask">
            	<? $slides = $slideshow->getSortedSlides() ?>
              <a href="<?= getUrl($slideshow) ?>" title="<?= $slideshow->getName() ?>">
                <img src="<?= url_for($slides[0]->getImgSrc()) ?>" alt="<?= Utilities::truncateHtml($slideshow->getName(), 50) ?>" />
              </a>
            </div>
            <div class="activity-info">
              <p class="rec_title"><a href="<?= getUrl($slideshow) ?>"><?= $slideshow->getName() ?></a> </p>
              
                <p style="height:40px;"> 
                  <?= Utilities::truncateHtml($slideshow->getDescription(), 90) ?>
                </p> 
            </div>
          </div>
          <? if (($k % 3) == 2 || ($k + 1) == count($slideshows)): ?>
          </div>
        <? endif; ?>
      <? endforeach; ?>
    </div><!-- // top-friends-recipes -->
    <img src="/img/next.png" id="next_fr" class="next-img" <? if(count($slideshows) <= 3): ?> style="display:none;" <? endif; ?> />
  </div>
  <div class="clear-both"></div>


<? endif; ?>