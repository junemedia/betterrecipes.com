<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<script>
  $(document).ready(function(){
    $("#is_active_chkbox").change(function(){
      if($(this).attr("checked")){
        $("#sponsor_is_active").val(1);
      } else {
        $("#sponsor_is_active").val(0);
      }
    });
  });
</script>
<form action="<?php echo url_for('sponsors/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php if (!$form->getObject()->isNew()): ?>
    <input type="hidden" name="sf_method" value="put" />
  <?php endif; ?>
  <?php echo $form->renderHiddenFields(false) ?>
  <?php echo $form->renderGlobalErrors() ?>
  <? if (!$form->getObject()->isNew()): ?>
    <?= link_to('Delete', 'sponsors/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?', 'id' => 'deleteSponsor')) ?>
  <? endif; ?>
  <div id="sponsors" class="fields">
    <div class="field">
      <?= $form['name']->renderError() ?>
      <?= $form['name']->renderLabel() ?>      
      <?= $form['name'] ?>
    </div>
    <div class="field" id="descript">
      <?= $form['description']->renderError() ?>
      <?= $form['description']->renderLabel(null, array('class' => "descript")) ?>      
      <?= $form['description'] ?>
    </div>
    <div class="field">
      <?= $form['url']->renderError() ?>
      <?= $form['url']->renderLabel() ?>      
      <?= $form['url'] ?>
    </div>
    <div class="field">
      <?= $form['adtag']->renderError() ?>
      <?= $form['adtag']->renderLabel() ?>      
      <?= $form['adtag'] ?>
    </div>
    <div class="field">
      <?= $form['is_active']->renderError() ?>
      <?= $form['is_active']->renderLabel() ?>      
      <?= $form['is_active'] ?>
      <input type="checkbox" id="is_active_chkbox" name="is_active_chkbox"<? if($form['is_active']->getValue()==1): ?> checked<? endif ;?> >
    </div>
    <div class="field">
      <div class="action">
        <a href="<?php echo url_for('sponsors/index') ?>">Cancel</a>
        &nbsp;&nbsp;or&nbsp;&nbsp;
        <input type="submit" class="submit" value="Save" />
      </div>
    </div>
  </div>
</form>
