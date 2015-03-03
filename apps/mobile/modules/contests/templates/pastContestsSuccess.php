<div class="past-contests">
  <p class="header"><p class="green">PAST CONTESTS</p></p>
  <? if (count($past_contests) > 0): ?>
  <ul class="img75left divider">
		<? include_partial('pastContests', compact('past_contests')) ?>
  </ul>
  <? endif; ?>
</div><!-- /.past-contests -->

