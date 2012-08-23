<?php

/**
 * SlideshowMedium filter form base class.
 *
 * @package    betterrecipes
 * @subpackage filter
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSlideshowMediumFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'slideshow_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Slideshow'), 'add_empty' => true)),
      'medium_type'  => new sfWidgetFormChoice(array('choices' => array('' => '', 'recipe-photo' => 'recipe-photo'))),
      'medium_id'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sequence'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'name'         => new sfWidgetFormFilterInput(),
      'content'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'slideshow_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Slideshow'), 'column' => 'id')),
      'medium_type'  => new sfValidatorChoice(array('required' => false, 'choices' => array('recipe-photo' => 'recipe-photo'))),
      'medium_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sequence'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'name'         => new sfValidatorPass(array('required' => false)),
      'content'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('slideshow_medium_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'SlideshowMedium';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'slideshow_id' => 'ForeignKey',
      'medium_type'  => 'Enum',
      'medium_id'    => 'Number',
      'sequence'     => 'Number',
      'name'         => 'Text',
      'content'      => 'Text',
    );
  }
}
