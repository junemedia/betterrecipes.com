<? if (@$is_saved): ?>
	<a title="This recipe is already in your recipebox" class="gray-btn">SAVED</a>
<? else: ?>
	<a style="cursor:pointer" <? if($sf_user->isAuthenticated()): ?>onclick="addToSaved()"<? else: ?>href="<?= getSigninUri($sf_request->getUri()) ?>"<? endif; ?> title="Save this recipe" onclick="addToSaved()" class="gray-btn">SAVE</a>
<? endif; ?>	