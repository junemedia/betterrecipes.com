<div class="polls-detail">
	<p class="header"><span class="green">Polls</span></p>
  <p class="just-copy">Wonder what type of cooking oil other Mixers prefer, how many hours a day they spend cooking, or simply want to hear their opinions about some popular cookbooks before you buy? Create your own poll! It's easy to start a poll on any subject. Or test your cooking know-how by taking one of our existing polls.</p>
</div>
<div id="poll-list" class="pt10">
  <ul class="divider">
  <? include_partial('poll_list', compact('polls', 'polls_pager')) ?>
  </ul>
</div><!-- /#poll-list -->