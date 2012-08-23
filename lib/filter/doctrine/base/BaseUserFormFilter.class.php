<?php

/**
 * User filter form base class.
 *
 * @package    betterrecipes
 * @subpackage filter
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUserFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'onesite_id'     => new sfWidgetFormFilterInput(),
      'blog_id'        => new sfWidgetFormFilterInput(),
      'profile_id'     => new sfWidgetFormFilterInput(),
      'fb_id'          => new sfWidgetFormFilterInput(),
      'first_name'     => new sfWidgetFormFilterInput(),
      'last_name'      => new sfWidgetFormFilterInput(),
      'display_name'   => new sfWidgetFormFilterInput(),
      'subdir'         => new sfWidgetFormFilterInput(),
      'email'          => new sfWidgetFormFilterInput(),
      'avatar'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_admin'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_super_admin' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_premium'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fb_share'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_active'      => new sfWidgetFormFilterInput(),
      'reg_source'     => new sfWidgetFormFilterInput(),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'source'         => new sfWidgetFormChoice(array('choices' => array('' => '', 'nw' => 'nw', 'br' => 'br', 'mb' => 'mb'))),
      'legacy_id'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'onesite_id'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'blog_id'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'profile_id'     => new sfValidatorPass(array('required' => false)),
      'fb_id'          => new sfValidatorPass(array('required' => false)),
      'first_name'     => new sfValidatorPass(array('required' => false)),
      'last_name'      => new sfValidatorPass(array('required' => false)),
      'display_name'   => new sfValidatorPass(array('required' => false)),
      'subdir'         => new sfValidatorPass(array('required' => false)),
      'email'          => new sfValidatorPass(array('required' => false)),
      'avatar'         => new sfValidatorPass(array('required' => false)),
      'is_admin'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_super_admin' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_premium'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fb_share'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_active'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'reg_source'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'source'         => new sfValidatorChoice(array('required' => false, 'choices' => array('nw' => 'nw', 'br' => 'br', 'mb' => 'mb'))),
      'legacy_id'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'onesite_id'     => 'Number',
      'blog_id'        => 'Number',
      'profile_id'     => 'Text',
      'fb_id'          => 'Text',
      'first_name'     => 'Text',
      'last_name'      => 'Text',
      'display_name'   => 'Text',
      'subdir'         => 'Text',
      'email'          => 'Text',
      'avatar'         => 'Text',
      'is_admin'       => 'Number',
      'is_super_admin' => 'Number',
      'is_premium'     => 'Number',
      'fb_share'       => 'Number',
      'is_active'      => 'Number',
      'reg_source'     => 'Number',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
      'source'         => 'Enum',
      'legacy_id'      => 'Text',
    );
  }
}
