<? if (isset($user_id)): ?>
  <form id="addComment" name="add_comment">
    <input type="hidden" name="user_id" value="<?= $user_id ?>" />
    <input type="hidden" name="type" value="<?=$type?>" />
    <input type="hidden" name="content_id" value="<?= $contentId ?>" />
    <fieldset>
      <label>Your Comment</label>
      <textarea name="comment" id="userComment" class="wym-editor"></textarea>
    </fieldset>
    <input type="button" value="submit" class="btn-grey28 ajax-submit" style="margin-right:0;" onclick="addcomment('<?= url_for(@create_comment) ?>');" />
    <p id="message"></p>
  </form>
<? else: ?>
  <? // not logged in ?>
  <form name="comment_redirect" id="commentRedirect" class="standard-form" method="post" action="<?= url_for('@comment_auth') ?>">
    <input type="hidden" name="return_path" value="<?= getDomainUri() . url_for('@' . $return_path . '?slug=' . $sf_params->get('slug') . '&id=' . $sf_params->get('id')) ?>" />
    <fieldset>
      <label style="margin: 0; padding: 0; width: auto; float: none;"><a style="cursor:pointer;" onclick="$('#commentRedirect').submit(); return false;">Login To Comment</a></label>
    </fieldset>
  </form>
<? endif; ?>
