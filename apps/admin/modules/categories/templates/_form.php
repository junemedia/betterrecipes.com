<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<script>

</script>

<form action="<?php echo url_for('categories/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<?php endif; ?>
  <?php echo $form->renderHiddenFields(false) ?>
  <?php echo $form->renderGlobalErrors() ?>
  <div class="img">
    <img src="<?=$form->getImage() ?>" alt="Category Image" />   
    <div class="upload">
      <?= $form['image']->renderError() ?>
      <?= $form['image']->renderLabel() ?>      
      <?= $form['image'] ?>
    </div>
  </div>
  <div id="categories" class="fields">
    <div class="field">
      <?= $form['description']->renderError() ?>
      <?= $form['description']->renderLabel() ?>      
      <?= $form['description'] ?>
    </div>
    <div class="field">
      <?= $form['title_tag']->renderError() ?>
      <?= $form['title_tag']->renderLabel() ?>      
      <?= $form['title_tag'] ?>
    </div> 
    <div class="field">
      <?= $form['summary']->renderError() ?>
      <?= $form['summary']->renderLabel() ?>      
      <?= $form['summary'] ?>
    </div>    
    <div class="field">
      <?= $form['keywords']->renderError() ?>
      <?= $form['keywords']->renderLabel() ?>      
      <?= $form['keywords'] ?>
    </div>  
    <div class="field">
      <div class="action">
        <a href="<?php echo url_for('categories/index') ?>">Cancel</a>
        &nbsp;&nbsp;or&nbsp;&nbsp;
        <input type="submit" class="submit btn-grey28" value="Save" />
      </div>
    </div>
  </div>
</form>
