<?php

/**
 * Recipe form base class.
 *
 * @method Recipe getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRecipeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'name'            => new sfWidgetFormInputText(),
      'slug'            => new sfWidgetFormInputText(),
      'introduction'    => new sfWidgetFormTextarea(),
      'ingredients'     => new sfWidgetFormTextarea(),
      'description'     => new sfWidgetFormTextarea(),
      'servings'        => new sfWidgetFormInputText(),
      'preptime'        => new sfWidgetFormInputText(),
      'cooktime'        => new sfWidgetFormInputText(),
      'totaltime'       => new sfWidgetFormInputText(),
      'summary'         => new sfWidgetFormInputText(),
      'title_tag'       => new sfWidgetFormInputText(),
      'keywords'        => new sfWidgetFormInputText(),
      'notes'           => new sfWidgetFormTextarea(),
      'quick_recipe'    => new sfWidgetFormInputText(),
      'rating'          => new sfWidgetFormInputText(),
      'rating_count'    => new sfWidgetFormInputText(),
      'main_ingredient' => new sfWidgetFormInputText(),
      'course'          => new sfWidgetFormChoice(array('choices' => array('desserts' => 'desserts', 'side dish' => 'side dish', 'breakfast brunch' => 'breakfast brunch', 'main dish' => 'main dish', 'appetizer' => 'appetizer', 'beverages' => 'beverages', 'other' => 'other'))),
      'origin'          => new sfWidgetFormInputText(),
      'instructions'    => new sfWidgetFormTextarea(),
      'views'           => new sfWidgetFormInputText(),
      'recommendations' => new sfWidgetFormInputText(),
      'sponsor_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sponsor'), 'add_empty' => true)),
      'is_active'       => new sfWidgetFormInputText(),
      'user_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'updated_by_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User2'), 'add_empty' => true)),
      'onesite_id'      => new sfWidgetFormInputText(),
      'initial_cat_id'  => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'source'          => new sfWidgetFormChoice(array('choices' => array('nw' => 'nw', 'br' => 'br', 'mb' => 'mb'))),
      'legacy_id'       => new sfWidgetFormInputText(),
      'is_featured'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'            => new sfValidatorString(array('max_length' => 100)),
      'slug'            => new sfValidatorString(array('max_length' => 100)),
      'introduction'    => new sfValidatorString(array('required' => false)),
      'ingredients'     => new sfValidatorString(array('required' => false)),
      'description'     => new sfValidatorString(array('required' => false)),
      'servings'        => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'preptime'        => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'cooktime'        => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'totaltime'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'summary'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'title_tag'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'keywords'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'notes'           => new sfValidatorString(array('required' => false)),
      'quick_recipe'    => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'rating'          => new sfValidatorNumber(array('required' => false)),
      'rating_count'    => new sfValidatorInteger(array('required' => false)),
      'main_ingredient' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'course'          => new sfValidatorChoice(array('choices' => array(0 => 'desserts', 1 => 'side dish', 2 => 'breakfast brunch', 3 => 'main dish', 4 => 'appetizer', 5 => 'beverages', 6 => 'other'), 'required' => false)),
      'origin'          => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'instructions'    => new sfValidatorString(array('required' => false)),
      'views'           => new sfValidatorInteger(array('required' => false)),
      'recommendations' => new sfValidatorInteger(array('required' => false)),
      'sponsor_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Sponsor'), 'required' => false)),
      'is_active'       => new sfValidatorInteger(array('required' => false)),
      'user_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'updated_by_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User2'), 'required' => false)),
      'onesite_id'      => new sfValidatorInteger(array('required' => false)),
      'initial_cat_id'  => new sfValidatorInteger(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(array('required' => false)),
      'updated_at'      => new sfValidatorDateTime(array('required' => false)),
      'source'          => new sfValidatorChoice(array('choices' => array(0 => 'nw', 1 => 'br', 2 => 'mb'), 'required' => false)),
      'legacy_id'       => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'is_featured'     => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('recipe[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Recipe';
  }

}
