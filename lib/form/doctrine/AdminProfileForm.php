<?php

class AdminProfileForm extends BaseUserForm {
  
  public function configure(){
    parent::configure();
    
    unset($this['is_premium'], $this['onesite_id'], $this['fb_id'], $this['blog_id'], $this['profile_id'], $this['display_name'], $this['subdir'], $this['email'], $this['reg_source'], $this['created_at'], $this['updated_at'], $this['source'], $this['legacy_id'], $this['avatar'], $this['about_me']);
    
    $this->setWidget('is_admin', new sfWidgetFormInput(array(), array('style' => 'display:none')));
    $this->setWidget('is_super_admin', new sfWidgetFormInput(array(), array('style' => 'display:none')));
    $this->setWidget('is_active', new sfWidgetFormInput(array(), array('style' => 'display:none')));
    $this->setWidget('is_featured_blogger', new sfWidgetFormInput(array(), array('style' => 'display:none')));
  }
  
  public function update($con = null) {
  	$object = $this->getObject();
    $object->setUpdatedAt(date('Y-m-d H:i:s'));
    $form_obj = parent::save($con);
    return $form_obj;
  }
}
?>
