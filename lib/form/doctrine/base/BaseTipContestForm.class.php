<?php

/**
 * TipContest form base class.
 *
 * @method TipContest getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTipContestForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'tip_id'     => new sfWidgetFormInputHidden(),
      'contest_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'tip_id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('tip_id')), 'empty_value' => $this->getObject()->get('tip_id'), 'required' => false)),
      'contest_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('contest_id')), 'empty_value' => $this->getObject()->get('contest_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tip_contest[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TipContest';
  }

}
