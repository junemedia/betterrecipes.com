<? //include_partial('cooks/detail', compact('user', 'my_profile', 'makeFriend', 'user_id', 'points')) ?>
<? include_partial('cooks/detail', compact('user', 'my_profile', 'makeFriend', 'user_id')) ?>
<? include_partial('link_recipes'); ?>
<? include_partial('link_discussions'); ?>
<div class="photos" id="photos">
  <p class="header"><span class="green"><?= ($my_profile ? 'my' : $user->getDisplayName()) ?>'s PHOTOS</span></p>
	<? if (count($photos) > 0): ?>
  <ul class="img100left">
		<? include_partial('cooks/photoList', compact('userId', 'photos', 'photos_pager')) ?>
  </ul>
  <? else: ?>
  <p class="just-copy pt10 pb10"><?= ($my_profile ? 'my' : $user->getDisplayName()) ?> has not added any photos...</p>
  <? endif; ?>
</div><!-- /.photos -->
<? include_partial('link_videos'); ?>
<? include_partial('link_journals'); ?>
<? include_partial('link_polls'); ?>
<? include_partial('link_groups'); ?>
<? include_partial('link_friends'); ?>
<? include_partial('link_raves'); ?>