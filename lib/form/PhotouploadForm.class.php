<?php

class PhotouploadForm extends sfForm
{
  //protected static $subjects = array('Subject A', 'Subject B', 'Subject C');
 
  protected static function allowedMimes()
  {
  	return array('image/gif', 'image/jpeg', 'image/jpg', 'image/png');
  }
  
  protected static function getCategories($validate = false)
  {
  	$choices = array();
  	if (!$validate) {
  		$choices[0] = 'Select';
  	}
  	$params['excluded_cats'] = array(281, 282, 216, 217, 28, 215);
  	$categories = CategoryTable::getMainCategoryList($params);
  	foreach ($categories as $cat) {
  			$choices[$cat->getOnesiteId()] = $cat->getName();
  	}
  	return $choices;
  	
  }
  
  public function configure()
  {
    $this->setWidgets(array(
      'referrer' => new sfWidgetFormInputHidden(),
      'caption'    => new sfWidgetFormInput(),
      'categories' => new sfWidgetFormSelect(array('choices' => self::getCategories(), 'default' => 0)),
      'file'    => new sfWidgetFormInputFile(),
    ));
    
    $this->widgetSchema->setNameFormat('photoupload[%s]');
 
    $this->setValidators(
    	array(
      'referrer'    => new sfValidatorPass(),
      'caption'    => new sfValidatorString(array('required' => true)),
      'categories' => new sfValidatorChoice(array('required' => true, 'choices' => array_keys(self::getCategories(true)))),
      'file'    => new sfValidatorFile(
      									array(
      											'required' => true, 
      											'mime_types' => self::allowedMimes(), 
												'max_size' => 2097152
											 ), 
										array(
												'max_size' => 'File size of 2MB exceeded',
												'mime_types' => 'You are only allowed to upload JPG, PNG or GIF files.'
											 )
									   ),
    		)
    );
    
    $this->widgetSchema->setLabels(array(
	  'caption'    => 'Photo caption',
	  'categories'   => 'Categories',
	  'file' => 'Photo upload field',
	));
	
	
	
  }
}