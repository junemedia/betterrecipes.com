<?php

/**
 * Sponsor form.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SponsorForm extends BaseSponsorForm
{
  public function configure()
  {
    unset($this['logo'], $this['user_id'], $this['updated_at'], $this['created_at']);
    
    $this->setWidget('is_active', new sfWidgetFormInput(array(), array('style' => 'display:none')));
    
    $this->widgetSchema['name']->setOption('label', 'Sponsor Name');
    $this->widgetSchema['description']->setOption('label', 'Sponsor Description');
    $this->widgetSchema['url']->setOption('label', 'Link');
    $this->widgetSchema['is_active']->setOption('label', 'Status');
  }
  
  public function create($con = null){
    $user_id = sfContext::getInstance()->getUser()->getAttribute('id');
    $this->getObject()->setUserId($user_id);
    $this->getObject()->setCreatedAt(date('Y-m-d H:i:s'));
    $this->getObject()->setUpdatedAt(date('Y-m-d H:i:s'));    
    return parent::save($con);
  }
  
  public function save($con = null){
    $this->getObject()->setUpdatedAt(date('Y-m-d H:i:s'));
    return parent::save($con);
  }
}
