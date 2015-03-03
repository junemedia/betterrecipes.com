<?php

/**
 * CategoryWonders filter form base class.
 *
 * @package    betterrecipes
 * @subpackage filter
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCategoryWondersFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'slot_one_cat_id'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'slot_one_subcat_one'    => new sfWidgetFormFilterInput(),
      'slot_one_subcat_two'    => new sfWidgetFormFilterInput(),
      'slot_one_description'   => new sfWidgetFormFilterInput(),
      'slot_two_cat_id'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'slot_two_subcat_one'    => new sfWidgetFormFilterInput(),
      'slot_two_subcat_two'    => new sfWidgetFormFilterInput(),
      'slot_two_description'   => new sfWidgetFormFilterInput(),
      'slot_three_cat_id'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'slot_three_subcat_one'  => new sfWidgetFormFilterInput(),
      'slot_three_subcat_two'  => new sfWidgetFormFilterInput(),
      'slot_three_description' => new sfWidgetFormFilterInput(),
      'slot_four_cat_id'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'slot_four_subcat_one'   => new sfWidgetFormFilterInput(),
      'slot_four_subcat_two'   => new sfWidgetFormFilterInput(),
      'slot_four_description'  => new sfWidgetFormFilterInput(),
      'is_active'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'title'                  => new sfValidatorPass(array('required' => false)),
      'slot_one_cat_id'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'slot_one_subcat_one'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'slot_one_subcat_two'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'slot_one_description'   => new sfValidatorPass(array('required' => false)),
      'slot_two_cat_id'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'slot_two_subcat_one'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'slot_two_subcat_two'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'slot_two_description'   => new sfValidatorPass(array('required' => false)),
      'slot_three_cat_id'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'slot_three_subcat_one'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'slot_three_subcat_two'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'slot_three_description' => new sfValidatorPass(array('required' => false)),
      'slot_four_cat_id'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'slot_four_subcat_one'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'slot_four_subcat_two'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'slot_four_description'  => new sfValidatorPass(array('required' => false)),
      'is_active'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('category_wonders_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CategoryWonders';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'title'                  => 'Text',
      'slot_one_cat_id'        => 'Number',
      'slot_one_subcat_one'    => 'Number',
      'slot_one_subcat_two'    => 'Number',
      'slot_one_description'   => 'Text',
      'slot_two_cat_id'        => 'Number',
      'slot_two_subcat_one'    => 'Number',
      'slot_two_subcat_two'    => 'Number',
      'slot_two_description'   => 'Text',
      'slot_three_cat_id'      => 'Number',
      'slot_three_subcat_one'  => 'Number',
      'slot_three_subcat_two'  => 'Number',
      'slot_three_description' => 'Text',
      'slot_four_cat_id'       => 'Number',
      'slot_four_subcat_one'   => 'Number',
      'slot_four_subcat_two'   => 'Number',
      'slot_four_description'  => 'Text',
      'is_active'              => 'Number',
      'created_at'             => 'Date',
      'updated_at'             => 'Date',
    );
  }
}
