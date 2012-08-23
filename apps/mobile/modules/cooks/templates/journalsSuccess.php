<? //include_partial('cooks/detail', compact('user', 'my_profile', 'makeFriend', 'user_id', 'points')) ?>
<? include_partial('cooks/detail', compact('user', 'my_profile', 'makeFriend', 'user_id')) ?>
<? include_partial('link_recipes'); ?>
<? include_partial('link_discussions'); ?>
<? include_partial('link_photos'); ?>
<? include_partial('link_videos'); ?>
<div class="journals" id="journals">
  <p class="header"><span class="green"><?= ($my_profile ? 'my' : $user->getDisplayName()) ?>'s JOURNALS</span></p>
	<? if (count($journals) > 0): ?>
  <ul class="divider">
		<? include_partial('cooks/journalList', compact('userId', 'journals', 'journals_pager')) ?>
  </ul>
  <? else: ?>
  <p class="just-copy pt10 pb10"><?= ($my_profile ? 'my' : $user->getDisplayName()) ?> has not added any journals...</p>
  <? endif; ?>
</div><!-- /.journals -->
<? include_partial('link_polls'); ?>
<? include_partial('link_groups'); ?>
<? include_partial('link_friends'); ?>
<? include_partial('link_raves'); ?>