<? //include_partial('cooks/detail', compact('user', 'my_profile', 'makeFriend', 'user_id', 'points')) ?>
<? include_partial('cooks/detail', compact('user', 'my_profile', 'makeFriend', 'user_id')) ?>
<div class="recipe" id="recipes">
	<p class="header"><span class="green"><?= ($my_profile ? 'MY' : ($user->getDisplayName() . '\'s')) ?> RECIPES</span></p>
	<? // if (count($recipes) > 0): ?>
  <ul class="divider">
    <? include_partial('cooks/recipeList', compact('userId', 'recipes')) ?>
  </ul>
  <? /* else: ?>
  <p class="just-copy pt10 pb10"><?= ($my_profile ? 'my' : $user->getDisplayName()) ?> has not added any recipes...</p>
  <? endif; */ ?>
</div><!-- /.recipe -->
<? include_partial('link_discussions'); ?>
<? include_partial('link_photos'); ?>
<? include_partial('link_videos'); ?>
<? include_partial('link_journals'); ?>
<? include_partial('link_polls'); ?>
<? include_partial('link_groups'); ?>
<? include_partial('link_friends'); ?>
<? include_partial('link_raves'); ?>

