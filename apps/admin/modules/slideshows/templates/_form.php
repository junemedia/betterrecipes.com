<script>
  $(document).ready(function(){
    $("#is_active_chkbox").change(function(){
      if($(this).attr("checked")){
        $("#slideshow_is_active").val(1);
      } else {
        $("#slideshow_is_active").val(0);
      }
    });
  });
  $(function() {
    $( "#datepicker" ).datepicker({
      showOn: "button",
      buttonImage: "/admin/images/calendar.png",
      buttonImageOnly: true
    });
  });
</script>
<form action="<?php echo url_for('slideshows/' . ($form->getObject()->isNew() ? 'create' : 'update') . (!$form->getObject()->isNew() ? '?id=' . $form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php if (!$form->getObject()->isNew()): ?>
    <input type="hidden" name="sf_method" value="put" />
  <?php endif; ?>
  <?php echo $form->renderHiddenFields(false) ?>
  <?php echo $form->renderGlobalErrors() ?>
  <? if (!$form->getObject()->isNew()): ?>
    <?= link_to('Delete', 'slideshows/delete?id=' . $form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?', 'id' => 'deleteSlideshow')) ?>
  <? endif; ?>
  <div id="slideshows" class="fields small">
    <div class="field small">
      <?= $form['category_id']->renderError() ?>
      <?= $form['category_id']->renderLabel() ?>      
      <?= $form['category_id'] ?>
    </div>
    <div class="field small">
      <?= $form['name']->renderError() ?>
      <?= $form['name']->renderLabel() ?>      
      <?= $form['name'] ?>
    </div>
    <? if (!$form->getObject()->isNew()): ?>
      <div class="field small">
        <?= $form['slug']->renderError() ?>
        <?= $form['slug']->renderLabel() ?>      
        <?= $form['slug'] ?>
      </div>
    <? endif; ?>
    <div class="field small">
      <?= $form['description']->renderError() ?>
      <?= $form['description']->renderLabel(null, array('class' => "descript")) ?>      
      <?= $form['description'] ?>
    </div>
    <div class="field small" style="position:relative;">
      <?= $form['start_date']->renderError() ?>
      <?= $form['start_date']->renderLabel() ?> 
      <?= $form['start_date'] ?>
    </div>
    <div class="field small" style="position:relative;">
      <?= $form['end_date']->renderError() ?>
      <?= $form['end_date']->renderLabel() ?>      
      <?= $form['end_date'] ?>
    </div>
    <div class="field small">
      <?= $form['title_tag']->renderError() ?>
      <?= $form['title_tag']->renderLabel() ?>      
      <?= $form['title_tag'] ?>
    </div>
    <div class="field small">
      <?= $form['summary']->renderError() ?>
      <?= $form['summary']->renderLabel() ?>      
      <?= $form['summary'] ?>
    </div>
    <div class="field small">
      <?= $form['keywords']->renderError() ?>
      <?= $form['keywords']->renderLabel() ?>      
      <?= $form['keywords'] ?>
    </div>
    <div class="field small">
      <?= $form['is_active']->renderError() ?>
      <?= $form['is_active']->renderLabel() ?>      
      <?= $form['is_active'] ?>
      <input type="checkbox" id="is_active_chkbox" name="is_active_chkbox"<? if ($form['is_active']->getValue() == 1): ?> checked<? endif; ?> >
    </div>
    <div class="field small">
      <div class="action small">
        <a href="<?php echo url_for('slideshows/index') ?>">Cancel</a>
        &nbsp;&nbsp;or&nbsp;&nbsp;
        <input type="submit" class="submit" value="Save" />
      </div>
    </div>
  </div>
</form>