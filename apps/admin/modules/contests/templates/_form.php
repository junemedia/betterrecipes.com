<? use_stylesheets_for_form($form) ?>
<? use_javascripts_for_form($form) ?>
<script>
  $(document).ready(function(){
    
    //Datepicker Calendar
    $(".datepicker").datepicker({
      showOn: "button",
      buttonImage: "/img/calendar.png",
      buttonImageOnly: true
    });
    
    //Initalize hidden fields to datapicker field values
    $("#contest_start_date").val($("#startDate").val());
    $("#contest_end_date").val($("#endDate").val());
    
    //Change hidden date fields when new date is chosen
    $("#startDate.datepicker").change(function(){
      $("#contest_start_date").val($("#startDate").val());
    });
    
    $("#endDate.datepicker").change(function(){
      $("#contest_end_date").val($("#endDate").val());
    });

  });
</script>
<form action="<?= url_for('contests/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <? $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <? if (!$form->getObject()->isNew()): ?>
    <input type="hidden" name="sf_method" value="put" />
  <? endif; ?>
  <? if (!$form->getObject()->isNew()): ?>
    <? //= link_to('Delete', 'contests/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?', 'id' => 'deleteContest')) ?>
  <? endif; ?>
  <?php echo $form->renderHiddenFields(false) ?>
  <?php echo $form->renderGlobalErrors() ?>
  <div id="contests" class="fields small">
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
    <div class="field small">
      <?= $form['image']->renderError() ?>
      <?= $form['image']->renderLabel() ?>        
      <? if (!$form->getObject()->isNew()) { ?>
        <div class="curImg" >
          <img src="<?= $form->getObject()->getImgSrc() ?>" alt="<?= $form->getObject()->getName() ?>" class="contestImage"/>
          <?= $form['image'] ?>
        </div>
      <? } else { ?>
        <?= $form['image'] ?>
      <? } ?>
    </div>
    <div id="date" class="field small">
      <label for="startDate" class="startDate">Start Date</label>
      <input type="text" id="startDate" class="<? if ($form->getObject()->isNew())
        echo 'datepicker' ?>" name="startDate" readonly="readonly" value="<?= ($form->getObject()->getStartDate()) ? date('m/d/Y', strtotime($form->getObject()->getStartDate())) : date('m/d/y') ?>" /><br />
      <label for="endDate" class="endDate">End Date</label>
      <input type="text" id="endDate" class="<? if ($form->getObject()->isNew())
               echo 'datepicker' ?>" name="endDate" readonly="readonly"value="<?= ($form->getObject()->getEndDate()) ? date('m/d/Y', strtotime($form->getObject()->getEndDate())) : date('m/d/y', strtotime(date('m/d/y')." +6 day ")) ?>" />
    </div>
    <div id="rulesField" class="field small">
      <?= $form['rules']->renderError() ?>
      <?= $form['rules']->renderLabel() ?>      
      <?= $form['rules'] ?>
    </div>
    <div class="field small">
      <?= $form['prize']->renderError() ?>
      <?= $form['prize']->renderLabel() ?>      
      <?= $form['prize'] ?>
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
      <?= $form['is_open_to_public']->renderError() ?>
      <?= $form['is_open_to_public']->renderLabel() ?>      
      <?= $form['is_open_to_public'] ?>
    </div>
    <div class="field small">
      <div class="action small">
        <a href="<?php echo url_for('contests/index') ?>">Cancel</a>
        &nbsp;&nbsp;or&nbsp;&nbsp;
        <input type="submit" class="submit btn-grey28" value="Save" />
      </div>
    </div>
  </div>

</form>
