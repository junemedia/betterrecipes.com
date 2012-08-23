<? include_partial('group_info', compact('my_group', 'group', 'blog_id', 'active', 'is_sponsor', 'sponsor')) ?>

<? //include_partial('jumpnav') ?>
<? include_partial('link_people'); ?>
<? include_partial('link_discussions'); ?>
<? include_partial('link_recipes'); ?>
<div id="polls">
  <p class="header"><span class="green">POLLS</p></p> 
  <? if (count($polls) > 0): ?> 
  <ul class="divider">
		<? include_partial('group_polls', compact('poll_blog', 'polls', 'polls_pager')) ?>
  </ul>
  <? else: ?>
  <p class="just-copy pt10 pb10">This group has not created any polls</p>
	<? endif; ?>
</div><!-- /#polls -->
<? include_partial('link_photos'); ?>
<? include_partial('link_videos'); ?>