<?php

/**
 * SignupForm
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Bastian Kuberek <bkuberek@resolute.com>
 */
class SignupForm extends BaseForm
{

  /**
   * @see sfForm
   */
  public function setup()
  {
    parent::setup();

    $this->defaults['sendregistrationemails'] = true;
    $this->defaults['optin'] = true;

    $subscriptions = array();

    foreach (sfConfig::get('app_RegServices_subscriptions', array()) as $sub) {
      $subscriptions[$sub['bundle_id']] = $sub['name'];
      if ($sub['precheck']) {
        $this->defaults['newsletter_ids'][] = $sub['bundle_id'];
      }
    }

    $this->setWidgets(array(
      'display_name' => new sfWidgetFormInputText(array(), array('maxlength' => 14)),
      'firstname' => new sfWidgetFormInputText(),
      'email' => new sfWidgetFormInputText(),
      'password' => new sfWidgetFormInputPassword()
    ));

    $this->setValidators(array(
      'display_name' => new ValidatorRegServicesDisplayName(),
      'firstname' => new sfValidatorString(array('required' => true, 'min_length' => 1, 'max_length' => 12), array('max_length' => 'Max 12 characters')),
      'email' => new sfValidatorEmail(array('required' => true, 'max_length' => 50), array('max_length' => 'Max 50 characters')),
      'password' => new ValidatorRegServicesPassword()
    ));

    if ($subscriptions) {
      $this->widgetSchema['newsletter_ids'] = new sfWidgetFormChoice(array('choices' => $subscriptions, 'multiple' => true, 'expanded' => true));
      $this->validatorSchema['newsletter_ids'] = new sfValidatorPass(); //new sfValidatorChoice(array('choices' => array_keys($subscriptions), 'required' => false));
    }

    /** Registration Newsletters */
    $this->widgetSchema['sendregistrationemails'] = new sfWidgetFormInputHidden();
    $this->validatorSchema['sendregistrationemails'] = new sfValidatorBoolean(array('required' => false));

    /** optin */
    $this->widgetSchema['optin'] = new sfWidgetFormInputCheckbox();
    $this->validatorSchema['optin'] = new sfValidatorBoolean(array('required' => false));

    $this->widgetSchema->setNameFormat('signup[%s]');

    $this->validatorSchema->setPostValidator(new ValidatorRegServicesRegister());
  }

  public function signup()
  {
    if (!($values = $this->values)) {
      return;
    }
	
    $user = new User();
    $user->setProfileId($values['profile_id']);
    $user->setDisplayName($values['display_name']);
    $user->setEmail($values['email']);
    $user->setRegSource($values['reg_source']);
    $user->setAvatar('default_' . rand(1, 16) . '.jpg');
    $user->save();
    $reg_services = new RegServices();
    $user_info = $reg_services->getProfile($values['profile_id']);
    $contact_info = array('address1' => null, 'address2' => null, 'city' => null, 'state' => null, 'zipcode' => null, 'country' => null);
    $user_profile = array_merge($user_info['user_profile'], $contact_info);
    unset($user_profile['contact_info']);
    return array_merge($user_profile, $user->toArray()); // The order of the values in array_merge is important. Don't change it. Otherwise the id field will not have the correct value Toros Tarpinyan
  }

}