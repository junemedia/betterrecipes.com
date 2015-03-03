<?php

/**
 * Category filter form base class.
 *
 * @package    betterrecipes
 * @subpackage filter
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCategoryFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'slug'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'parent_id'      => new sfWidgetFormFilterInput(),
      'summary'        => new sfWidgetFormFilterInput(),
      'title_tag'      => new sfWidgetFormFilterInput(),
      'keywords'       => new sfWidgetFormFilterInput(),
      'description'    => new sfWidgetFormFilterInput(),
      'is_active'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'user_id'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'onesite_id'     => new sfWidgetFormFilterInput(),
      'sequence'       => new sfWidgetFormFilterInput(),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'source'         => new sfWidgetFormChoice(array('choices' => array('' => '', 'nw' => 'nw', 'br' => 'br', 'mb' => 'mb'))),
      'legacy_id'      => new sfWidgetFormFilterInput(),
      'daily_dish_tag' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'           => new sfValidatorPass(array('required' => false)),
      'slug'           => new sfValidatorPass(array('required' => false)),
      'parent_id'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'summary'        => new sfValidatorPass(array('required' => false)),
      'title_tag'      => new sfValidatorPass(array('required' => false)),
      'keywords'       => new sfValidatorPass(array('required' => false)),
      'description'    => new sfValidatorPass(array('required' => false)),
      'is_active'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'onesite_id'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sequence'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'source'         => new sfValidatorChoice(array('required' => false, 'choices' => array('nw' => 'nw', 'br' => 'br', 'mb' => 'mb'))),
      'legacy_id'      => new sfValidatorPass(array('required' => false)),
      'daily_dish_tag' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('category_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Category';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'name'           => 'Text',
      'slug'           => 'Text',
      'parent_id'      => 'Number',
      'summary'        => 'Text',
      'title_tag'      => 'Text',
      'keywords'       => 'Text',
      'description'    => 'Text',
      'is_active'      => 'Number',
      'user_id'        => 'Number',
      'onesite_id'     => 'Number',
      'sequence'       => 'Number',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
      'source'         => 'Enum',
      'legacy_id'      => 'Text',
      'daily_dish_tag' => 'Text',
    );
  }
}
