<?php

/**
 * UserActions form base class.
 *
 * @method UserActions getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUserActionsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'user_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'fb_user_id'     => new sfWidgetFormInputText(),
      'fb_object_id'   => new sfWidgetFormInputText(),
      'action_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Actions'), 'add_empty' => false)),
      'recipe_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Recipe'), 'add_empty' => true)),
      'poll_option_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PollOption'), 'add_empty' => true)),
      'contestant_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Contestant'), 'add_empty' => true)),
      'message'        => new sfWidgetFormTextarea(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
      'is_active'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'fb_user_id'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fb_object_id'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'action_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Actions'))),
      'recipe_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Recipe'), 'required' => false)),
      'poll_option_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('PollOption'), 'required' => false)),
      'contestant_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Contestant'), 'required' => false)),
      'message'        => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'created_at'     => new sfValidatorDateTime(array('required' => false)),
      'updated_at'     => new sfValidatorDateTime(array('required' => false)),
      'is_active'      => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_actions[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserActions';
  }

}
