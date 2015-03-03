<?php

/**
 * UserInterest form base class.
 *
 * @method UserInterest getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUserInterestForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'     => new sfWidgetFormInputHidden(),
      'interest_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'user_id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('user_id')), 'empty_value' => $this->getObject()->get('user_id'), 'required' => false)),
      'interest_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('interest_id')), 'empty_value' => $this->getObject()->get('interest_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_interest[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserInterest';
  }

}
