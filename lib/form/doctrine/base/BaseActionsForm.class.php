<?php

/**
 * Actions form base class.
 *
 * @method Actions getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseActionsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'action_type'        => new sfWidgetFormChoice(array('choices' => array('recipe' => 'recipe', 'contest' => 'contest', 'poll' => 'poll'))),
      'action_description' => new sfWidgetFormInputText(),
      'action_message'     => new sfWidgetFormTextarea(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'action_type'        => new sfValidatorChoice(array('choices' => array(0 => 'recipe', 1 => 'contest', 2 => 'poll'), 'required' => false)),
      'action_description' => new sfValidatorString(array('max_length' => 255)),
      'action_message'     => new sfValidatorString(array('max_length' => 500)),
      'created_at'         => new sfValidatorDateTime(array('required' => false)),
      'updated_at'         => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('actions[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Actions';
  }

}
