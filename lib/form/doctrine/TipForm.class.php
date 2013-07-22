<?php

/**
 * Tip form.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TipForm extends BaseTipForm
{
  public function configure()
  {
  	unset($this['updated_by'], $this['updated_at']);
    //$this->setWidget('contest_id', new sfWidgetFormChoice(array('choices' => ContestTable::getContestsAndIds() )));

	//$this->validatorSchema['contest_id'] = new sfValidatorChoice(array('choices' => ContestTable::getContestsAndIds(), 'required' => false));

	//$this->widgetSchema['contest_id']->setOption('label', 'Contest');
    $this->widgetSchema['title']->setOption('label', 'Title');
    $this->widgetSchema['url']->setOption('label', 'Url');
  }

  public function create($con = null)
  {
    $user_id = sfContext::getInstance()->getUser()->getAttribute('id');

    $object = $this->getObject();
    $object->setUpdatedBy($user_id);
    $object->setUpdatedAt(date('Y-m-d H:i:s'));

    $form_obj = self::save($con);
    return $form_obj;
  }

  public function save($con = null)
  {
    $object = $this->getObject();
    $form_obj = parent::save($con);
    return $form_obj;
  }
}
