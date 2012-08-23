<?php

/**
 * CategoryWonders form.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CategoryWondersForm extends BaseCategoryWondersForm
{
  public function configure()
  {
  	parent::configure();

    unset($this['created_at'], $this['updated_at']);
    
    $this->widgetSchema->setLabels(array(
      'title' => 'Category Wonder Title',
      'slot_one_description' => 'Slot One Description',
      'slot_two_cat_id' => 'Slot Two Category',
      'slot_two_subcat_one' => 'Slot Two Sub Category Choice One',
      'slot_two_subcat_two' => 'Slot Two Sub Category Choice Two',
      'slot_two_description' => 'Slot Two Description',
      'slot_three_cat_id' => 'Slot Three Category',
      'slot_three_subcat_one' => 'Slot Three Sub Category Choice One',
      'slot_three_subcat_two' => 'Slot Three Sub Category Choice Two',
      'slot_three_description' => 'Slot Three Description',
      'slot_four_cat_id' => 'Slot Four Category',
      'slot_four_subcat_one' => 'Slot Four Sub Category Choice One',
      'slot_four_subcat_two' => 'Slot Four Sub Category Choice Two',
      'slot_four_description' => 'Slot Four Description',
      'is_active'		 	=> 'Active'
    ));
    
    if ($this->isNew()) {
    	
    	$this->setWidget('slot_one_cat_id', new sfWidgetFormChoice(array('label' => 'Slot One Category', 'choices' => $this->getMainCategoryOptions()), array('onchange' => 'updateSubcat(1, this.value)')));
    	$this->setWidget('slot_one_subcat_one', new sfWidgetFormChoice(array('label' => 'Sub Category Choice 1', 'choices' => array('' => 'Select sub category'))));
    	$this->setWidget('slot_one_subcat_two', new sfWidgetFormChoice(array('label' => 'Sub Category Choice 2', 'choices' => array('' => 'Select sub category'))));
    	
    	$this->setWidget('slot_two_cat_id', new sfWidgetFormChoice(array('label' => 'Slot Two Category', 'choices' => $this->getMainCategoryOptions()), array('onchange' => 'updateSubcat(2, this.value)')));
    	$this->setWidget('slot_two_subcat_one', new sfWidgetFormChoice(array('label' => 'Sub Category Choice 1', 'choices' => array('' => 'Select sub category'))));
    	$this->setWidget('slot_two_subcat_two', new sfWidgetFormChoice(array('label' => 'Sub Category Choice 2', 'choices' => array('' => 'Select sub category'))));
    	
    	$this->setWidget('slot_three_cat_id', new sfWidgetFormChoice(array('label' => 'Slot Three Category', 'choices' => $this->getMainCategoryOptions()), array('onchange' => 'updateSubcat(3, this.value)')));
    	$this->setWidget('slot_three_subcat_one', new sfWidgetFormChoice(array('label' => 'Sub Category Choice 1', 'choices' => array('' => 'Select sub category'))));
    	$this->setWidget('slot_three_subcat_two', new sfWidgetFormChoice(array('label' => 'Sub Category Choice 2', 'choices' => array('' => 'Select sub category'))));
    	
    	$this->setWidget('slot_four_cat_id', new sfWidgetFormChoice(array('label' => 'Slot Four Category', 'choices' => $this->getMainCategoryOptions()), array('onchange' => 'updateSubcat(4, this.value)')));
    	$this->setWidget('slot_four_subcat_one', new sfWidgetFormChoice(array('label' => 'Sub Category Choice 1', 'choices' => array('' => 'Select sub category'))));
    	$this->setWidget('slot_four_subcat_two', new sfWidgetFormChoice(array('label' => 'Sub Category Choice 2', 'choices' => array('' => 'Select sub category'))));
    	
    	
    	
    	//$this->setDefault('slot_one_cat_id','7');
    } else {
	    
	    $this->setWidget('slot_one_cat_id', new sfWidgetFormChoice(array('label' => 'Slot One Category', 'choices' => $this->getMainCategoryOptions()), array('onchange' => 'updateSubcat(1, this.value)')));
	    $this->setWidget('slot_one_subcat_one', new sfWidgetFormChoice(array('label' => 'Sub Category Choice 1', 'choices' => $this->getSubCategoryOptions($this->getObject()->getSlotOneCatId()))));
    	$this->setWidget('slot_one_subcat_two', new sfWidgetFormChoice(array('label' => 'Sub Category Choice 2', 'choices' => $this->getSubCategoryOptions($this->getObject()->getSlotOneCatId()))));
	    $this->setDefault('slot_one_cat_id', $this->getObject()->getSlotOneCatId());
	    if ( is_numeric($this->getObject()->getSlotOneSubcatOne()) ) {
			$this->setDefault('slot_one_subcat_one', $this->getObject()->getSlotOneSubcatOne());    
	    }
	    if ( is_numeric($this->getObject()->getSlotOneSubcatTwo()) ) {
			$this->setDefault('slot_one_subcat_two', $this->getObject()->getSlotOneSubcatTwo());    
	    }
	    
	    $this->setWidget('slot_two_cat_id', new sfWidgetFormChoice(array('label' => 'Slot Two Category', 'choices' => $this->getMainCategoryOptions()), array('onchange' => 'updateSubcat(2, this.value)')));
	    $this->setWidget('slot_two_subcat_one', new sfWidgetFormChoice(array('label' => 'Sub Category Choice 1', 'choices' => $this->getSubCategoryOptions($this->getObject()->getSlotTwoCatId()))));
    	$this->setWidget('slot_two_subcat_two', new sfWidgetFormChoice(array('label' => 'Sub Category Choice 2', 'choices' => $this->getSubCategoryOptions($this->getObject()->getSlotTwoCatId()))));
	    $this->setDefault('slot_two_cat_id', $this->getObject()->getSlotTwoCatId());
	    if ( is_numeric($this->getObject()->getSlotTwoSubcatOne()) ) {
			$this->setDefault('slot_two_subcat_one', $this->getObject()->getSlotTwoSubcatOne());    
	    }
	    if ( is_numeric($this->getObject()->getSlotTwoSubcatTwo()) ) {
			$this->setDefault('slot_two_subcat_two', $this->getObject()->getSlotTwoSubcatTwo());    
	    }
	    
	    $this->setWidget('slot_three_cat_id', new sfWidgetFormChoice(array('label' => 'Slot Three Category', 'choices' => $this->getMainCategoryOptions()), array('onchange' => 'updateSubcat(3, this.value)')));
	    $this->setWidget('slot_three_subcat_one', new sfWidgetFormChoice(array('label' => 'Sub Category Choice 1', 'choices' => $this->getSubCategoryOptions($this->getObject()->getSlotThreeCatId()))));
    	$this->setWidget('slot_three_subcat_two', new sfWidgetFormChoice(array('label' => 'Sub Category Choice 2', 'choices' => $this->getSubCategoryOptions($this->getObject()->getSlotThreeCatId()))));
	    $this->setDefault('slot_three_cat_id', $this->getObject()->getSlotThreeCatId());
	    if ( is_numeric($this->getObject()->getSlotThreeSubcatOne()) ) {
			$this->setDefault('slot_three_subcat_one', $this->getObject()->getSlotThreeSubcatOne());    
	    }
	    if ( is_numeric($this->getObject()->getSlotThreeSubcatTwo()) ) {
			$this->setDefault('slot_three_subcat_two', $this->getObject()->getSlotThreeSubcatTwo());    
	    }
	    
	    $this->setWidget('slot_four_cat_id', new sfWidgetFormChoice(array('label' => 'Slot Four Category', 'choices' => $this->getMainCategoryOptions()), array('onchange' => 'updateSubcat(4, this.value)')));
	    $this->setWidget('slot_four_subcat_one', new sfWidgetFormChoice(array('label' => 'Sub Category Choice 1', 'choices' => $this->getSubCategoryOptions($this->getObject()->getSlotFourCatId()))));
    	$this->setWidget('slot_four_subcat_two', new sfWidgetFormChoice(array('label' => 'Sub Category Choice 2', 'choices' => $this->getSubCategoryOptions($this->getObject()->getSlotFourCatId()))));
	    $this->setDefault('slot_four_cat_id', $this->getObject()->getSlotFourCatId());
	    if ( is_numeric($this->getObject()->getSlotFourSubcatOne()) ) {
			$this->setDefault('slot_four_subcat_one', $this->getObject()->getSlotFourSubcatOne());    
	    }
	    if ( is_numeric($this->getObject()->getSlotFourSubcatTwo()) ) {
			$this->setDefault('slot_four_subcat_two', $this->getObject()->getSlotFourSubcatTwo());    
	    }
	    
    } 
    $this->setWidget('is_active', new sfWidgetFormInput(array(), array('style' => 'display:none')));

  }
  
  protected function getMainCategoryOptions()
  {
    $params['excluded_cats'] = CategoryTable::$excluded_cats;
    $categories = CategoryTable::getMainCategoryList($params);
    $options[''] = 'Select main category';
    foreach ($categories as $category) {
      $options[$category->getId()] = $category->getName();
    }
    return $options;
  }
  
  protected function getSubCategoryOptions($main_category_id)
  {
    $categories = CategoryTable::getSubCategoryList($main_category_id);
    foreach ($categories as $category) {
      $options[$category->getId()] = $category->getName();
    }
    return $options;
  }
  
  public function create($con = null)
  {

    $object = $this->getObject();
    $object->setCreatedAt(date('Y-m-d H:i:s'));
    $object->setUpdatedAt(date('Y-m-d H:i:s'));

    $form_obj = parent::save($con);
    
    return $form_obj;
  }

  public function update($con = null)
  {
    $object = $this->getObject();
    $object->setUpdatedAt(date('Y-m-d H:i:s'));
    $form_obj = parent::save($con);
    
    return $form_obj;
  }


}
