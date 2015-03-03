<?php

/**
 * Contestant form base class.
 *
 * @method Contestant getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseContestantForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'recipe_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Recipe'), 'add_empty' => false)),
      'contest_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Contest'), 'add_empty' => false)),
      'vote_count'   => new sfWidgetFormInputText(),
      'rank'         => new sfWidgetFormInputText(),
      'user_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'email_status' => new sfWidgetFormInputText(),
      'is_active'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'recipe_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Recipe'))),
      'contest_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Contest'))),
      'vote_count'   => new sfValidatorInteger(array('required' => false)),
      'rank'         => new sfValidatorInteger(array('required' => false)),
      'user_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'email_status' => new sfValidatorInteger(array('required' => false)),
      'is_active'    => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('contestant[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Contestant';
  }

}
