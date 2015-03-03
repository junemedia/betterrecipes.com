<?php

/**
 * Override form.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class OverrideForm extends BaseOverrideForm
{
  public function configure()
  {
    unset($this['module'], $this['category_id'], $this['is_global'], $this['user_id'], $this['created_at'], $this['updated_at']);
    
    $this->setWidget('start_date', new sfWidgetFormInputHidden());
    $this->setWidget('end_date', new sfWidgetFormInputHidden());
  }
  
  public function create($con=null){  
    $userId = sfContext::getInstance()->getUser()->getAttribute('id');
    $this->getObject()->setUserId($userId);
    $this->getObject()->setModule('recipe');
    $this->getObject()->setIsGlobal(1);
    $this->getObject()->setCreatedAt(date('Y-m-d H:i:s'));
    $this->getObject()->setUpdatedAt(date('Y-m-d H:i:s'));
    return parent::save($con);   
  }
  
  public function save($con=null){    
    $this->getObject()->setUpdatedAt(date('Y-m-d H:i:s'));
    return parent::save($con);   
  }
}

