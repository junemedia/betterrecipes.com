<!-- FROM WHAT I CAN TELL, THIS ISN"T USED -->
<? if (isset($poll) && sizeof($poll) > 0): ?>
<div class="poll-detail">
	<p class="header">
  	<span class="green"><?= $poll['title'] ?></span>
    <span class="all"><?
      if ($poll['num_votes'] != '') {
        echo $poll['num_votes'];
      } else {
        echo '0';
      }
      ?> votes</span>
  </p>
  <div id="vote-bar">
  <? include_partial('vote', compact('poll')) ?>
  </div>
</div><!-- /.poll-detail -->
<? endif; ?>
		
<div id="comments">
  <p class="header"><span class="green">COMMENTS</span></p>
  <ul class="img50left">
		<? if (sizeof($comments) > 0): ?>
    <? include_partial('global/comments', compact('comments', 'comments_pager', 'contentId')) ?>
    <? endif; ?>
  </ul>
</div><!-- /#comments -->

            
      