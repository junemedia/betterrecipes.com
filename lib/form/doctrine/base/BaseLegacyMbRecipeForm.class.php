<?php

/**
 * LegacyMbRecipe form base class.
 *
 * @method LegacyMbRecipe getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLegacyMbRecipeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'recipe_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Recipe'), 'add_empty' => false)),
      'message_id' => new sfWidgetFormInputHidden(),
      'group_id'   => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'recipe_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Recipe'))),
      'message_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('message_id')), 'empty_value' => $this->getObject()->get('message_id'), 'required' => false)),
      'group_id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('group_id')), 'empty_value' => $this->getObject()->get('group_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('legacy_mb_recipe[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LegacyMbRecipe';
  }

}
