<?php

/**
 * Group filter form base class.
 *
 * @package    betterrecipes
 * @subpackage filter
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseGroupFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'blog_id'     => new sfWidgetFormFilterInput(),
      'forum_id'    => new sfWidgetFormFilterInput(),
      'category_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'add_empty' => true)),
      'group_slug'  => new sfWidgetFormFilterInput(),
      'sponsor_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sponsor'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'blog_id'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'forum_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'category_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Category'), 'column' => 'id')),
      'group_slug'  => new sfValidatorPass(array('required' => false)),
      'sponsor_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Sponsor'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('group_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Group';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'blog_id'     => 'Number',
      'forum_id'    => 'Number',
      'category_id' => 'ForeignKey',
      'group_slug'  => 'Text',
      'sponsor_id'  => 'ForeignKey',
    );
  }
}
