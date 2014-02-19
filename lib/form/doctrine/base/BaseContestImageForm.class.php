<?php

/**
 * ContestImage form base class.
 *
 * @method ContestImage getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseContestImageForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'image_name' => new sfWidgetFormInputText(),
      'start_date' => new sfWidgetFormDate(),
      'end_date'   => new sfWidgetFormDate(),
      'timezone'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'image_name' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'start_date' => new sfValidatorDate(array('required' => false)),
      'end_date'   => new sfValidatorDate(array('required' => false)),
      'timezone'   => new sfValidatorString(array('max_length' => 25, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('contest_image[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ContestImage';
  }

}
