<form name="cast-vote" id="castVote" class="just-copy">
  <ul>
    <? for ($i = 0; $i < count($poll['items']); $i++): ?>
    <li><input type="radio" name="vote-option" value="<?= $poll['items'][$i]['option_id'] ?>" /><?= $poll['items'][$i]['name'] ?></li>
    <? endfor; ?>
  </ul>
  <input type="button" value="VOTE" class="gray-btn flri mb10 mr10" onclick="erinVote('<?= url_for(@polls_vote) ?>', '#castVote', '<?= $poll['poll_id'] ?>');"  />
</form>