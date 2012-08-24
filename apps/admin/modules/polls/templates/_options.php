<script>reloadJsVars();</script>
<? if (sizeof($pollOptions) > 0): ?>
  <input type="hidden" id="poll_id" value="<?= $poll->getId() ?>" />
  <table id="poll_options">
    <tr>
      <th>Option Title</th>
      <th>Selected Recipe</th>
      <th>Selected Image</th>
      <th/>
    </tr>
    <? foreach ($pollOptions as $key => $p): ?>
      <tr>
        <td>
        	<?= $key + 1 ?> - <?= $p->getOptionTitle() ?>
        	<a onclick="editTitle(this);">Edit Title</a>	
        	<div style="float:left; display:none;"><input type="text" name="optionTitle" class="option_title" value="<?= $p->getOptionTitle() ?>" /> <a onclick="updateTitle(this, <?= $p->getId() ?>, <?= $poll->getId() ?>);">Update</a></div>
        </td>
        <td class="selected-recipe">
          <? if ($option_recipe = $p->getRecipe()): ?>
            <?= $option_recipe->getName() ?>
          <? else: ?>
            No recipe selected
          <? endif; ?>
        </td>
        <td class="selected-image">
          <? if ($option_image = $p->getPhoto()): ?>
            <img src="<?= $option_image->getImgSrc('400x300') ?>" height="100" alt="<?= $option_image->getName() ?>"/>
            <input type="hidden" class="has-image" value="1" />
          <? else: ?>
            No image selected
          <? endif; ?>
        </td>
        <td class="edit button">
          <a class="edit-btn">Select Recipe</a>
          <a class="cancel-btn">Cancel</a>
        </td>
      </tr>
      <tr class="edit">
        <td colspan="4">
          <div class="ui-widget">
            <input type="text" class="recipe-selector" value="Start typing recipe title" />
            <input type="hidden" class="option-id" value="<?= $p->getId() ?>" />
          </div>
          <div class="recipe-data"></div>
        </td>
      </tr>
    <? endforeach; ?>
  </table>
<? endif; ?>