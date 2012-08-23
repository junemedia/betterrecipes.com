<? if (isset($saved)): ?>
  <script type="text/javascript">
  	//alert('test');
    //window.parent.location.href = window.parent.location.href;
    //window.parent.$("#modal_div").dialog("close");
    //parent.$("#modal_div").dialog("close");
    parent.closeMe();

  </script>
<? endif; ?>
<form method="post" <? $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?= $form->renderHiddenFields(false) ?>
           <input type="submit" value="Save" /> 
           <a style="cursor:pointer;float:left;display:inline;margin:25px 0 0 400px" onclick="parent.cancelModal()">Cancel</a>
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?= $form->renderGlobalErrors() ?>
      <tr>
        <th/>
        <td>
          <?= $form['recipe_id']->renderError() ?>
          <?= $form['recipe_id'] ?>
        </td>
      </tr>      
      <tr>
        <th><?= $form['name']->renderLabel() ?></th>
        <td>
          <?= $form['name']->renderError() ?>
          <?= $form['name'] ?>
        </td>
      </tr>
      <tr>
        <th><?= $form['description']->renderLabel() ?></th>
        <td>
          <?= $form['description']->renderError() ?>
          <?= $form['description'] ?>
        </td>
      </tr>
      <tr>
        <th><?= $form['image']->renderLabel() ?></th>
        <td>
          <?= $form['image']->renderError() ?>
          <?= $form['image'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>