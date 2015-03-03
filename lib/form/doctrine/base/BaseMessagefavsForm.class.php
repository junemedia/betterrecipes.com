<?php

/**
 * Messagefavs form base class.
 *
 * @method Messagefavs getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMessagefavsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'groupmessageid' => new sfWidgetFormInputText(),
      'messageid'      => new sfWidgetFormInputHidden(),
      'memberid'       => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'groupmessageid' => new sfValidatorInteger(),
      'messageid'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('messageid')), 'empty_value' => $this->getObject()->get('messageid'), 'required' => false)),
      'memberid'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('memberid')), 'empty_value' => $this->getObject()->get('memberid'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('messagefavs[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Messagefavs';
  }

}
