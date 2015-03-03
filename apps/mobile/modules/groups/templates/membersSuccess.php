<? include_partial('group_info', compact('my_group', 'group', 'blog_id', 'active', 'is_sponsor', 'sponsor')) ?>

<? //include_partial('jumpnav') ?>
<div id="members">
  <p class="header"><span class="green">PEOPLE</span></p>
  <? if (count($members) > 0): ?> 
  <ul class="hor-list">
    <? include_partial('group_members', compact('members', 'members_pager', 'group', 'blog_id', 'group_cat', 'groupRoles', 'my_group')) ?>
  </ul>
  <? else: ?>
  <p class="just-copy pt10 pb10">This group has no members</p>
	<? endif; ?>
</div><!-- /#members -->
<? include_partial('link_discussions'); ?>
<? include_partial('link_recipes'); ?>
<? include_partial('link_polls'); ?>
<? include_partial('link_photos'); ?>
<? include_partial('link_videos'); ?>