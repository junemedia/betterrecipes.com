<? //include_partial('cooks/detail', compact('user', 'my_profile', 'makeFriend', 'user_id', 'points')) ?>
<? include_partial('cooks/detail', compact('user', 'my_profile', 'makeFriend', 'user_id')) ?>
<? include_partial('link_recipes'); ?>
<div class="discussions" id="discussions">
  <p class="header"><span class="green"><?= ($my_profile ? 'my' : $user->getDisplayName()) ?>'s DISCUSSIONS</span></p>
	<? if (count($discussions) > 0): ?>
  <ul class="divider">
  	<? include_partial('cooks/discussionList', compact('userId', 'discussions', 'discussions_pager')) ?>
  </ul>
  <? else: ?>
  	<p class="just-copy"><?= ($my_profile ? 'my' : $user->getDisplayName()) ?> has not added any discussions...</p>
  <? endif; ?>
</div><!-- /.discussions -->
<? include_partial('link_photos'); ?>
<? include_partial('link_videos'); ?>
<? include_partial('link_journals'); ?>
<? include_partial('link_polls'); ?>
<? include_partial('link_groups'); ?>
<? include_partial('link_friends'); ?>
<? include_partial('link_raves'); ?>