<? //include_partial('cooks/detail', compact('user', 'my_profile', 'makeFriend', 'user_id', 'points')) ?>
<? include_partial('cooks/detail', compact('user', 'my_profile', 'makeFriend', 'user_id')) ?>
<? include_partial('link_recipes'); ?>
<? include_partial('link_discussions'); ?>
<? include_partial('link_photos'); ?>
<div class="videos" id="videos">
	<p class="header"><span class="green"><?= ($my_profile ? 'my' : $user->getDisplayName()) ?>'s VIDEOS</span></p>
 	<? if (count($videos) > 0): ?>
  <ul class="img100left">
    <? include_partial('cooks/videoList', compact('userId', 'videos', 'videos_pager')) ?>
  </ul>
  <? else:?>
  <p class="just-copy pt10 pb10"><?= ($my_profile ? 'my' : $user->getDisplayName()) ?> has not added any videos...</p>
  <? endif; ?>
</div><!-- /.videos -->
<? include_partial('link_journals'); ?>
<? include_partial('link_polls'); ?>
<? include_partial('link_groups'); ?>
<? include_partial('link_friends'); ?>
<? include_partial('link_raves'); ?>