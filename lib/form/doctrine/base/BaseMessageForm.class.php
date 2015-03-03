<?php

/**
 * Message form base class.
 *
 * @method Message getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMessageForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'message_type'    => new sfWidgetFormChoice(array('choices' => array('member' => 'member', 'non-member' => 'non-member'))),
      'recipient_email' => new sfWidgetFormTextarea(),
      'recipient_name'  => new sfWidgetFormTextarea(),
      'recipient_id'    => new sfWidgetFormTextarea(),
      'comment'         => new sfWidgetFormTextarea(),
      'sent'            => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'message_type'    => new sfValidatorChoice(array('choices' => array(0 => 'member', 1 => 'non-member'), 'required' => false)),
      'recipient_email' => new sfValidatorString(array('required' => false)),
      'recipient_name'  => new sfValidatorString(array('required' => false)),
      'recipient_id'    => new sfValidatorString(array('required' => false)),
      'comment'         => new sfValidatorString(array('required' => false)),
      'sent'            => new sfValidatorInteger(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(array('required' => false)),
      'updated_at'      => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('message[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Message';
  }

}
