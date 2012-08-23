<div class="journal-detail pb10">
	<p class="header"><span class="green">Journals</span></p>
  <p class="just-copy">Get the latest scoop from other Mixers, and share your thoughts, too! Got something to say about dinner last night, food at a recent shindig, or simply want to share your thoughts about shopping, meal prep, or eating? This is the place. Start your own journal today and let the sharing begin!</p>
</div><!-- /.journal-detail -->
<p class="tabbednav">
  <span class="active"><a href="#recent" id="open_recent">Most Recent</a></span> |
  <span><a href="#popular" id="open_popular">Most Popular</a></span>
</p>
<div id="recent" class="section-wrap">
  <? if (sizeof($journal_recent)>0): ?>
  <ul class="divider">
    <? include_partial('journals_recent', compact('journal_recent', 'j_recent_pager')) ?>
  </ul>
  <? endif; ?>
</div><!-- /#recent -->
<div id="popular" class="section-wrap" style="display:none;">
  <? if (sizeof($journal_popular)>0): ?>	
  <ul class="divider">
    <? include_partial('journals_popular', compact('journal_popular', 'j_popular_pager')) ?>
  </ul>
  <? endif; ?>
</div><!-- /#popular -->