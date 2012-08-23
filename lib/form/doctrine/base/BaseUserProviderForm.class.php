<?php

/**
 * UserProvider form base class.
 *
 * @method UserProvider getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUserProviderForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'      => new sfWidgetFormInputHidden(),
      'provider'     => new sfWidgetFormInputHidden(),
      'provider_uid' => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'auth_token'   => new sfWidgetFormInputText(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'user_id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('user_id')), 'empty_value' => $this->getObject()->get('user_id'), 'required' => false)),
      'provider'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('provider')), 'empty_value' => $this->getObject()->get('provider'), 'required' => false)),
      'provider_uid' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'auth_token'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('user_provider[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserProvider';
  }

}
