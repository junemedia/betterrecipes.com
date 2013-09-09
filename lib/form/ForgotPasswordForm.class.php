<?php

/**
 * Forgot Password form.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Bastian Kuberek <bkuberek@resolute.com>
 */
class ForgotPasswordForm extends BaseForm
{

  public function setup()
  {
    parent::configure();

    $years = range(date('Y') - 105, date('Y') - 5);
    $this->years = array_combine($years, $years);

    $this->setWidgets(array(
      'email' => new sfWidgetFormInputText(array(), array('placeholder' => 'Email Address'))
    ));


    $this->widgetSchema->setLabels(array(
      'email' => 'Email'
    ));

    $this->setValidators(array(
      'email' => new sfValidatorEmail(array('max_length' => 192, 'required' => true))
    ));

    $this->widgetSchema->setNameFormat('forgot_password[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  /**
   * Sends request for password
   * 
   * @return type 
   */
  public function send()
  {
    if (!$this->isValid()) {
      throw $this->getErrorSchema();
    }

    $values = $this->values;
    $reg_service = new RegServices();
    $response = $reg_service->sendPasswordReminder($values['email']);
    if ($response['code'] == '0') {
      return true;
    } else {
      if ($response['code'] == '102') {
        $message = 'The login could not be found.';
      } else {
        $message = $response['message'];
      }
      $this->errorSchema->addError(new sfValidatorError($this->validatorSchema, $message, array('field' => 'email')), 'email');
      return false;
    }
  }

}
