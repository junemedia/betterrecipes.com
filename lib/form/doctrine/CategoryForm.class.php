<?php

/**
 * Category form.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CategoryForm extends BaseCategoryForm
{
  private $image;
  
  public function setImage($image){
    $this->image = $image;
  }
  public function getImage(){
    return $this->image;
  }
  
  public static function allowedMimeTypes(){
    return array('image/jpeg', 'image/jpg');
  }
  
  public function configure()
  {
    parent::configure();
    
    $this->validatorSchema->setOption('allow_extra_fields', true);
    
    unset ( $this['user_id'],
            $this['name'],
            $this['parent_id'], 
            $this['onesite_id'], 
            $this['created_at'], 
            $this['updated_at'],
            $this['is_active'],
            $this['source'],
            $this['legacy_id'],
            $this['sequence']
          );
    
    $this->setWidget('slug', new sfWidgetFormInputHidden());
    //$this->setWidget('is_active', new sfWidgetFormInput(array(), array('style'=>'display:none')));
    $this->setWidget('image', new sfWidgetFormInputFile());
    
    $this->validatorSchema['image'] = new sfValidatorFile(array('required' => false, 'mime_types' => self::allowedMimeTypes()), 
                                                          array('mime_types' => 'You are only allowed to upload JPG files.'));
    
    $this->widgetSchema->setNameFormat('category[%s]');
    
    $this->widgetSchema->setLabels(array(
            'description' => 'Description',
            'title_tag' => 'Title Tag',
            'summary'     => 'Meta Description',
            'keywords'    => 'Key Words',
            //'is_active'   => 'Status',
            'image'       => 'Change Photo' 
    ));   
  }  

  /*
  private function create($con = null){
    unset($this['image']);
    $this->getObject()->setUserId(sfContext::getInstance()->getUser()->getAttribute('id'));
    $this->getObject()->setSlugFromName(); //method from article
    $this->getObject()->setSource('nw');
    $this->getObject()->setCreatedAt(date('Y-m-d H:i:s'));
    $this->getObject()->setUpdatedAt(date('Y-m-d H:i:s'));
    return parent::save($con);
  }
  */
  
  public function save($con = null) { 
    unset($this['image']);
    $this->getObject()->setUpdatedAt(date('Y-m-d H:i:s'));
    $form_obj = parent::save($con);
    return $form_obj;   
  }
  
}