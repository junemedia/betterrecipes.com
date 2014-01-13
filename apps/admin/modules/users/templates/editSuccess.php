<script>
  $(document).ready(function(){
    $("#is_active_chkbox").change(function(){
      if($(this).attr("checked")){
        $("#user_is_active").val(1);
      } else {
        $("#user_is_active").val(0);
      }
    });  
    
    $("#is_admin_chkbox").change(function(){
      if($(this).attr("checked")){
        $("#user_is_admin").val(1);
      } else {
        $("#user_is_admin").val(0);
      }
    });  
    
    $("#is_super_admin_chkbox").change(function(){
      if($(this).attr("checked")){
        $("#user_is_super_admin").val(1);
      } else {
        $("#user_is_super_admin").val(0);
      }
    }); 
    
    $("#is_featured_blogger_chkbox").change(function(){
      if($(this).attr("checked")){
        $("#is_featured_blogger").val(1);
      } else {
        $("#is_featured_blogger").val(0);
      }
    });  
      
  });
</script>


<div id="mainHeading">
  <h1>Edit User: <?= $user->getEmail() ?></h1>
</div>
<div id="userContainer" class="container big edit">
  <h2>Credentials</h2>
  <? use_stylesheets_for_form($form) ?>
  <? use_javascripts_for_form($form) ?>
  <form action="<?= getDomainUri().url_for('users_edit', $user) ?>" method="post">
    <?php echo $form->renderHiddenFields() ?>
    <?= $form->renderGlobalErrors() ?>
    <? if (!empty($errorMsg)) echo $errorMsg ?>
    <div id="users" class="fields">
      
      <div class="field">
        <?= $form['is_active']->renderError() ?>
        <?= $form['is_active']->renderLabel() ?>      
        <?= $form['is_active'] ?>
        <input type="checkbox" id="is_active_chkbox" name="is_active_chkbox"<? if ($form['is_active']->getValue() == 1): ?> checked<? endif; ?> >
      </div>
      
      <div class="field">
        <?= $form['is_admin']->renderError() ?>
        <?= $form['is_admin']->renderLabel() ?>      
        <?= $form['is_admin'] ?>
        <input type="checkbox" id="is_admin_chkbox" name="is_admin_chkbox"<? if ($form['is_admin']->getValue() == 1): ?> checked<? endif; ?> >
      </div>
      
      <div class="field">
        <?= $form['is_super_admin']->renderError() ?>
        <?= $form['is_super_admin']->renderLabel() ?>      
        <?= $form['is_super_admin'] ?>
        <input type="checkbox" id="is_super_admin_chkbox" name="is_super_admin_chkbox"<? if ($form['is_super_admin']->getValue() == 1): ?> checked<? endif; ?> >
      </div>
      
      <div class="field">
        <?= $form['is_featured_blogger']->renderError() ?>
        <?= $form['is_featured_blogger']->renderLabel() ?>      
        <?= $form['is_featured_blogger'] ?>
        <input type="checkbox" id="is_featured_blogger_chkbox" name="is_featured_blogger_chkbox"<? if ($form['is_featured_blogger']->getValue() == 1): ?> checked<? endif; ?> >
      </div>

      <div class="field">
        <div class="action">
          <a href="<?= getRoute('@users_index') ?>">Cancel</a>
          &nbsp;&nbsp;or&nbsp;&nbsp;
          <input type="submit" class="submit" value="Save" />
        </div>
      </div>
    </div>
  </form>

</div>