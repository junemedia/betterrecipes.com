<? //include_partial('cooks/detail', compact('user', 'my_profile', 'makeFriend', 'user_id', 'points')) ?>
<? include_partial('cooks/detail', compact('user', 'my_profile', 'makeFriend', 'user_id')) ?>
<? include_partial('link_recipes'); ?>
<? include_partial('link_discussions'); ?>
<? include_partial('link_photos'); ?>
<? include_partial('link_videos'); ?>
<? include_partial('link_journals'); ?>
<? include_partial('link_polls'); ?>
<? include_partial('link_groups'); ?>
<div class="friends" id="friends">
  <p class="header"><span class="green"><?= ($my_profile ? 'my' : $user->getDisplayName()) ?>'s FRIENDS</span></p>
	<? if (count($f) > 0): ?>
  <ul class="hor-list">
		<? include_partial('cooks/friendList', compact('userId', 'f', 'f_pager')) ?>
  </ul>
  <? else: ?>
  <p class="just-copy pt10 pb10"><?= ($my_profile ? 'my' : $user->getDisplayName()) ?> has not added any journals...</p>
  <? endif; ?>
</div><!-- /.recipebox -->
<? include_partial('link_raves'); ?>