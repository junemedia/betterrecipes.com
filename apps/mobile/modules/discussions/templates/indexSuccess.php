<div class="discussion-detail pb10">
  <p class="header"><span class="green">Discussions</span></p>
  <p class="just-copy">Share your thoughts on any topic or ask fellow Mixers for their advice. Mixing Bowl is home to thousands of cooks, bakers, grillers, and eaters who are more than willing to voice an opinion or offer some advice. Join in the discussion today!</p>
</div>
<p class="tabbednav">
<span class="active"><a href="#recent" id="open_recent">Most Recent</a></span> |
<span><a href="#popular" id="open_popular">Most Popular</a></span>
</p>
<div id="recent" class="section-wrap">
	<? if (sizeof($recent)>0): ?>
  <ul class="img75left divider">
  <? include_partial('discussions_recent', compact('recent', 'recent_pager', 'user_id')) ?>
  </ul>
  <? endif; ?>
</div><!-- /#recent -->
<div id="popular" class="section-wrap" style="display:none;">
	<? if (sizeof($popular)>0): ?>	
  <ul class="img75left divider">
  <? include_partial('discussions_popular', compact('popular', 'popular_pager', 'user_id')) ?>  
  </ul>
  <? endif; ?>
</div><!-- /#popular -->