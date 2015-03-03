<div id="rating_boxes">
  <div id="rating_main" class="rating<? if(isset($rated)): ?> hidden<? endif; ?>">
    <p><span style="width:<?= $rating * 85 / 5 ?>px" ></span> Rate</p>
  </div>
  <div id="rating_top" class="rating<? if(!isset($rated)): ?> hidden<? endif; ?>">
    <? include_partial('user_rating', compact('user_rating')) ?>
  </div>  
</div>