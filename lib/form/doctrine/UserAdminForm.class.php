<?php

/**
 * User form.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Bastian Kuberek <bkuberek@resolute.com>
 */
class UserAdminForm extends UserForm {
//
//  public function configure() {
//    parent::configure();
//    unset($this['onesite_id'], $this['profile_id'], $this['display_name'], 
//          $this['created_at'], $this['updated_at'], $this['source'], 
//          $this['is_admin'], $this['legacy_id']);   
//    
//    $this->setWidget('is_active', new sfWidgetFormInput(array(), array('style'=>'display:none')));
//    
//    $this->validatorSchema['email'] = new sfValidatorAnd(array(
//        new sfValidatorEmail(array('required' => true)), 
//        new sfValidatorCallback(array('callback' => array($this, 'checkEmailExists')))
//    ));
//  }
//  
//  public function create($con = null){
//    $this->getObject()->setCreatedAt(date('Y-m-d H:i:s'));
//    $this->getObject()->setUpdatedAt(date('Y-m-d H:i:s'));
//    $this->getObject()->setIsAdmin('1');
//    $this->getObject()->setSource('nw');
//    return parent::save($con);
//    
//  }
//  
//  public function save($con = null){
//   $this->getObject()->setUpdatedAt(date('Y-m-d H:i:s'));
//   return parent::save($con);
//  }
//  
//  public function checkEmailExists($validator, $value) {
//    
//    if (empty($value)) return $value;
//    
//    $response = $this->getOnesite()->getRpc()->emailCheck($value);
//    
//    /** @todo add userCheck/ subdirCheck */
//    
//    var_dump($response);
//    
//    if ($response['response']) {
//      throw new sfValidatorError($validator, 'The email address is already associated with another user.');
//    } else {
//      return $value;
//    }
//  }

}
