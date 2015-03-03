<a name="write_review">&nbsp;</a>
<? if (isset($user_id)): ?>
  <form id="addComment" name="add_comment" class="standard-form">
    <p class="title padding-left">ADD YOUR REVIEW</p>
    <input type="hidden" name="user_id" value="<?= $user_id ?>" />
    <input type="hidden" name="type" value="<?= $obj_type ?>" />
    <input type="hidden" name="content_id" value="<?= $content_id ?>" />
    <fieldset>
      <label>Your Comment</label>
      <textarea name="comment" id="userComment" class="wym-editor" rows="8"></textarea>
    </fieldset>
    <fieldset>
      <a class="gray-btn ajax-submit" style="margin-left:3.1%" onclick="addcomment('<?= getUrl('@create_comment') ?>');">submit</a>
    </fieldset>
    <p id="message" class="padding-left"></p>
  </form>
<? else: ?>
  <? // not logged in ?>
  <form name="comment_redirect" id="commentRedirect" class="standard-form" method="post" action="<?= getUrl('@comment_auth') ?>">
    <? if ($obj_type == 'recipe'): ?>
      <input type="hidden" name="return_path" value="<?= getUrl($obj) ?>" />
    <? elseif ($obj_type == 'journal'): ?>
      <input type="hidden" name="return_path" value="<?= getDomainUri() . url_for('@journal_detail?slug=' . $sf_params->get('slug') . '&id=' . $content_id) ?>" />
    <? endif; ?>
    <fieldset>
      <label><a class="gray-btn" onclick="$('#commentRedirect').submit();">Login To Comment</a></label>
    </fieldset>
  </form>
<? endif; ?>