<div class="article socialize clear">
  <h3 class="title green">We Found You!</h3>
  <div class="social-info clear">
    <? if (($img = $sf_user->getSocial('thumbnailURL'))): ?>
      <img src="<?= $img ?>" style="float: left; padding: 0 10px 10px 0;" />
    <? endif ?>
    <? if (($nickname = $sf_user->getSocial('nickname'))): ?>
      <p><strong><?= $nickname ?></strong></p>
    <? endif ?>
    <? if (($link = $sf_user->getSocial('profileURL'))): ?>
      <p><a href="<?= $link ?>" target="_blank"><?= $link ?></a></p>
    <? endif ?>
    <div class="clear"></div>
  </div>
  <h3 class="title green">There is one more step</h3>
  <p>This is the first time you login to this site via <?= ucwords($sf_user->getSocial('provider')) ?>.</p>
  <p>Before you go ahead, we need to link your <?= ucwords($sf_user->getAttribute('provider')) ?> account to your Better Recipes account. The next time you login via <?= ucwords($sf_user->getSocial('provider')) ?>, you will be automatically recognized.</p>
  <p>Please login or register below so that we can link your <?= ucwords($sf_user->getSocial('provider')) ?> account. This is a one time confirmation.</p>
</div>
<div class="article registration">
  <h3 class="title green">Your Information</h3>
  <? if ($signupForm->hasGlobalErrors()): ?>
    <?= $signupForm->renderGlobalErrors() ?>
  <? endif ?>
  <form class="standard-form reg-form" action="<?= getSignupUri() ?>" method="post">
    <? if (isset($social)): ?>
      <input type="hidden" name="social" value="1"/>
    <? endif ?>
    <?= $signupForm->renderHiddenFields() ?>
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
      <input type="submit" value="Register and Link My Account" class="btn-purple28" />
    </fieldset>
    <? if (!empty($signupForm['newsletter_ids'])): ?>
      <fieldset class="newsletter">
        <p>Choose your FREE newsletter(s)</p>
        <?= $signupForm['newsletter_ids'] ?>
        <?= $signupForm['newsletter_ids']->renderError() ?>
      </fieldset>
    <? endif ?>

    <fieldset class="fineprint">
      <label for="sendregistrationemails"><?= $signupForm['optin']->render(array('id' => 'mailinglist')) ?> Yes! I'd like to receive news and offers from your publications via e-mail.</label>
      <p class="ml20">Your email address will not be sold or rented to third parties. <a href="<?= UrlToolkit::getDomainUri() . url_for('@privacy-policy') ?>" target="_blank" title="Read our Privacy Policy">Privacy Policy</a></p>
    </fieldset>
  </form>
</div><!-- /.article -->
<div class="sidebar">
  <p class="title green">Already A Member?</p>
  <? if ($signinForm->hasGlobalErrors()): ?>
    <?= $signinForm->renderGlobalErrors() ?>
  <? endif ?>
  <form class="login mb20 standard-form" action="<?= getSigninUri() ?>" method="post">
    <? if (isset($social)): ?>
      <input type="hidden" name="social" value="1"/>
    <? endif ?>
    <?= $signinForm->renderHiddenFields() ?>
    <fieldset>
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
    <input type="submit" value="Link My Account" class="btn-purple28 mr20" />
    </fieldset>
  </form>
  
  <p class="title green">Forgot Your Password?</p>
  <p class="mb10">Enter your e-mail address and we will send your password to you right away!</p>
  <? if ($passwordForm->hasGlobalErrors()): ?>
    <?= $passwordForm->renderGlobalErrors() ?>
  <? endif ?>
  <form class="forgot-password mb20 standard-form" action="<?= getRoute('forgot_password') ?>" method="post">
    <?= $passwordForm->renderHiddenFields() ?>
    <fieldset>
    <label for="forgot_email">E-mail Address</label>
    <?= $passwordForm['email']->render(array('id' => 'forgot_email')) ?>
    <?= $passwordForm['email']->renderError() ?>
    </fieldset>
    <fieldset>
    <input type="submit" value="Send Password" class="btn-purple28" />
    </fieldset>
  </form>
</div>
<div class="clearfix"></div>
