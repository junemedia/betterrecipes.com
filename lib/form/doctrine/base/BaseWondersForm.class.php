<?php

/**
 * Wonders form base class.
 *
 * @method Wonders getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseWondersForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'homepage_featured' => new sfWidgetFormInputText(),
      'title'             => new sfWidgetFormInputText(),
      'slot_one_title'    => new sfWidgetFormInputText(),
      'slot_one_url'      => new sfWidgetFormInputText(),
      'slot_one_img'      => new sfWidgetFormInputText(),
      'slot_two_title'    => new sfWidgetFormInputText(),
      'slot_two_url'      => new sfWidgetFormInputText(),
      'slot_two_img'      => new sfWidgetFormInputText(),
      'slot_three_title'  => new sfWidgetFormInputText(),
      'slot_three_url'    => new sfWidgetFormInputText(),
      'slot_three_img'    => new sfWidgetFormInputText(),
      'slot_four_title'   => new sfWidgetFormInputText(),
      'slot_four_url'     => new sfWidgetFormInputText(),
      'slot_four_img'     => new sfWidgetFormInputText(),
      'slot_five_title'   => new sfWidgetFormInputText(),
      'slot_five_url'     => new sfWidgetFormInputText(),
      'slot_five_img'     => new sfWidgetFormInputText(),
      'active'            => new sfWidgetFormInputText(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'homepage_featured' => new sfValidatorInteger(array('required' => false)),
      'title'             => new sfValidatorString(array('max_length' => 255)),
      'slot_one_title'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'slot_one_url'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'slot_one_img'      => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'slot_two_title'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'slot_two_url'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'slot_two_img'      => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'slot_three_title'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'slot_three_url'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'slot_three_img'    => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'slot_four_title'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'slot_four_url'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'slot_four_img'     => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'slot_five_title'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'slot_five_url'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'slot_five_img'     => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'active'            => new sfValidatorInteger(array('required' => false)),
      'created_at'        => new sfValidatorDateTime(array('required' => false)),
      'updated_at'        => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('wonders[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Wonders';
  }

}
