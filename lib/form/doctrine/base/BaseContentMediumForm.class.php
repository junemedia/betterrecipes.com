<?php

/**
 * ContentMedium form base class.
 *
 * @method ContentMedium getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseContentMediumForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'content_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Content'), 'add_empty' => false)),
      'medium_id'  => new sfWidgetFormInputText(),
      'sequence'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'content_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Content'))),
      'medium_id'  => new sfValidatorInteger(),
      'sequence'   => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('content_medium[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ContentMedium';
  }

}
