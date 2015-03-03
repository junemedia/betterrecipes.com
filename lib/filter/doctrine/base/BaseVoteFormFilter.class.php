<?php

/**
 * Vote filter form base class.
 *
 * @package    betterrecipes
 * @subpackage filter
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseVoteFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'contestant_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Contestant'), 'add_empty' => true)),
      'ip_address'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_active'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'user_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'created_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'uid'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'contestant_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Contestant'), 'column' => 'id')),
      'ip_address'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_active'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'created_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'uid'           => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('vote_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Vote';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'contestant_id' => 'ForeignKey',
      'ip_address'    => 'Number',
      'is_active'     => 'Number',
      'user_id'       => 'ForeignKey',
      'created_at'    => 'Date',
      'uid'           => 'Text',
    );
  }
}
