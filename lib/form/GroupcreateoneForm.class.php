<?php

class GroupcreateoneForm extends sfForm
{

	protected static function getCategories($validate = false)
  {
  	$choices = array();
  	if (!$validate) {
  		$choices[] = 'Select';
  	}
  	$params['excluded_cats'] = array(281, 282, 216, 217, 28, 215);
  	$categories = CategoryTable::getMainCategoryList($params);
  	foreach ($categories as $cat) {
  			$choices[$cat->getOnesiteId()] = $cat->getName();
  	}
  	return $choices;
  	
  }
  
  protected static function allowedMimes()
  {
  	return array('image/gif', 'image/jpeg', 'image/jpg', 'image/png');
  }
  
  public function configure()
  {
    $this->setWidgets(array(
      'name'    => new sfWidgetFormInput(),
      'categories' => new sfWidgetFormSelect(array('choices' => self::getCategories(), 'default' => 0)),
//      'description' => CKToolkit::createSimpleFormWidget(),
        'description' => new sfWidgetFormTextarea(),
      'file'    => new sfWidgetFormInputFile(),
      'default_image' => new sfWidgetFormInputHidden(),
    ));
    
    $this->widgetSchema->setNameFormat('groupcreateone[%s]');
 
    $this->setValidators(
    	array( 
      'name'    => new sfValidatorString(array('required' => true, 'max_length' => 500)),
      'categories' => new sfValidatorChoice(array('required' => true, 'choices' => array_keys(self::getCategories(true))), array('invalid' => 'Select a category from the list')),
      'description'    => new sfValidatorString(array('required' => true, 'max_length' => 500), array('max_length' => 'You have exceeded the max lenght of 500 characters.')),
      'file'    => new sfValidatorFile(
      									array(
      											'required' => false, 
      											'mime_types' => self::allowedMimes(), 
												'max_size' => 2097152
											 ), 
										array(
												'max_size' => 'File size of 2MB exceeded',
												'mime_types' => 'You are only allowed to upload JPG, PNG or GIF files.'
											 )
									   ),
	  'default_image'    => new sfValidatorString(array('required' => false)),
    		)
    );
    
    $this->widgetSchema->setLabels(array(
	  'name'    => 'Group Name',
	  'categories'   => 'Category',
	  'description' => 'Description',
	  'file' => 'ADD Group Photo',
	));
	
	
	
  }



}