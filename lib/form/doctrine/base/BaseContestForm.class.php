<?php

/**
 * Contest form base class.
 *
 * @method Contest getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseContestForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'name'              => new sfWidgetFormInputText(),
      'slug'              => new sfWidgetFormInputText(),
      'description'       => new sfWidgetFormTextarea(),
      'title_tag'         => new sfWidgetFormInputText(),
      'summary'           => new sfWidgetFormInputText(),
      'prize'             => new sfWidgetFormInputText(),
      'keywords'          => new sfWidgetFormInputText(),
      'image'             => new sfWidgetFormInputText(),
      'rules'             => new sfWidgetFormTextarea(),
      'rules_url'         => new sfWidgetFormInputText(),
      'sequence'          => new sfWidgetFormInputText(),
      'sponsor_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sponsor'), 'add_empty' => true)),
      'is_active'         => new sfWidgetFormInputText(),
      'is_open_to_public' => new sfWidgetFormInputText(),
      'user_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
      'start_date'        => new sfWidgetFormDate(),
      'end_date'          => new sfWidgetFormDate(),
      'timezone'          => new sfWidgetFormInputText(),
      'weeks'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'              => new sfValidatorString(array('max_length' => 255)),
      'slug'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description'       => new sfValidatorString(array('required' => false)),
      'title_tag'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'summary'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'prize'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'keywords'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'image'             => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'rules'             => new sfValidatorString(array('required' => false)),
      'rules_url'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'sequence'          => new sfValidatorInteger(array('required' => false)),
      'sponsor_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Sponsor'), 'required' => false)),
      'is_active'         => new sfValidatorInteger(array('required' => false)),
      'is_open_to_public' => new sfValidatorInteger(array('required' => false)),
      'user_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'created_at'        => new sfValidatorDateTime(array('required' => false)),
      'updated_at'        => new sfValidatorDateTime(array('required' => false)),
      'start_date'        => new sfValidatorDate(array('required' => false)),
      'end_date'          => new sfValidatorDate(array('required' => false)),
      'timezone'          => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'weeks'             => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('contest[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Contest';
  }

}
