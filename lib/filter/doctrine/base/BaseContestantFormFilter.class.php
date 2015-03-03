<?php

/**
 * Contestant filter form base class.
 *
 * @package    betterrecipes
 * @subpackage filter
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseContestantFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'recipe_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Recipe'), 'add_empty' => true)),
      'contest_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Contest'), 'add_empty' => true)),
      'vote_count'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'rank'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'user_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'email_status' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_active'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'recipe_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Recipe'), 'column' => 'id')),
      'contest_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Contest'), 'column' => 'id')),
      'vote_count'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'rank'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'email_status' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_active'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('contestant_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Contestant';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'recipe_id'    => 'ForeignKey',
      'contest_id'   => 'ForeignKey',
      'vote_count'   => 'Number',
      'rank'         => 'Number',
      'user_id'      => 'ForeignKey',
      'email_status' => 'Number',
      'is_active'    => 'Number',
    );
  }
}
