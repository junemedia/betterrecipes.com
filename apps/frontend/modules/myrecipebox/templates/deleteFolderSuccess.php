<? if (isset($deleted)): ?>
  <script type="text/javascript">
    window.parent.location.href = "<?= getDomainUri() . url_for('@myrecipebox?folder=all') ?>";
    window.parent.$("#modal_div").dialog("close");
  </script>
<? endif; ?>
<div class="popup">
  <div class="recipeboxpopup">
    <form method="post">
      <fieldset>
        <label>Are you sure you want to delete this folder and the recipes within it?</label>
      </fieldset>      
      <fieldset class="tar">
        <input type="button" value="Cancel" class="stripped" onclick="window.parent.$('#modal_div').dialog('close')" />
        <input type="submit" value="Delete Folder" class="btn-grey28" />
      </fieldset>
    </form>
  </div>
</div>