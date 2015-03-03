<? include_partial('group_info', compact('my_group', 'group', 'blog_id', 'active', 'is_sponsor', 'sponsor')) ?>

<? //include_partial('jumpnav') ?>

<? include_partial('link_people'); ?>        	
<div id="discussions">
  <p class="header"><span class="green">DISCUSSIONS</span></p>
  <? if (count($discussions) > 0): ?> 
  <ul class="divider">
  <? include_partial('group_discussions', compact('blog_id', 'forum_id', 'discussions', 'discussions_pager', 'group', 'user_id', 'category')) ?>
  </ul>
  <? else: ?>
  <p class="just-copy pt10 pb10">This group has not created any discussions</p>
	<? endif; ?>
</div><!-- /#discussions -->
<? include_partial('link_recipes'); ?>
<? include_partial('link_polls'); ?>
<? include_partial('link_photos'); ?>
<? include_partial('link_videos'); ?>