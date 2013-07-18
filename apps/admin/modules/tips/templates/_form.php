<? $tip = $form->getObject() ?>
<script>
  $(document).ready(function(){
    $("#is_active_chkbox").change(function(){
      if($(this).attr("checked")){
        $("#tip_is_active").val(1);
      } else {
        $("#tip_is_active").val(0);
      }
    });    
  });
</script>
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
      <? /*<div class="field small">
        <?= $form['contest_id']->renderError() ?>
        <?= $form['contest_id']->renderLabel() ?>      
        <?= $form['contest_id'] ?>
      </div>*/ ?>
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