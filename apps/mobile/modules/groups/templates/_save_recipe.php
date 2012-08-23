<? if (@$is_saved): ?>
	<a title="This recipe is already in your recipebox" class="gray-btn">SAVED</a>
<? else: ?>
	<a class="gray-btn" onclick="saveRecipe(this, '<?=url_for(@group_save_recipe)?>', <?=$id?>)">SAVE</a>
<? endif; ?>	