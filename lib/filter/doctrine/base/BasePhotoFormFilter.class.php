<?php

/**
 * Photo filter form base class.
 *
 * @package    betterrecipes
 * @subpackage filter
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePhotoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description' => new sfWidgetFormFilterInput(),
      'image'       => new sfWidgetFormFilterInput(),
      'thumb'       => new sfWidgetFormFilterInput(),
      'sequence'    => new sfWidgetFormFilterInput(),
      'recipe_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Recipe'), 'add_empty' => true)),
      'user_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'source'      => new sfWidgetFormChoice(array('choices' => array('' => '', 'nw' => 'nw', 'br' => 'br', 'mb' => 'mb'))),
      'legacy_id'   => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'        => new sfValidatorPass(array('required' => false)),
      'description' => new sfValidatorPass(array('required' => false)),
      'image'       => new sfValidatorPass(array('required' => false)),
      'thumb'       => new sfValidatorPass(array('required' => false)),
      'sequence'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'recipe_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Recipe'), 'column' => 'id')),
      'user_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'source'      => new sfValidatorChoice(array('required' => false, 'choices' => array('nw' => 'nw', 'br' => 'br', 'mb' => 'mb'))),
      'legacy_id'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('photo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Photo';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'name'        => 'Text',
      'description' => 'Text',
      'image'       => 'Text',
      'thumb'       => 'Text',
      'sequence'    => 'Number',
      'recipe_id'   => 'ForeignKey',
      'user_id'     => 'ForeignKey',
      'created_at'  => 'Date',
      'updated_at'  => 'Date',
      'source'      => 'Enum',
      'legacy_id'   => 'Text',
    );
  }
}
