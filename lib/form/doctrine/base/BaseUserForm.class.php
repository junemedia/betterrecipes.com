<?php

/**
 * User form base class.
 *
 * @method User getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'onesite_id'          => new sfWidgetFormInputText(),
      'blog_id'             => new sfWidgetFormInputText(),
      'profile_id'          => new sfWidgetFormInputText(),
      'fb_id'               => new sfWidgetFormInputText(),
      'first_name'          => new sfWidgetFormInputText(),
      'last_name'           => new sfWidgetFormInputText(),
      'display_name'        => new sfWidgetFormInputText(),
      'subdir'              => new sfWidgetFormInputText(),
      'email'               => new sfWidgetFormInputText(),
      'avatar'              => new sfWidgetFormInputText(),
      'is_admin'            => new sfWidgetFormInputText(),
      'is_super_admin'      => new sfWidgetFormInputText(),
      'is_premium'          => new sfWidgetFormInputText(),
      'fb_share'            => new sfWidgetFormInputText(),
      'is_active'           => new sfWidgetFormInputText(),
      'is_featured_blogger' => new sfWidgetFormInputText(),
      'reg_source'          => new sfWidgetFormInputText(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'source'              => new sfWidgetFormChoice(array('choices' => array('nw' => 'nw', 'br' => 'br', 'mb' => 'mb'))),
      'legacy_id'           => new sfWidgetFormInputText(),
      'website_name'        => new sfWidgetFormInputText(),
      'website_address'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'onesite_id'          => new sfValidatorInteger(array('required' => false)),
      'blog_id'             => new sfValidatorInteger(array('required' => false)),
      'profile_id'          => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'fb_id'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'first_name'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'last_name'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'display_name'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'subdir'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'avatar'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'is_admin'            => new sfValidatorInteger(array('required' => false)),
      'is_super_admin'      => new sfValidatorInteger(array('required' => false)),
      'is_premium'          => new sfValidatorInteger(array('required' => false)),
      'fb_share'            => new sfValidatorInteger(array('required' => false)),
      'is_active'           => new sfValidatorInteger(array('required' => false)),
      'is_featured_blogger' => new sfValidatorInteger(array('required' => false)),
      'reg_source'          => new sfValidatorInteger(array('required' => false)),
      'created_at'          => new sfValidatorDateTime(array('required' => false)),
      'updated_at'          => new sfValidatorDateTime(array('required' => false)),
      'source'              => new sfValidatorChoice(array('choices' => array(0 => 'nw', 1 => 'br', 2 => 'mb'), 'required' => false)),
      'legacy_id'           => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'website_name'        => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'website_address'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }

}
