<script>
  $('#top-trending').cycle({ 
    fx:     'scrollHorz', 
    prev:   '#previous_tr', 
    next:   '#next_tr', 
    timeout: 0
  });   
</script>
<?php unset( $trending ); ?>
<? if (isset($trending) && sizeof($trending) > 0):  ?>
  <p class="title">Trending recipes</p>
  <div class="recipe-slidesshow-container">
    <img src="/img/prev.png" id="previous_tr" class="previous-img" />
    <div id="top-trending" class="recipe-slidesshow">
      <? foreach ($trending as $k => $r): $recipe = $r->getRecipe() ?>
        <? if (($k % 3) == 0): ?>
          <div class="img-group">
          <? endif; ?>
          <div class="activity-container">
            <div class="img-mask">
              <a href="<?= getUrl($recipe) ?>"><img src="<?= $recipe->getMainImageSrc() ?>" alt="<?= $recipe->getName() ?>" /></a>
            </div>
            <p class="rec_title">
              <a href="<?= getUrl($recipe) ?>"><?= Utilities::truncateHtml($recipe->getName(), 40) ?></a> 
              <br /> <?= $r->popularity ?> <? if ($r->popularity == 1): ?>person<? else: ?>people<? endif; ?> made this
            </p> 
          </div>
          <? if (($k % 3) == 2 || ($k + 1) == count($trending) || $k == 14): ?>
          </div>
        <? endif; ?>
        <? if ($k == 14) { break; } ?>
      <? endforeach; ?>
    </div><!-- // top-trending -->
    <img src="/img/next.png" id="next_tr" class="next-img" />
  </div>
<? endif; ?>