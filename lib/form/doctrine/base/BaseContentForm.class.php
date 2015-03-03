<?php

/**
 * Content form base class.
 *
 * @method Content getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseContentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'type'        => new sfWidgetFormChoice(array('choices' => array('slideshow' => 'slideshow', 'article' => 'article', 'video' => 'video', 'photo' => 'photo'))),
      'title'       => new sfWidgetFormInputText(),
      'description' => new sfWidgetFormTextarea(),
      'slug'        => new sfWidgetFormInputText(),
      'keywords'    => new sfWidgetFormInputText(),
      'photo_id'    => new sfWidgetFormInputText(),
      'is_active'   => new sfWidgetFormInputText(),
      'sporsor_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sponsor'), 'add_empty' => true)),
      'user_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'type'        => new sfValidatorChoice(array('choices' => array(0 => 'slideshow', 1 => 'article', 2 => 'video', 3 => 'photo'), 'required' => false)),
      'title'       => new sfValidatorString(array('max_length' => 150)),
      'description' => new sfValidatorString(array('required' => false)),
      'slug'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'keywords'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'photo_id'    => new sfValidatorInteger(array('required' => false)),
      'is_active'   => new sfValidatorInteger(array('required' => false)),
      'sporsor_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Sponsor'), 'required' => false)),
      'user_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
      'updated_at'  => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('content[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Content';
  }

}
