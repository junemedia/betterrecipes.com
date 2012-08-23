<div class="article registration">
  <? //include_component('static', 'topper') ?>
  <p class="header"><span class="green" id="reg-form">Your Information</span></p>
  <? if ($signupForm->hasGlobalErrors()): ?>
    <?= $signupForm->renderGlobalErrors() ?>
  <? endif ?>
  <form class="standard-form reg-form pb10" action="<?= getSignupUri() ?>" method="post">
    <?= $signupForm->renderHiddenFields() ?>
    <? if (isset($social)): ?>
      <input type="hidden" name="social" value="1"/>
    <? endif ?>
    <fieldset>
      <label for="reg_firstname">First Name:</label>
      <?= $signupForm['firstname']->renderError() ?>
      <?= $signupForm['firstname']->render(array('id' => 'reg_firstname')) ?>
    </fieldset>
    <fieldset>
      <label for="reg_email">E-mail Address:</label>
      <?= $signupForm['email']->renderError() ?>
      <?= $signupForm['email']->render(array('id' => 'reg_email', 'type' => 'email')) ?>
    </fieldset>
    <fieldset>
      <label for="reg_password1">Password:</label>
      <?= $signupForm['password']->renderError() ?>
      <?= $signupForm['password']->render(array('id' => 'reg_password1')) ?>
    </fieldset>
    <fieldset>
      <label for="reg_display">Display Name:</label>
      <?= $signupForm['display_name']->renderError() ?>
      <?= $signupForm['display_name']->render(array('id' => 'reg_display')) ?>
    </fieldset>
    <? if (!empty($signupForm['newsletter_ids'])): ?>
      <fieldset class="newsletter">
        <p class="ml10 mr10">Choose your FREE newsletter(s)</p>
        <?= $signupForm['newsletter_ids']->renderError() ?>
        <?= $signupForm['newsletter_ids'] ?>
      </fieldset>
    <? endif ?>
    
    <fieldset class="fineprint">
      <label for="sendregistrationemails"><?= $signupForm['optin']->render(array('id' => 'mailinglist')) ?> Yes! I'd like to receive news and offers from your publications via e-mail.</label>
      <p class="fs11 italic ml10 mr10">Your email address will not be sold or rented to third parties. <a href="<?= getDomainUri() . url_for('@privacy-policy') ?>" target="_blank" title="Read our Privacy Policy">Privacy Policy</a></p>
    </fieldset>
    <fieldset>
      <input type="submit" value="Continue" class="ml10" />
    </fieldset>
  </form>
</div><!-- /.article -->
<div class="clearfix"></div>
