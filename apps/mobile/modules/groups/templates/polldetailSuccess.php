<? include_partial('group_info', compact('my_group', 'group', 'blog_id', 'active', 'is_sponsor', 'sponsor')) ?>

<? //include_partial('jumpnav') ?>
<div id="polls">  
	<? include_partial('group_poll_detail', compact('group', 'poll', 'comments', 'comments_pager', 'user_id', 'contentId', 'comments_total')) ?>
</div><!-- /#polls -->
<div id="comments">
  <p class="header"><span class="green">COMMENTS</span></p>
  <ul class="img50left">
		<? if (sizeof($comments) > 0): ?>
    <? include_partial('global/comments', compact('comments', 'comments_pager', 'contentId')) ?>
    <? endif; ?>
  </ul>
</div><!-- /#comments -->

