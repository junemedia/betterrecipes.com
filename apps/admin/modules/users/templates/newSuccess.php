<? use_stylesheets_for_form($form) ?>
<? use_javascripts_for_form($form) ?>
<div id="mainHeading">
  <h1>Add Admin</h1>
</div>

<div id="userNewContainer" class="container big edit newAdmin">
  <h2>Add New Admin</h2>
  <h2><? if (!empty($errorMsg)): echo $errorMsg;
endif; ?></h2>
  <form action="<?= getRoute('users_new', array('type' => 'new')) ?>" method="post">
    <?= $form->renderHiddenFields() ?>
    <?= $form->renderGlobalErrors() ?>
    <div id="users" class="fields">
      <? foreach ($form as $field_name => $field): ?>
        <? if ($field->isHidden())
          continue; ?>
        <div class="field">
          <?= $field->renderError() ?>
          <?= $field->renderLabel() ?>
          <?= $field ?>
        </div>
      <? endforeach ?>

      <div class="field">
        <div class="action">
          <a href="<?= getRoute('@users_index') ?>">Cancel</a>
          &nbsp;&nbsp;or&nbsp;&nbsp;
          <input type="submit" class="submit btn-grey28" value="Save" />
        </div>
      </div>
    </div>
  </form>
</div>
<!--
<div id="userExistContainer" class="container big edit newAdmin">

  <h2>Add Existing User as Admin</h2>
  <form method="post" action="<?//= getRoute('users_new', array('type' => 'exist')) ?>" id="addExistingUser">
    <?//= $existingForm->renderHiddenFields() ?>
    <?//= $existingForm->renderGlobalErrors() ?>
    <div class="field">
      <?///= $existingForm['email']->renderError() ?>
      <?//= $existingForm['email']->renderLabel() ?>
      <?//= $existingForm['email'] ?>
    </div>
    <div class="field">
      <div class="action">
        <a href="<?//= getRoute('@users_index') ?>">Cancel</a>
        &nbsp;&nbsp;or&nbsp;&nbsp;
        <input type="submit" class="submit btn-grey28" value="Save" />
      </div>
    </div>
    <p class="msg">
      <?//= $sf_params->get('msg') ?>
    </p>
  </form>
</div>
</div>-->