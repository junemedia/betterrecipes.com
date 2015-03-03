<?php

/**
 * Weight form base class.
 *
 * @method Weight getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseWeightForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'override_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Override'), 'add_empty' => false)),
      'item_id'     => new sfWidgetFormInputText(),
      'rank'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'override_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Override'))),
      'item_id'     => new sfValidatorInteger(),
      'rank'        => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('weight[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Weight';
  }

}
