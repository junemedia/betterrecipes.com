<?php

/**
 * CategoryWonders form base class.
 *
 * @method CategoryWonders getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCategoryWondersForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'title'                  => new sfWidgetFormInputText(),
      'slot_one_cat_id'        => new sfWidgetFormInputText(),
      'slot_one_subcat_one'    => new sfWidgetFormInputText(),
      'slot_one_subcat_two'    => new sfWidgetFormInputText(),
      'slot_one_description'   => new sfWidgetFormInputText(),
      'slot_two_cat_id'        => new sfWidgetFormInputText(),
      'slot_two_subcat_one'    => new sfWidgetFormInputText(),
      'slot_two_subcat_two'    => new sfWidgetFormInputText(),
      'slot_two_description'   => new sfWidgetFormInputText(),
      'slot_three_cat_id'      => new sfWidgetFormInputText(),
      'slot_three_subcat_one'  => new sfWidgetFormInputText(),
      'slot_three_subcat_two'  => new sfWidgetFormInputText(),
      'slot_three_description' => new sfWidgetFormInputText(),
      'slot_four_cat_id'       => new sfWidgetFormInputText(),
      'slot_four_subcat_one'   => new sfWidgetFormInputText(),
      'slot_four_subcat_two'   => new sfWidgetFormInputText(),
      'slot_four_description'  => new sfWidgetFormInputText(),
      'is_active'              => new sfWidgetFormInputText(),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'title'                  => new sfValidatorString(array('max_length' => 255)),
      'slot_one_cat_id'        => new sfValidatorInteger(),
      'slot_one_subcat_one'    => new sfValidatorInteger(array('required' => false)),
      'slot_one_subcat_two'    => new sfValidatorInteger(array('required' => false)),
      'slot_one_description'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'slot_two_cat_id'        => new sfValidatorInteger(),
      'slot_two_subcat_one'    => new sfValidatorInteger(array('required' => false)),
      'slot_two_subcat_two'    => new sfValidatorInteger(array('required' => false)),
      'slot_two_description'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'slot_three_cat_id'      => new sfValidatorInteger(),
      'slot_three_subcat_one'  => new sfValidatorInteger(array('required' => false)),
      'slot_three_subcat_two'  => new sfValidatorInteger(array('required' => false)),
      'slot_three_description' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'slot_four_cat_id'       => new sfValidatorInteger(),
      'slot_four_subcat_one'   => new sfValidatorInteger(array('required' => false)),
      'slot_four_subcat_two'   => new sfValidatorInteger(array('required' => false)),
      'slot_four_description'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_active'              => new sfValidatorInteger(array('required' => false)),
      'created_at'             => new sfValidatorDateTime(),
      'updated_at'             => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('category_wonders[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CategoryWonders';
  }

}
