<?php

/**
 * Collection form base class.
 *
 * @method Collection getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCollectionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'name'            => new sfWidgetFormInputText(),
      'description'     => new sfWidgetFormTextarea(),
      'tags'            => new sfWidgetFormInputText(),
      'user_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'sequence'        => new sfWidgetFormInputText(),
      'recommendations' => new sfWidgetFormInputText(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'created_at'      => new sfWidgetFormDateTime(),
      'source'          => new sfWidgetFormChoice(array('choices' => array('nw' => 'nw', 'br' => 'br', 'mb' => 'mb'))),
      'legacy_id'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'            => new sfValidatorString(array('max_length' => 60)),
      'description'     => new sfValidatorString(array('required' => false)),
      'tags'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'user_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'sequence'        => new sfValidatorInteger(array('required' => false)),
      'recommendations' => new sfValidatorInteger(array('required' => false)),
      'updated_at'      => new sfValidatorDateTime(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(array('required' => false)),
      'source'          => new sfValidatorChoice(array('choices' => array(0 => 'nw', 1 => 'br', 2 => 'mb'), 'required' => false)),
      'legacy_id'       => new sfValidatorString(array('max_length' => 20, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('collection[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Collection';
  }

}
