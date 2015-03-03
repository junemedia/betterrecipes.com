<?php

/**
 * SlideshowMedium form base class.
 *
 * @method SlideshowMedium getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSlideshowMediumForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'slideshow_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Slideshow'), 'add_empty' => false)),
      'medium_type'  => new sfWidgetFormChoice(array('choices' => array('recipe-photo' => 'recipe-photo'))),
      'medium_id'    => new sfWidgetFormInputText(),
      'sequence'     => new sfWidgetFormInputText(),
      'name'         => new sfWidgetFormInputText(),
      'content'      => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'slideshow_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Slideshow'))),
      'medium_type'  => new sfValidatorChoice(array('choices' => array(0 => 'recipe-photo'), 'required' => false)),
      'medium_id'    => new sfValidatorInteger(),
      'sequence'     => new sfValidatorInteger(),
      'name'         => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'content'      => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('slideshow_medium[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'SlideshowMedium';
  }

}
