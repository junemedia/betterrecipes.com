<div class="past-winners">
	<p class="header"><span class="green">PAST WINNERS</span></p>
	<? if (count($pastWinners) > 0): ?>
  <ul class="img75left divider">
		<? include_partial('pastWinners', compact('pastWinners')) ?>
  </ul>
  <? endif; ?>
</div><!-- /.past-winners -->

