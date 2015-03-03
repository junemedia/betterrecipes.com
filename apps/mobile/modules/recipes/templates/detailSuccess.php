<div class="detail">
  <? include_partial('recipe_detail', compact('recipe', 'is_saved', 'user_rating', 'currentContest', 'recipeNext', 'recipePrev', 'showVoteButton', 'showPopup', 'msg')) ?>
  <div id="comments" class="reviews">
    <div class="header">
      <p class="green">REVIEWS (<?= count($comments) ?>)</p>
    </div>
    <? if (sizeof($comments) > 0): ?>
      <ul class="img50left divider">
        <? include_partial('global/comments', array('comments' => $comments, 'comments_pager' => $comments_pager, 'contentId' => $content_id)) ?>
      </ul>
    <? endif; ?>
    <? include_partial('global/add_comments', array('user_id' => $user_id, 'content_id' => $content_id, 'obj' => $recipe, 'obj_type' => 'recipe')) ?>
  </div><!-- /.reviews -->

