<?php

/**
 * Groupmessage form base class.
 *
 * @method Groupmessage getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseGroupmessageForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'groupid'                => new sfWidgetFormInputHidden(),
      'messageid'              => new sfWidgetFormInputHidden(),
      'memberid'               => new sfWidgetFormInputText(),
      'reftypeid'              => new sfWidgetFormInputText(),
      'srcgroupid'             => new sfWidgetFormInputText(),
      'creationdt'             => new sfWidgetFormDateTime(),
      'groupmessagecategoryid' => new sfWidgetFormInputText(),
      'emailssent'             => new sfWidgetFormInputText(),
      'groupmessageid'         => new sfWidgetFormInputText(),
      'parentpath'             => new sfWidgetFormTextarea(),
      'subject'                => new sfWidgetFormInputText(),
      'messagebody'            => new sfWidgetFormTextarea(),
      'status'                 => new sfWidgetFormInputText(),
      'targetgroupid'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'groupid'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('groupid')), 'empty_value' => $this->getObject()->get('groupid'), 'required' => false)),
      'messageid'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('messageid')), 'empty_value' => $this->getObject()->get('messageid'), 'required' => false)),
      'memberid'               => new sfValidatorInteger(array('required' => false)),
      'reftypeid'              => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'srcgroupid'             => new sfValidatorInteger(array('required' => false)),
      'creationdt'             => new sfValidatorDateTime(array('required' => false)),
      'groupmessagecategoryid' => new sfValidatorInteger(array('required' => false)),
      'emailssent'             => new sfValidatorInteger(array('required' => false)),
      'groupmessageid'         => new sfValidatorInteger(),
      'parentpath'             => new sfValidatorString(),
      'subject'                => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'messagebody'            => new sfValidatorString(array('required' => false)),
      'status'                 => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'targetgroupid'          => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('groupmessage[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Groupmessage';
  }

}
