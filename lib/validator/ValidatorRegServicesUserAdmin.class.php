<?php

/**
 * ValidatorUser
 * 
 * @package    betterrecipes
 * @subpackage validator
 * @author     Bastian Kuberek <bkuberek@resolute.com>
 */
class ValidatorRegServicesUserAdmin extends sfValidatorBase
{

  /**
   * Configure Validator
   *
   * @see sfValidatorBase::configure()
   * @param array $options
   * @param array $messages
   */
  public function configure($options = array(), $messages = array())
  {
    $this->addOption('username_field', 'email');
    $this->addOption('password_field', 'password');
    $this->addOption('throw_global_error', false);

    $this->setMessage('invalid', 'The email and/or password is invalid.');
  }

  /**
   * Clean values
   *
   * @see sfValidatorBase::doClean()
   * @param array $values
   * @return array the cleaned values
   */
  protected function doClean($values)
  {
    $username = isset($values[$this->getOption('username_field')]) ? $values[$this->getOption('username_field')] : '';
    $password = isset($values[$this->getOption('password_field')]) ? $values[$this->getOption('password_field')] : '';

    $reg_services = new RegServices();

    $result = $reg_services->authenticate($username, $password);

    if ($result['code'] == 0) {
      // get user profile from database
      $user = UserTable::getUserByProfileId(strval($result['xml']->profileid));
      if (!$user) {
        $user = new User();
      }
      $user_info = $reg_services->getProfile(strval($result['xml']->profileid));
      $contact_info = @$user_info['user_profile']['contact_info'];
      if (is_null($contact_info)) {
        $contact_info = array('address1' => null, 'address2' => null, 'city' => null, 'state' => null, 'zipcode' => null, 'country' => null);
      }
      $user_profile = array_merge($user_info['user_profile'], $contact_info);
      unset($user_profile['contact_info']);
      $user->commitUserData($user_profile);
      $user_data = array_merge($user_profile, $user->toArray()); // The order of the values in array_merge is important. Don't change it. Otherwise the id field will not have the correct value Toros Tarpinyan
      return array_merge($values, compact('user_data'));
    } elseif ($result['code'] == 1) {
    	$field = 'password';
	    $error = new sfValidatorError($this, 'The login and password do not match.');
	    $errorschema = new sfValidatorErrorSchema($this, array($error));
	    throw new sfValidatorErrorSchema($this, array($field => $errorschema));

      //$this->setMessage('invalid', $result['message']);
      //$this->setMessage('invalid', 'The login and password do not match.');
      //throw new sfValidatorError($this, 'invalid');
    } else {
	    // result code 2: password reset is required
	    $field = 'password';
	    $error = new sfValidatorError($this, 'Your password is outdated and requires a reset.');
	    $errorschema = new sfValidatorErrorSchema($this, array($error));
	    throw new sfValidatorErrorSchema($this, array($field => $errorschema));

    }
  }

}
