<script>
$( function()
{
  $('#save_contests').click(function(e)
  {
    e.preventDefault();
    if( $('#contests').val() != -1 )
    {
      $('#contest_ids').val($('#contest_ids').val() + $('#contests').val() + ',' );
      $('#contest_list').append('<li>' + $('#contests :selected').text() + '<a href="#" class="remove_contest" onclick="remove_contest(this, ' + $('#contests').val() + '); return false;">Remove</a></li>' );
      $("#contests").val('-1');
    }
  });

});
function remove_contest(a_object, id)
{
    $(a_object).parent().remove();
    $('#contest_ids').val( $('#contest_ids').val().replace(id + ',', '') );
}
</script>
<? $tip = $form->getObject() ?>

<? // var_dump($form->getErrorSchema()->getErrors()); ?>
<form action="<?= url_for('tips/' . ($tip->isNew() ? 'create' : 'update') . (!$tip->isNew() ? '?id=' . $tip->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <? if (!$tip->isNew()): ?>
    <input type="hidden" name="sf_method" value="put" />
  <? endif; ?>
  <div id="tipContainer" class="container small edit">
    <h2>General Details<? if (!$tip->isNew()): ?> <a href="<?= UrlToolkit::getUrl($tip, array('mode' => 'preview')) ?>" title="Preview '<?= $tip->getTitle() ?>'" target="_blank" class="lp150">Preview "<?= $tip->getTitle() ?>"</a><? endif; ?></h2>
    <? if (!$tip->isNew()): ?>
      <?= link_to('Delete', 'tips/delete?id=' . $tip->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?', 'id' => 'deletetip')) ?>
    <? endif; ?>
    <?php echo $form->renderHiddenFields(false) ?>
    <?php echo $form->renderGlobalErrors() ?>
    <div id="tips" class="fields small">
      <div class="field small">
        <label for="contests">Add Contest</label>
        <select name="contests" id="contests" class="contests">
          <option value="-1">-- Select a contest --</option>
          <? foreach ($contests as $contest): ?>
            <option value="<?= $contest->getId() ?>"><?= $contest->getName() ?></option>
          <? endforeach; ?>
        </select>
        <a href="#" id="save_contests">Save</a> 
      </div>
      <div class="field small">
        <ul id="contest_list">
          <? if(isset($selected_contests)): ?>
            <? foreach( $selected_contests as $selected_contest ): ?>
              <li><?= $selected_contest->getName() ?><a href="#" class="remove_contest" onclick="remove_contest(this, '<?= $selected_contest->getId() ?>'); return false;">Remove</a></li>
            <? endforeach ?>
          <? endif ?>
        </ul>
      </div>
      <? if( isset($selected_contests)): ?>
        <? $values = ''; ?>
        <? foreach( $selected_contests as $selected_contest ): ?>
          <? $values .= $selected_contest->getId() . ','; ?>
        <? endforeach ?>
        <input type="hidden" id="contest_ids" name="contest_ids" value="<?= $values ?>"/>
      <? else: ?>
        <input type="hidden" id="contest_ids" name="contest_ids" value=""/>
      <? endif ?>
      
      <div class="field small">
        <?= $form['title']->renderError() ?>
        <?= $form['title']->renderLabel() ?>      
        <?= $form['title'] ?>
      </div>  
      <div class="field small">
        <?= $form['url']->renderError() ?>
        <?= $form['url']->renderLabel() ?>      
        <?= $form['url'] ?>
      </div>
      <div class="field small">
        <div class="action small flri">
          <a href="<?php echo url_for('tips/index') ?>">Cancel</a>
          &nbsp;&nbsp;or&nbsp;&nbsp;
          <input type="submit" class="submit btn-grey28" value="Save" />
        </div>
      </div>
    </div>
  </div>
</form>