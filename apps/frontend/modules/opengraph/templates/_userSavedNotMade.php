<? if (@$saved && sizeof($saved) == 4 && $sf_user->getAttribute('totalRecipeViews') > 4): ?>
  <div id="savedModal" style="display:none;">
    <p>Hey! Have you made any of your recently saved recipes?</p>
    <div id="closeSavedModal"><a href="javascript:;" title="Close" onclick="$('#savedModal').hide();"><img src="/img/closeModal.png" /></a></div>
    <ul>
      <? foreach ($saved as $s): $recipe = $s->getRecipe() ?>
        <li>
          <a class="img" href="<?= getUrl($recipe) ?>"><img src="<?= $recipe->getMainImageSrc() ?>" /></a>
          <div class="info">
            <p class="big">Viewed <a href="<?= getUrl($recipe) ?>"><?= $recipe->getName() ?></a></p>
            <p class="small">Saved on <?= date('m/d/y @ h:i a', strtotime($s->getCreatedAt())) ?></p>
          </div> 
          <div class="action"><a class="graphic-button" href="javascript:;" onclick="savedRecipeMade(this, <?= $recipe->getId() ?>, '<?= urlencode($recipe->getName()) ?>', '<?= getUrl($recipe) ?>')">MADE THIS!</a></div>
        </li>
      <? endforeach; ?>
    </ul>
  </div>
<? endif; ?>
