<?php

/**
 * Recipe filter form base class.
 *
 * @package    betterrecipes
 * @subpackage filter
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseRecipeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'slug'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'introduction'    => new sfWidgetFormFilterInput(),
      'ingredients'     => new sfWidgetFormFilterInput(),
      'description'     => new sfWidgetFormFilterInput(),
      'servings'        => new sfWidgetFormFilterInput(),
      'preptime'        => new sfWidgetFormFilterInput(),
      'cooktime'        => new sfWidgetFormFilterInput(),
      'totaltime'       => new sfWidgetFormFilterInput(),
      'summary'         => new sfWidgetFormFilterInput(),
      'title_tag'       => new sfWidgetFormFilterInput(),
      'keywords'        => new sfWidgetFormFilterInput(),
      'notes'           => new sfWidgetFormFilterInput(),
      'quick_recipe'    => new sfWidgetFormFilterInput(),
      'rating'          => new sfWidgetFormFilterInput(),
      'rating_count'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'main_ingredient' => new sfWidgetFormFilterInput(),
      'course'          => new sfWidgetFormChoice(array('choices' => array('' => '', 'desserts' => 'desserts', 'side dish' => 'side dish', 'breakfast brunch' => 'breakfast brunch', 'main dish' => 'main dish', 'appetizer' => 'appetizer', 'beverages' => 'beverages', 'other' => 'other'))),
      'origin'          => new sfWidgetFormFilterInput(),
      'instructions'    => new sfWidgetFormFilterInput(),
      'views'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'recommendations' => new sfWidgetFormFilterInput(),
      'sponsor_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sponsor'), 'add_empty' => true)),
      'is_active'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'user_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'updated_by_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User2'), 'add_empty' => true)),
      'onesite_id'      => new sfWidgetFormFilterInput(),
      'initial_cat_id'  => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'source'          => new sfWidgetFormChoice(array('choices' => array('' => '', 'nw' => 'nw', 'br' => 'br', 'mb' => 'mb'))),
      'legacy_id'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'            => new sfValidatorPass(array('required' => false)),
      'slug'            => new sfValidatorPass(array('required' => false)),
      'introduction'    => new sfValidatorPass(array('required' => false)),
      'ingredients'     => new sfValidatorPass(array('required' => false)),
      'description'     => new sfValidatorPass(array('required' => false)),
      'servings'        => new sfValidatorPass(array('required' => false)),
      'preptime'        => new sfValidatorPass(array('required' => false)),
      'cooktime'        => new sfValidatorPass(array('required' => false)),
      'totaltime'       => new sfValidatorPass(array('required' => false)),
      'summary'         => new sfValidatorPass(array('required' => false)),
      'title_tag'       => new sfValidatorPass(array('required' => false)),
      'keywords'        => new sfValidatorPass(array('required' => false)),
      'notes'           => new sfValidatorPass(array('required' => false)),
      'quick_recipe'    => new sfValidatorPass(array('required' => false)),
      'rating'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'rating_count'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'main_ingredient' => new sfValidatorPass(array('required' => false)),
      'course'          => new sfValidatorChoice(array('required' => false, 'choices' => array('desserts' => 'desserts', 'side dish' => 'side dish', 'breakfast brunch' => 'breakfast brunch', 'main dish' => 'main dish', 'appetizer' => 'appetizer', 'beverages' => 'beverages', 'other' => 'other'))),
      'origin'          => new sfValidatorPass(array('required' => false)),
      'instructions'    => new sfValidatorPass(array('required' => false)),
      'views'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'recommendations' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sponsor_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Sponsor'), 'column' => 'id')),
      'is_active'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'updated_by_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User2'), 'column' => 'id')),
      'onesite_id'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'initial_cat_id'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'source'          => new sfValidatorChoice(array('required' => false, 'choices' => array('nw' => 'nw', 'br' => 'br', 'mb' => 'mb'))),
      'legacy_id'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('recipe_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Recipe';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'name'            => 'Text',
      'slug'            => 'Text',
      'introduction'    => 'Text',
      'ingredients'     => 'Text',
      'description'     => 'Text',
      'servings'        => 'Text',
      'preptime'        => 'Text',
      'cooktime'        => 'Text',
      'totaltime'       => 'Text',
      'summary'         => 'Text',
      'title_tag'       => 'Text',
      'keywords'        => 'Text',
      'notes'           => 'Text',
      'quick_recipe'    => 'Text',
      'rating'          => 'Number',
      'rating_count'    => 'Number',
      'main_ingredient' => 'Text',
      'course'          => 'Enum',
      'origin'          => 'Text',
      'instructions'    => 'Text',
      'views'           => 'Number',
      'recommendations' => 'Number',
      'sponsor_id'      => 'ForeignKey',
      'is_active'       => 'Number',
      'user_id'         => 'ForeignKey',
      'updated_by_id'   => 'ForeignKey',
      'onesite_id'      => 'Number',
      'initial_cat_id'  => 'Number',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
      'source'          => 'Enum',
      'legacy_id'       => 'Text',
    );
  }
}
