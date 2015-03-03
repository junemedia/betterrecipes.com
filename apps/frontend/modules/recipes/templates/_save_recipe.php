<? if (@$is_saved): ?>
  <a title="This recipe is already in your recipebox" class="no-link grey">Saved</a>
<? else: ?>
  <a class="grey" <? if($sf_user->isAuthenticated()): ?>onclick="addToSaved()"<? else: ?>href="<?= getSigninUri($sf_request->getUri()) ?>"<? endif; ?> title="Add recipe to my recipebox" onclick="addToSaved()">Save</a>
<? endif; ?>
