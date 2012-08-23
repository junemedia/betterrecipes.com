<div class="signin">
  <h1 class="title purple">Welcome to BetterRecipes!</h1>
  <p class="mb20">Please login to access your account</p>
  <? if ($form->hasGlobalErrors()): ?>
  <?= $form->renderGlobalErrors() ?>
  <? endif ?>
  <form action="<?= url_for('signin') ?>" method="post" class="standard-form">
    <?= $form->renderHiddenFields() ?>
    <fieldset>
      <label for="email">Email</label>
      <?= $form['email'] ?>
      <?= $form['email']->renderError() ?>
    </fieldset>
    <fieldset>
      <label for="password">Password</label>
      <?= $form['password'] ?>
      <?= $form['password']->renderError() ?>
    </fieldset>
    <fieldset class="last">
    	<a href="<? echo url_for('forgotpassword') ?>" class="fs11 mr20">Forgot Password?</a>
      <input type="submit" value="Authenticate" class="btn-grey28" />
    </fieldset>
  </form>
</div><!-- /.signin -->
