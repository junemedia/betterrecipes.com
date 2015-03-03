<? if (!$form->getObject()->isNew()): ?>
  <script type="text/javascript">
    window.parent.location.href = "<?= getDomainUri() . url_for('@myrecipebox?folder=' . $form->getObject()->getId()) ?>";
    window.parent.$("#modal_div").dialog("close");
  </script>
<? endif; ?>
<div class="popup">
  <div class="recipeboxpopup">
    <form method="post">
      <fieldset>
        <?= $form['name']->renderLabel() ?>
        <?= $form['name']->renderError() ?>
        <?= $form['name'] ?>
      </fieldset>      
      <fieldset>
        <?= $form['description']->renderLabel() ?>
        <?= $form['description']->renderError() ?>
        <?= $form['description'] ?>
      </fieldset>      
      <fieldset>
        <?= $form['tags']->renderLabel() ?>
        <?= $form['tags']->renderError() ?>
        <?= $form['tags'] ?>
      </fieldset>      
      <fieldset class="tar">
        <?= $form->renderHiddenFields(false) ?>
        <input type="button" value="Cancel" class="stripped" onclick="window.parent.$('#modal_div').dialog('close')" />
        <input type="submit" value="Create Folder" class="btn-grey28" />
      </fieldset>
    </form>
  </div>
</div>