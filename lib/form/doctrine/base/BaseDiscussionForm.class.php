<?php

/**
 * Discussion form base class.
 *
 * @method Discussion getObject() Returns the current form's model object
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDiscussionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'content_id'    => new sfWidgetFormInputText(),
      'content_type'  => new sfWidgetFormChoice(array('choices' => array('slideshow' => 'slideshow', 'article' => 'article', 'video' => 'video', 'photo' => 'photo', 'recipe' => 'recipe', 'journal' => 'journal', 'daily-dish' => 'daily-dish', 'raves' => 'raves'))),
      'discussion_id' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'content_id'    => new sfValidatorInteger(),
      'content_type'  => new sfValidatorChoice(array('choices' => array(0 => 'slideshow', 1 => 'article', 2 => 'video', 3 => 'photo', 4 => 'recipe', 5 => 'journal', 6 => 'daily-dish', 7 => 'raves'), 'required' => false)),
      'discussion_id' => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('discussion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Discussion';
  }

}
