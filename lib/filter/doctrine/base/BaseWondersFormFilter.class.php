<?php

/**
 * Wonders filter form base class.
 *
 * @package    betterrecipes
 * @subpackage filter
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseWondersFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'homepage_featured' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'title'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'slot_one_title'    => new sfWidgetFormFilterInput(),
      'slot_one_url'      => new sfWidgetFormFilterInput(),
      'slot_one_img'      => new sfWidgetFormFilterInput(),
      'slot_two_title'    => new sfWidgetFormFilterInput(),
      'slot_two_url'      => new sfWidgetFormFilterInput(),
      'slot_two_img'      => new sfWidgetFormFilterInput(),
      'slot_three_title'  => new sfWidgetFormFilterInput(),
      'slot_three_url'    => new sfWidgetFormFilterInput(),
      'slot_three_img'    => new sfWidgetFormFilterInput(),
      'slot_four_title'   => new sfWidgetFormFilterInput(),
      'slot_four_url'     => new sfWidgetFormFilterInput(),
      'slot_four_img'     => new sfWidgetFormFilterInput(),
      'slot_five_title'   => new sfWidgetFormFilterInput(),
      'slot_five_url'     => new sfWidgetFormFilterInput(),
      'slot_five_img'     => new sfWidgetFormFilterInput(),
      'active'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'homepage_featured' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'title'             => new sfValidatorPass(array('required' => false)),
      'slot_one_title'    => new sfValidatorPass(array('required' => false)),
      'slot_one_url'      => new sfValidatorPass(array('required' => false)),
      'slot_one_img'      => new sfValidatorPass(array('required' => false)),
      'slot_two_title'    => new sfValidatorPass(array('required' => false)),
      'slot_two_url'      => new sfValidatorPass(array('required' => false)),
      'slot_two_img'      => new sfValidatorPass(array('required' => false)),
      'slot_three_title'  => new sfValidatorPass(array('required' => false)),
      'slot_three_url'    => new sfValidatorPass(array('required' => false)),
      'slot_three_img'    => new sfValidatorPass(array('required' => false)),
      'slot_four_title'   => new sfValidatorPass(array('required' => false)),
      'slot_four_url'     => new sfValidatorPass(array('required' => false)),
      'slot_four_img'     => new sfValidatorPass(array('required' => false)),
      'slot_five_title'   => new sfValidatorPass(array('required' => false)),
      'slot_five_url'     => new sfValidatorPass(array('required' => false)),
      'slot_five_img'     => new sfValidatorPass(array('required' => false)),
      'active'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('wonders_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Wonders';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'homepage_featured' => 'Number',
      'title'             => 'Text',
      'slot_one_title'    => 'Text',
      'slot_one_url'      => 'Text',
      'slot_one_img'      => 'Text',
      'slot_two_title'    => 'Text',
      'slot_two_url'      => 'Text',
      'slot_two_img'      => 'Text',
      'slot_three_title'  => 'Text',
      'slot_three_url'    => 'Text',
      'slot_three_img'    => 'Text',
      'slot_four_title'   => 'Text',
      'slot_four_url'     => 'Text',
      'slot_four_img'     => 'Text',
      'slot_five_title'   => 'Text',
      'slot_five_url'     => 'Text',
      'slot_five_img'     => 'Text',
      'active'            => 'Number',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
    );
  }
}
