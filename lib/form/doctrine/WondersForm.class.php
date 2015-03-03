<?php

/**
 * Wonders form.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class WondersForm extends BaseWondersForm
{
  public function configure()
  {
  	parent::configure();

    unset($this['created_at'], $this['updated_at']);
    
    $this->setWidget('slot_one_img', new sfWidgetFormInputFile());
    $this->setWidget('slot_two_img', new sfWidgetFormInputFile());
    $this->setWidget('slot_three_img', new sfWidgetFormInputFile());
    $this->setWidget('slot_four_img', new sfWidgetFormInputFile());
    $this->setWidget('slot_five_img', new sfWidgetFormInputFile());
    $this->setWidget('active', new sfWidgetFormInput(array(), array('style' => 'display:none')));
    $this->setWidget('homepage_featured', new sfWidgetFormInput(array(), array('style' => 'display:none')));
    
    $this->widgetSchema->setLabels(array(
      'homepage_featured' => 'Feature on Homepage',
      'title' => 'Wonder Title',
      'slot_one_title' => 'Slot One Title',
      'slot_one_url' => 'Slot One Url',
      'slot_one_img' => 'Slot One Image',
      'slot_two_title' => 'Slot Two Title',
      'slot_two_url' => 'Slot Two Url',
      'slot_two_img' => 'Slot Two Image',
      'slot_three_title' => 'Slot Three Title',
      'slot_three_url' => 'Slot Three Url',
      'slot_three_img' => 'Slot Three Image',
      'slot_four_title' => 'Slot Four Title',
      'slot_four_url' => 'Slot Four Url',
      'slot_four_img' => 'Slot Four Image',
      'slot_five_title' => 'Slot Five Title',
      'slot_five_url' => 'Slot Five Url',
      'slot_five_img' => 'Slot Five Image',
      'active'		  => 'Active'
    ));
    
    $file_name1 = $this->getObject()->isNew() ? time() . rand() : $this->getObject()->getId().'_'.time().rand();
    $this->validatorSchema['slot_one_img'] = new sfValidatorFileCustom(array('required' => false, 'max_size' => 2097152, 'path' => sfConfig::get('app_uploads_tmp'), 'mime_types' => 'web_images', 'file_name' => $file_name1), array('mime_types' => 'All images must be jpg, gif, tiff or png format with the max size of 2Mb', 'max_size' => 'Max file size is 2Mb'));
    
    $file_name2 = $this->getObject()->isNew() ? time() . rand() : $this->getObject()->getId().'_'.time().rand();
    $this->validatorSchema['slot_two_img'] = new sfValidatorFileCustom(array('required' => false, 'max_size' => 2097152, 'path' => sfConfig::get('app_uploads_tmp'), 'mime_types' => 'web_images', 'file_name' => $file_name2), array('mime_types' => 'All images must be jpg, gif, tiff or png format with the max size of 2Mb', 'max_size' => 'Max file size is 2Mb'));
    
    $file_name3 = $this->getObject()->isNew() ? time() . rand() : $this->getObject()->getId().'_'.time().rand();
    $this->validatorSchema['slot_three_img'] = new sfValidatorFileCustom(array('required' => false, 'max_size' => 2097152, 'path' => sfConfig::get('app_uploads_tmp'), 'mime_types' => 'web_images', 'file_name' => $file_name3), array('mime_types' => 'All images must be jpg, gif, tiff or png format with the max size of 2Mb', 'max_size' => 'Max file size is 2Mb'));
    
    $file_name4 = $this->getObject()->isNew() ? time() . rand() : $this->getObject()->getId().'_'.time().rand();
    $this->validatorSchema['slot_four_img'] = new sfValidatorFileCustom(array('required' => false, 'max_size' => 2097152, 'path' => sfConfig::get('app_uploads_tmp'), 'mime_types' => 'web_images', 'file_name' => $file_name4), array('mime_types' => 'All images must be jpg, gif, tiff or png format with the max size of 2Mb', 'max_size' => 'Max file size is 2Mb'));
    
    $file_name5 = $this->getObject()->isNew() ? time() . rand() : $this->getObject()->getId().'_'.time().rand();
    $this->validatorSchema['slot_five_img'] = new sfValidatorFileCustom(array('required' => false, 'max_size' => 2097152, 'path' => sfConfig::get('app_uploads_tmp'), 'mime_types' => 'web_images', 'file_name' => $file_name5), array('mime_types' => 'All images must be jpg, gif, tiff or png format with the max size of 2Mb', 'max_size' => 'Max file size is 2Mb'));

  }
  
  public function create($con = null)
  {

    $object = $this->getObject();
    $object->setCreatedAt(date('Y-m-d H:i:s'));
    $object->setUpdatedAt(date('Y-m-d H:i:s'));

    $form_obj = parent::save($con);
    
    if (!is_null($this->values['slot_one_img'])):
      $object->processFileOne();
    endif;
    
    if (!is_null($this->values['slot_two_img'])):
      $object->processFileTwo();
    endif;
    
    if (!is_null($this->values['slot_three_img'])):
      $object->processFileThree();
    endif;
    
    if (!is_null($this->values['slot_four_img'])):
      $object->processFileFour();
    endif;
    
    if (!is_null($this->values['slot_five_img'])):
      $object->processFileFive();
    endif;
    
    return $form_obj;
  }

  public function update($con = null)
  {
    $object = $this->getObject();
    $object->setUpdatedAt(date('Y-m-d H:i:s'));
    $form_obj = parent::save($con);
    
    if (!is_null($this->values['slot_one_img'])):
      $object->processFileOne();
    endif;
    
    if (!is_null($this->values['slot_two_img'])):
      $object->processFileTwo();
    endif;
    
    if (!is_null($this->values['slot_three_img'])):
      $object->processFileThree();
    endif;
    
    if (!is_null($this->values['slot_four_img'])):
      $object->processFileFour();
    endif;
    
    if (!is_null($this->values['slot_five_img'])):
      $object->processFileFive();
    endif;
    
    return $form_obj;
  }

}
