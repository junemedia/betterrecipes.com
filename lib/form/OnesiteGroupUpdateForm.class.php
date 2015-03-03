<?php

class OnesiteGroupUpdateForm extends OnesiteGroupForm {
  
  public function configure() {
    $this->useFields(array(
        'group_id',
        'groupname',
        'subdir',
//        'desc_small',
        'desc_large',
        'photo'
    ));
    
    $this->widgetSchema['desc_large']->setLabel('Description');
    
    $this->widgetSchema['group_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['groupname'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['subdir'] = new sfWidgetFormInputHidden();
  }
}