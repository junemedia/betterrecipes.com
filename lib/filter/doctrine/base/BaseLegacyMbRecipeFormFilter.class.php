<?php

/**
 * LegacyMbRecipe filter form base class.
 *
 * @package    betterrecipes
 * @subpackage filter
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLegacyMbRecipeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'recipe_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Recipe'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'recipe_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Recipe'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('legacy_mb_recipe_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LegacyMbRecipe';
  }

  public function getFields()
  {
    return array(
      'recipe_id'  => 'ForeignKey',
      'message_id' => 'Number',
      'group_id'   => 'Number',
    );
  }
}
