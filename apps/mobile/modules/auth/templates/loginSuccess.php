<div class="sidebar">
  <p class="header"><a style="padding-left:3.1%" id="login" href="<?= getSignupUri() ?>">Not a Member? Register</a></p>
  <? if ($signinForm->hasGlobalErrors()): ?>
    <?= $signinForm->renderGlobalErrors() ?>
  <? endif ?>
  <form class="login mb20 standard-form pb10" action="<?= getSigninUri() ?>" method="post">
    <fieldset>
    <?= $signinForm->renderHiddenFields() ?>
    <? if (isset($social)): ?>
      <input type="hidden" name="social" value="1"/>
    <? endif ?>
      <label for="signin_email">Email Address:</label>
      <?= $signinForm['email']->render(array('id' => 'signin_email', 'type' => 'email')) ?>
      <?= $signinForm['email']->renderError() ?>
    </fieldset>
    <fieldset>
      <label for="signin_password">Password:</label>
      <?= $signinForm['password']->render(array('id' => 'signin_password')) ?>
      <?= $signinForm['password']->renderError() ?>
    </fieldset>
    <fieldset>
      <input type="submit" value="Login" class="mr10 flri" />
  	</fieldset>
  	
  	<fieldset class="gigya">
      <div class="gigya-auth"></div>
    </fieldset>
  	
  </form>
  <p class="header"><span class="green">Forgot Your Password?</span></p>
  <p class="mb10 mr10 ml10">Enter your e-mail address and we will send your password to you right away!</p>
  <? if ($passwordForm->hasGlobalErrors()): ?>
    <?= $passwordForm->renderGlobalErrors() ?>
  <? endif ?>
  <form class="forgot-password mb20 standard-form pb10" action="<?= getRoute('forgot_password') ?>" method="post">
  	<fieldset>
			<?= $passwordForm->renderHiddenFields() ?>
      <label for="forgot_email">E-mail Address</label>
      <?= $passwordForm['email']->render(array('id' => 'forgot_email')) ?>
      <?= $passwordForm['email']->renderError() ?>
    </fieldset>
    <fieldset>
      <input type="submit" value="Send Password" class="mr10 flri" />
    </fieldset>
  </form>
</div>
<div class="clearfix"></div>
