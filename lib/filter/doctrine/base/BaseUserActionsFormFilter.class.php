<?php

/**
 * UserActions filter form base class.
 *
 * @package    betterrecipes
 * @subpackage filter
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUserActionsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'fb_user_id'     => new sfWidgetFormFilterInput(),
      'fb_object_id'   => new sfWidgetFormFilterInput(),
      'action_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Actions'), 'add_empty' => true)),
      'recipe_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Recipe'), 'add_empty' => true)),
      'poll_option_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PollOption'), 'add_empty' => true)),
      'contestant_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Contestant'), 'add_empty' => true)),
      'message'        => new sfWidgetFormFilterInput(),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'is_active'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'user_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'fb_user_id'     => new sfValidatorPass(array('required' => false)),
      'fb_object_id'   => new sfValidatorPass(array('required' => false)),
      'action_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Actions'), 'column' => 'id')),
      'recipe_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Recipe'), 'column' => 'id')),
      'poll_option_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('PollOption'), 'column' => 'id')),
      'contestant_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Contestant'), 'column' => 'id')),
      'message'        => new sfValidatorPass(array('required' => false)),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'is_active'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('user_actions_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserActions';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'user_id'        => 'ForeignKey',
      'fb_user_id'     => 'Text',
      'fb_object_id'   => 'Text',
      'action_id'      => 'ForeignKey',
      'recipe_id'      => 'ForeignKey',
      'poll_option_id' => 'ForeignKey',
      'contestant_id'  => 'ForeignKey',
      'message'        => 'Text',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
      'is_active'      => 'Number',
    );
  }
}
