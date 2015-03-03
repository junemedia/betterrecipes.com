<?php

/**
 * Rate form base class.
 *
 * @method Rate getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRateForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'recipe_id' => new sfWidgetFormInputHidden(),
      'user_id'   => new sfWidgetFormInputHidden(),
      'rating'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'recipe_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('recipe_id')), 'empty_value' => $this->getObject()->get('recipe_id'), 'required' => false)),
      'user_id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('user_id')), 'empty_value' => $this->getObject()->get('user_id'), 'required' => false)),
      'rating'    => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('rate[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Rate';
  }

}
