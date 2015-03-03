<?php

/**
 * Forget Password form.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Bastian Kuberek <bkuberek@resolute.com>
 */
class ForgetPasswordForm extends BaseForm {
	
	public function setup() {
	    parent::configure();
	
	
	    $this->setWidgets(array(
	        'email' => new sfWidgetFormInputText(array(), array('placeholder' => 'Email Address'))
	    ));
			
	    
	    $this->widgetSchema->setLabels(array(
	        'email' => 'Email'
	    ));
	
	    $this->setValidators(array(
	        'email' => new sfValidatorEmail(array('max_length' => 192, 'required' => true))
	    ));
	
	    $this->widgetSchema->setNameFormat('forget_password[%s]');
	
	    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
	
	    parent::setup();
  }
  
  public function sendPassword() {
  	$values = $this->values;
  	$regservices = new RegServices();
  	$result = $regservices->sendPasswordReminder($values['email']);
  	if ($result['code'] == 0) {
  		return true;
  	} else {
  		$field = 'email';
  		 $this->errorSchema->addError(new sfValidatorError($this->validatorSchema, $result['message'], array('field' => $field)), $field);
  		 return false;
  	}
  }


}