<? //include_partial('cooks/detail', compact('user', 'my_profile', 'makeFriend', 'user_id', 'points')) ?>
<? include_partial('cooks/detail', compact('user', 'my_profile', 'makeFriend', 'user_id')) ?>
<? include_partial('link_recipes'); ?>
<? include_partial('link_discussions'); ?>
<? include_partial('link_photos'); ?>
<? include_partial('link_videos'); ?>
<? include_partial('link_journals'); ?>
<? include_partial('link_polls'); ?>
<div class="groups" id="groups">
  <p class="header"><span class="green"><?= ($my_profile ? 'my' : $user->getDisplayName()) ?>'s GROUPS</span></p>
	<? if (count($groups) > 0): ?>
  <ul class="hor-list">
  	<? include_partial('cooks/groupList', compact('userId', 'groups', 'groups_pager')) ?>
  </ul>
	<? else: ?>
  <p class="just-copy pt10 pb10"><?= ($my_profile ? 'my' : $user->getDisplayName()) ?> has not joined any groups...</p>
  <? endif; ?>
</div><!-- /.groups -->
<? include_partial('link_friends'); ?>
<? include_partial('link_raves'); ?>