<?php

/**
 * Message filter form base class.
 *
 * @package    betterrecipes
 * @subpackage filter
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMessageFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'message_type'    => new sfWidgetFormChoice(array('choices' => array('' => '', 'member' => 'member', 'non-member' => 'non-member'))),
      'recipient_email' => new sfWidgetFormFilterInput(),
      'recipient_name'  => new sfWidgetFormFilterInput(),
      'recipient_id'    => new sfWidgetFormFilterInput(),
      'comment'         => new sfWidgetFormFilterInput(),
      'sent'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'message_type'    => new sfValidatorChoice(array('required' => false, 'choices' => array('member' => 'member', 'non-member' => 'non-member'))),
      'recipient_email' => new sfValidatorPass(array('required' => false)),
      'recipient_name'  => new sfValidatorPass(array('required' => false)),
      'recipient_id'    => new sfValidatorPass(array('required' => false)),
      'comment'         => new sfValidatorPass(array('required' => false)),
      'sent'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('message_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Message';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'message_type'    => 'Enum',
      'recipient_email' => 'Text',
      'recipient_name'  => 'Text',
      'recipient_id'    => 'Text',
      'comment'         => 'Text',
      'sent'            => 'Number',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
    );
  }
}
