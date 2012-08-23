<?php

/**
 * Weight filter form base class.
 *
 * @package    betterrecipes
 * @subpackage filter
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseWeightFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'override_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Override'), 'add_empty' => true)),
      'item_id'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'rank'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'override_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Override'), 'column' => 'id')),
      'item_id'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'rank'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('weight_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Weight';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'override_id' => 'ForeignKey',
      'item_id'     => 'Number',
      'rank'        => 'Number',
    );
  }
}
