<? if (isset($recipe_moved)): ?>
  <script type="text/javascript">
    window.parent.location.href = window.parent.location.href;
    window.parent.$("#modal_div").dialog("close");
  </script>
<? endif; ?>
<div class="popup">
  <div class="recipeboxpopup">
    <form method="post">
      <fieldset>
        <input type="hidden" name="recipe" value="<?= $sf_request->getParameter('recipe') ?>" />
        <input type="hidden" name="from_folder" value="<?= $sf_request->getParameter('from') ?>" />
        <select name="to_folder">       
          <? foreach ($folders as $folder): ?>
            <option value="<?= $folder->getId() ?>"><?= $folder->getName() ?></option>
          <? endforeach; ?>
        </select>
      </fieldset>      
      <fieldset class="tar">
        <input type="button" value="Cancel" class="stripped" onclick="window.parent.$('#modal_div').dialog('close')" />
        <? if ($sf_request->getParameter('from') == 'saved'): ?>
          <input type="submit" value="Copy Recipe" class="btn-grey28" />
        <? else: ?> 
          <input type="submit" value="Move Recipe" class="btn-grey28" />
        <? endif; ?>
      </fieldset>
    </form>
  </div>
</div>