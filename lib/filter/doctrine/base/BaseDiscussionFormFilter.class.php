<?php

/**
 * Discussion filter form base class.
 *
 * @package    betterrecipes
 * @subpackage filter
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDiscussionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'content_id'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'content_type'  => new sfWidgetFormChoice(array('choices' => array('' => '', 'slideshow' => 'slideshow', 'article' => 'article', 'video' => 'video', 'photo' => 'photo', 'recipe' => 'recipe', 'journal' => 'journal', 'daily-dish' => 'daily-dish', 'raves' => 'raves'))),
      'discussion_id' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'content_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'content_type'  => new sfValidatorChoice(array('required' => false, 'choices' => array('slideshow' => 'slideshow', 'article' => 'article', 'video' => 'video', 'photo' => 'photo', 'recipe' => 'recipe', 'journal' => 'journal', 'daily-dish' => 'daily-dish', 'raves' => 'raves'))),
      'discussion_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('discussion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Discussion';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'content_id'    => 'Number',
      'content_type'  => 'Enum',
      'discussion_id' => 'Number',
    );
  }
}
