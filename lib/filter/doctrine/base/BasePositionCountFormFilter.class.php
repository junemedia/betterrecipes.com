<?php

/**
 * PositionCount filter form base class.
 *
 * @package    betterrecipes
 * @subpackage filter
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePositionCountFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'override_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Override'), 'add_empty' => true)),
      'count'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'override_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Override'), 'column' => 'id')),
      'count'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('position_count_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PositionCount';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'override_id' => 'ForeignKey',
      'count'       => 'Number',
    );
  }
}
