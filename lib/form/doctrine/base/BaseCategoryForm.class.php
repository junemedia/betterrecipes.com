<?php

/**
 * Category form base class.
 *
 * @method Category getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCategoryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'name'           => new sfWidgetFormInputText(),
      'slug'           => new sfWidgetFormInputText(),
      'parent_id'      => new sfWidgetFormInputText(),
      'summary'        => new sfWidgetFormInputText(),
      'title_tag'      => new sfWidgetFormInputText(),
      'keywords'       => new sfWidgetFormInputText(),
      'description'    => new sfWidgetFormTextarea(),
      'is_active'      => new sfWidgetFormInputText(),
      'user_id'        => new sfWidgetFormInputText(),
      'onesite_id'     => new sfWidgetFormInputText(),
      'sequence'       => new sfWidgetFormInputText(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
      'source'         => new sfWidgetFormChoice(array('choices' => array('nw' => 'nw', 'br' => 'br', 'mb' => 'mb'))),
      'legacy_id'      => new sfWidgetFormInputText(),
      'daily_dish_tag' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'           => new sfValidatorString(array('max_length' => 255)),
      'slug'           => new sfValidatorString(array('max_length' => 255)),
      'parent_id'      => new sfValidatorInteger(array('required' => false)),
      'summary'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'title_tag'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'keywords'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description'    => new sfValidatorString(array('required' => false)),
      'is_active'      => new sfValidatorInteger(array('required' => false)),
      'user_id'        => new sfValidatorInteger(),
      'onesite_id'     => new sfValidatorInteger(array('required' => false)),
      'sequence'       => new sfValidatorInteger(array('required' => false)),
      'created_at'     => new sfValidatorDateTime(array('required' => false)),
      'updated_at'     => new sfValidatorDateTime(array('required' => false)),
      'source'         => new sfValidatorChoice(array('choices' => array(0 => 'nw', 1 => 'br', 2 => 'mb'), 'required' => false)),
      'legacy_id'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'daily_dish_tag' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('category[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Category';
  }

}
