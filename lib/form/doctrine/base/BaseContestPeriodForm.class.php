<?php

/**
 * ContestPeriod form base class.
 *
 * @method ContestPeriod getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseContestPeriodForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'week_start_date'      => new sfWidgetFormDate(),
      'week_end_date'        => new sfWidgetFormDate(),
      'contest_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Contest'), 'add_empty' => true)),
      'unofficial_winner_id' => new sfWidgetFormInputText(),
      'official_winner_id'   => new sfWidgetFormInputText(),
      'editor_winner_id'     => new sfWidgetFormInputText(),
      'is_active'            => new sfWidgetFormInputText(),
      'user_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
      'week_offset'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'week_start_date'      => new sfValidatorDate(),
      'week_end_date'        => new sfValidatorDate(),
      'contest_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Contest'), 'required' => false)),
      'unofficial_winner_id' => new sfValidatorInteger(array('required' => false)),
      'official_winner_id'   => new sfValidatorInteger(array('required' => false)),
      'editor_winner_id'     => new sfValidatorInteger(array('required' => false)),
      'is_active'            => new sfValidatorInteger(array('required' => false)),
      'user_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'created_at'           => new sfValidatorDateTime(array('required' => false)),
      'updated_at'           => new sfValidatorDateTime(array('required' => false)),
      'week_offset'          => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('contest_period[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ContestPeriod';
  }

}
