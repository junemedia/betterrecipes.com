<?php

/**
 * SigninForm
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Bastian Kuberek <bkuberek@resolute.com>
 */
class SigninForm extends BaseForm
{

  /**
   * @see sfForm
   */
  public function setup()
  {
    parent::setup();

    $this->setWidgets(array(
      'email' => new sfWidgetFormInputText(array(), array('autofocus' => 'autofocus', 'placeholder' => 'Email Address')),
      'password' => new sfWidgetFormInputPassword(array('type' => 'password')),
//        'remember' => new sfWidgetFormInputCheckbox()
    ));

    $this->setValidators(array(
      'email' => new sfValidatorEmail(),
      'password' => new sfValidatorString(),
//        'remember' => new sfValidatorBoolean()
    ));

    $this->validatorSchema->setPostValidator(new ValidatorRegServicesUserAdmin());

    $this->widgetSchema->setNameFormat('signin[%s]');
  }

}