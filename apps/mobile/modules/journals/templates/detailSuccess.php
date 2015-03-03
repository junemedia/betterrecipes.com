<? $slug = '&slug=' . $sf_params->get('slug'); ?>
<? $id = '&id=' . $sf_params->get('id'); ?>
<? if ($journal): ?>
  <div class="grp-detail">
    <p class="fs15 green"><?= $journal['title'] ?></p>
    <?= $journal['body'] ?>
    <p class="fs11">
      by: <a href="<?= getRoute('User', array('subdir' => $journal['username'])) ?>"><?= $journal['display_name'] ?></a> @ <?= $journal['date_created'] ?>
    </p>
  </div>
<? endif; ?>
<div class="results">
  <div class="header">
    <p class="green">COMMENTS</p>
  </div>
  <div id="comments">
    <ul>
      <? if (sizeof($comments) > 0): ?>
        <? include_partial('global/comments', compact('comments', 'comments_pager', 'contentId')) ?>
      <? endif; ?>
    </ul>
    <? include_partial('global/add_comments', array('user_id' => $user_id, 'content_id' => $sf_params->get('id'), 'obj' => $journal, 'obj_type' => 'recipe')) ?>
  </div><!-- /#comments -->
</div><!-- /.results -->


