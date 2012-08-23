<?php

/**
 * DailyDish form base class.
 *
 * @method DailyDish getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDailyDishForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'   => new sfWidgetFormInputHidden(),
      'slug' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'slug' => new sfValidatorString(array('max_length' => 500)),
    ));

    $this->widgetSchema->setNameFormat('daily_dish[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DailyDish';
  }

}
