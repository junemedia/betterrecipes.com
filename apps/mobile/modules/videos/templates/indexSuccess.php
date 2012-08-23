<div class="video-detail pb10">
  <p class="header"><span class="green">Videos</span></p>
  <p class="just-copy pb10">If a picture's worth a thousand words, how many does your average video go for? If you've always dreamed of seeing yourself on the small screen, now's your chance. Post your own video cooking tips, kitchen advice, or full tutorial and show off your stuff to other Mixers. Feeling camera shy? That's OK. Enjoy one of the videos that's already been shared and pick up a few new tricks.</p>
</div><!-- /.video-detail -->
<p class="tabbednav">
  <span class="active"><a href="#recent" id="open_recent">Most Recent</a></span> |
  <span><a href="#popular" id="open_popular">Most Popular</a></span>
</p>
<div id="recent" class="section-wrap">
	<? if (sizeof($recent)>0): ?>
  <ul class="img100left divider">
    <? include_partial('videos_recent', compact('recent', 'recent_pager')) ?>
  </ul>
  <? endif; ?>
</div><!-- /#recent -->

<div id="popular" class="section-wrap" style="display:none;">
	<? if (sizeof($liked)>0): ?>	
  <ul class="img100left divider">
    <? include_partial('videos_liked', compact('liked', 'liked_pager')) ?>  
  </ul>
  <? endif; ?>
</div><!-- /#popular -->