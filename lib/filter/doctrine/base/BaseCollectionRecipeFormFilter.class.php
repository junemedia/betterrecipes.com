<?php

/**
 * CollectionRecipe filter form base class.
 *
 * @package    betterrecipes
 * @subpackage filter
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCollectionRecipeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'collection_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Collection'), 'add_empty' => true)),
      'recipe_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Recipe'), 'add_empty' => true)),
      'sequence'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'collection_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Collection'), 'column' => 'id')),
      'recipe_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Recipe'), 'column' => 'id')),
      'sequence'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('collection_recipe_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CollectionRecipe';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'collection_id' => 'ForeignKey',
      'recipe_id'     => 'ForeignKey',
      'sequence'      => 'Number',
    );
  }
}
