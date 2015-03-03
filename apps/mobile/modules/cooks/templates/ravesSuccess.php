<? //include_partial('cooks/detail', compact('user', 'my_profile', 'makeFriend', 'user_id', 'points')) ?>
<? include_partial('cooks/detail', compact('user', 'my_profile', 'makeFriend', 'user_id')) ?>
<? include_partial('link_recipes'); ?>
<? include_partial('link_discussions'); ?>
<? include_partial('link_photos'); ?>
<? include_partial('link_videos'); ?>
<? include_partial('link_journals'); ?>
<? include_partial('link_polls'); ?>
<? include_partial('link_groups'); ?>
<? include_partial('link_friends'); ?>
<div class="raves" id="raves">
	<p class="header"><span class="green"><?= ($my_profile ? 'my' : $user->getDisplayName()) ?>'s RAVES</span></p>
	<? if (count($comments) > 0): ?>
  <ul class="divider">
    <? include_partial('cooks/raveList', compact('content_id', 'comments', 'comments_pager')) ?>
  </ul>
  <? else: ?>
  <p class="just-copy pt10 pb10"><?= ($my_profile ? 'my' : $user->getDisplayName()) ?> has not added any raves...</p>
  <? endif; ?>
</div><!-- /.raves -->