<?php

/**
 * Actions filter form base class.
 *
 * @package    betterrecipes
 * @subpackage filter
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseActionsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'action_type'        => new sfWidgetFormChoice(array('choices' => array('' => '', 'recipe' => 'recipe', 'contest' => 'contest', 'poll' => 'poll'))),
      'action_description' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'action_message'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'action_type'        => new sfValidatorChoice(array('required' => false, 'choices' => array('recipe' => 'recipe', 'contest' => 'contest', 'poll' => 'poll'))),
      'action_description' => new sfValidatorPass(array('required' => false)),
      'action_message'     => new sfValidatorPass(array('required' => false)),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('actions_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Actions';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'action_type'        => 'Enum',
      'action_description' => 'Text',
      'action_message'     => 'Text',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
    );
  }
}
