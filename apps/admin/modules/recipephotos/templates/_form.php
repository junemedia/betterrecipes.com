<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form method="post" action="<?= url_for('recipephotos/'.($form->getObject()->isNew() ? 'new' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId().'&recipe_id='.$recipeId : '?recipe_id='.$recipeId))?>" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php echo $form->renderHiddenFields(false) ?>
  <?php echo $form->renderGlobalErrors() ?>
  <div id="recipephotos" class="fields">
    <div class="field">
      <?= $form['name']->renderLabel() ?></th>
      <?= $form['name']->renderError() ?>
      <?= $form['name'] ?>
    </div>
    <div class="field">
      <?= $form['description']->renderError() ?>
      <?= $form['description']->renderLabel() ?>      
      <?= $form['description'] ?>
    </div>
    <div class="field">
      <?= $form['image']->renderError() ?>
      <?= $form['image']->renderLabel() ?>    
      <?= $form['image'] ?>
    </div>        
    <div class="field">
      <div class="action">
        <a href="<?= url_for('recipephotos/index?recipe_id='.$recipeId) ?>">Cancel</a>
        &nbsp;&nbsp;or&nbsp;&nbsp;
        <input type="submit" class="submit" value="Save" />
      </div>
    </div>
  </div>
</form>