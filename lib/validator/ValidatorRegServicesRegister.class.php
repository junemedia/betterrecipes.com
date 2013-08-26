<?php

/**
 * ValidatorRegServicesRegister
 * 
 * @package    betterrecipes
 * @subpackage validator
 * @author     Toros Tarpinyan
 */
class ValidatorRegServicesRegister extends sfValidatorBase
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
    $reg_services = new RegServices();

    $rs_values['display_name'] = $values['display_name'];
    $rs_values['login_name'] = $values['email'];
    $rs_values['first_name'] = $values['firstname'];
    $rs_values['password'] = $values['password'];
    $rs_values['optin'] = $values['optin'];
    $rs_values['send_registration_emails'] = $values['sendregistrationemails'];
    $reg_source = sfContext::getInstance()->getUser()->getRegSourceAttribute('code');

    $result = $reg_services->register($rs_values, $reg_source);
	//print_r($result);    
    if ( isset($result['code']) ) {
	    switch ($result['code']) {
	      case '0':
	        $values['reg_source'] = $reg_source;
	        $values['profile_id'] = $result['profile_id'];
	        return $values;
	        break;
	      case '100':
	        $this->setMessage('invalid', $result['error']);
	        throw new sfValidatorError($this, 'invalid', array('values' => $values));
	        break;
	      case '101':
	        switch ($result['key']) {
	          case 'loginTooLong':
	          case 'loginRequired':
	          case 'invalidEmailAddressFormat':
	            $field = "email";
	            break;
	          case 'passwordRequired':
	          case 'insufficientPassword':
	            $field = 'password';
	            break;
	          case 'alreadyExistingDisplayName':
	          case 'displayNameRequired':
	            $field = 'display_name';
	            break;
	          case 'firstNameRequired':
	          case 'firstNameTooLong':
	            $field = 'firstname';
	            break;
	          case 'invalidDisplayNameFormat' :
	          	$field = 'display_name';
	          	//$result['error'] = 'Display Name must begin with letters.';
	          break;
	          default:
	            $field = 'generic';
	        }
	        if ($field != 'generic') {
	          $error = new sfValidatorError($this, $result['error']);
	          $errorschema = new sfValidatorErrorSchema($this, array($error));
	          throw new sfValidatorErrorSchema($this, array($field => $errorschema));
	          break;
	        }
	      default:
	        $this->setMessage('invalid', 'An error occured. Check your values and try again.');
	        throw new sfValidatorError($this, 'invalid', array('values' => $values));
	        break;
	    }
    }
  }

}
