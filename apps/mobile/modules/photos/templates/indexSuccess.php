<div class="photo-detail pb10">
  <p class="header"><span class="green">Photos</span></p>
  <p class="just-copy">The only thing that even comes close the pleasure of enjoying an amazing meal is seeing those succulent dishes shared in a photo. Post your own mouthwatering creations here or simply browse through food photos posted by others. You're sure to walk away hungry.</p>
</div><!-- /.photo-detail -->
<p class="tabbednav">
  <span class="active"><a href="#recent" id="open_recent">Most Recent</a></span> |
  <span><a href="#popular" id="open_popular">Most Popular</a></span>
</p>
<div id="recent" class="section-wrap">
	<? if (sizeof($recent)>0): ?>
  <ul class="img100left divider">
		<? include_partial('photos_recent', compact('recent', 'recent_pager')) ?>
  </ul>
  <? endif; ?>
</div><!-- /#recent -->

<div id="popular" class="section-wrap" style="display:none;">
	<? if (sizeof($liked)>0): ?>	
  <ul class="img100left divider">
		<? include_partial('photos_liked', compact('liked', 'liked_pager')) ?>  
  </ul>
  <? endif; ?>
</div><!-- /#popular -->