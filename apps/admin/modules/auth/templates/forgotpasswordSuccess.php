<div class="signin">
  <h1 class="title purple">Forgot Password?</h1>
  <p class="mb20">Please submit your email address</p>
  	<?= $form->renderGlobalErrors() ?>
  <form action="<? // = url_for('forgotPassword') ?>" method="post" class="standard-form">
    <fieldset>
      <label for="email"><?= $form['email']->renderLabel() ?></label>
      <?= $form['email'] ?>
      <?= $form['email']->renderError() ?>
    </fieldset>
    <fieldset class="last">
      <input type="submit" value="Submit Email" class="btn-grey28" />
    </fieldset>
  </form>
</div><!-- /.signin -->



