<? if ($sf_request->getParameter('signup_from_fb', 0) == 1): ?>
  <script>
    $(document).ready(function() {
      $('#reg_password1').focus();
    });
  </script>
<? endif ?>
<div class="sidebar">
  <p class="title green">Already A Member?</p>
  <? if ($signinForm->hasGlobalErrors()): ?>
    <?= $signinForm->renderGlobalErrors() ?>
  <? endif ?>
  <form class="login mb20" action="<?= getSigninUri() ?>" method="post">
    <?= $signinForm->renderHiddenFields() ?>
    <? if (isset($social)): ?>
      <input type="hidden" name="social" value="1"/>
    <? endif ?>
    <label for="signin_email">Email Address:</label>
    <?= $signinForm['email']->render(array('id' => 'signin_email', 'type' => 'email')) ?>
    <?= $signinForm['email']->renderError() ?>
    <label for="signin_password">Password:</label>
    <?= $signinForm['password']->render(array('id' => 'signin_password')) ?>
    <?= $signinForm['password']->renderError() ?>
    <? if (@$doRedirect): ?>
    	<ul class="error_list" style="color:#000;">
    		<li>Please <a href="<?='https://'.sfConfig::get('app_regservices_url').sfConfig::get('app_regservices_redirect').'http://'.$_SERVER['HTTP_HOST'].'/signin'?>">click here</a> to set up your new password.</li>
    	</ul>
    <? endif; ?>
    <input type="submit" value="Login" class="btn-purple28 mr20" />
  </form>
  <p class="title green">Forgot Your Password?</p>
  <p class="mb10">Enter your e-mail address and we will send your password to you right away!</p>
  <? if ($passwordForm->hasGlobalErrors()): ?>
    <?= $passwordForm->renderGlobalErrors() ?>
  <? endif ?>
  <form class="forgot-password mb20" action="<?= getRoute('forgot_password') ?>" method="post">
    <?= $passwordForm->renderHiddenFields() ?>
    <label for="forgot_email">E-mail Address</label>
    <?= $passwordForm['email']->render(array('id' => 'forgot_email')) ?>
    <?= $passwordForm['email']->renderError() ?>
    <input type="submit" value="Send Password" class="btn-purple28" />
  </form>
</div>
<div class="banner signin-page mt20">
  <? include_component('static', 'topper') ?>
</div>
<div class="article signin-page">
  <h3 class="title green">Make Better Recipes Social</h3>
  <p>Share what you're making and see what recipes your friends are planning to make.</p>
  <fieldset class="gigya">
    <div id="gigya-auth"class="signin-page"></div>
  </fieldset>
</div>
<div class="article registration signin-page">
  <h3 class="title green">Or Create a New Account</h3>
  <? if ($signupForm->hasGlobalErrors()): ?>
    <?= $signupForm->renderGlobalErrors() ?>
  <? endif ?>
  <form class="standard-form reg-form" action="<?= getSignupUri() ?>" method="post">
    <?= $signupForm->renderHiddenFields() ?>
    <? if (isset($social)): ?>
      <input type="hidden" name="social" value="1"/>
    <? endif ?>
    <fieldset>
      <label for="reg_firstname">First Name:</label>
      <?= $signupForm['firstname']->render(array('id' => 'reg_firstname')) ?>
      <?= $signupForm['firstname']->renderError() ?>
    </fieldset>
    <fieldset>
      <label for="reg_email">E-mail Address:</label>
      <?= $signupForm['email']->render(array('id' => 'reg_email', 'type' => 'email')) ?>
      <?= $signupForm['email']->renderError() ?>
    </fieldset>
    <fieldset>
      <label for="reg_password1">Password:</label>
      <?= $signupForm['password']->render(array('id' => 'reg_password1')) ?>
      <?= $signupForm['password']->renderError() ?>
    </fieldset>
    <fieldset>
      <label for="reg_display">Display Name:</label>
      <?= $signupForm['display_name']->render(array('id' => 'reg_display')) ?>
      <?= $signupForm['display_name']->renderError() ?>
    </fieldset>
    <fieldset>
      <input type="submit" value="Continue" class="btn-purple28" />
    </fieldset>
    <? if (!empty($signupForm['newsletter_ids'])): ?>
      <fieldset class="newsletter">
        <p>Choose your FREE newsletter(s)</p>
        <?= $signupForm['newsletter_ids']->renderError() ?>
        <?= $signupForm['newsletter_ids'] ?>
      </fieldset>
    <? endif ?>
    <fieldset class="fineprint signin-page">
      <label for="sendregistrationemails"><?= $signupForm['optin']->render(array('id' => 'mailinglist')) ?>&nbsp;&nbsp;&nbsp;Yes! I'd like to receive site updates and special offers from the Meredith Women's Network.</label>
      <p class="ml20 mt5">&nbsp;&nbsp;Your email address will not be sold or rented to third parties. <a href="<?= getDomainUri() . url_for('@privacy-policy') ?>" target="_blank" title="Read our Privacy Policy">Privacy Policy</a></p>
    </fieldset>
  </form>
</div><!-- /.article -->
<div class="clearfix"></div>