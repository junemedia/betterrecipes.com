<?php

/**
 * MbForwardLog form base class.
 *
 * @method MbForwardLog getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMbForwardLogForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'url'     => new sfWidgetFormInputHidden(),
      'date'    => new sfWidgetFormInputHidden(),
      'counter' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'url'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('url')), 'empty_value' => $this->getObject()->get('url'), 'required' => false)),
      'date'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('date')), 'empty_value' => $this->getObject()->get('date'), 'required' => false)),
      'counter' => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('mb_forward_log[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MbForwardLog';
  }

}
