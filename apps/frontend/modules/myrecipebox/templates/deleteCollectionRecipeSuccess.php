<? if (isset($deleted)): ?>
  <script type="text/javascript">
    window.parent.location.href = window.parent.location.href;
    window.parent.$("#modal_div").dialog("close");
  </script>
<? endif; ?>
<div class="popup">
  <div class="recipeboxpopup">
    <form method="post">
      <fieldset>
        <label>Are you sure you want to remove this recipe from this folder?</label>
      </fieldset>      
      <fieldset class="tar">
        <input type="button" value="Cancel" class="stripped" onclick="window.parent.$('#modal_div').dialog('close')" />
        <input type="submit" value="Remove Recipe" class="btn-grey28" />
      </fieldset>
    </form>
  </div>
</div>