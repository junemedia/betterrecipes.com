<? if (isset($deleted)): ?>
  <script type="text/javascript">
    window.parent.location.href = "<?= getDomainUri() . url_for('@myrecipebox?folder=all') ?>";
    window.parent.$("#modal_div").dialog("close");
  </script>
<? endif; ?>
<form method="post">
  <table>
    <tfoot>
      <tr>
        <td>
          <input type="button" value="Cancel" class="stripped" onclick="window.parent.$('#modal_div').dialog('close')" />
        </td>
        <td>
          <input type="submit" value="Delete Recipe" class="btn-grey28" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <tr>
        <th colspan="2"><label>Are you sure you want to delete this recipe from your recipe box?</label></th>
      </tr>
    </tbody>
  </table>
</form>