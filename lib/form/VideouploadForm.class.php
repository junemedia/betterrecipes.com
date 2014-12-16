<?php

class VideouploadForm extends sfForm
{
 
  protected static function allowedMimes()
  {
  	return array('video/mpeg', 'video/mp4', 'video/quicktime', 'video/x-flv', 'video/x-ms-wmv', 'video/x-msvideo');
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
    
    $this->widgetSchema->setNameFormat('videoupload[%s]');
 
    $this->setValidators(
    	array(
      'caption'    => new sfValidatorString(array('required' => true)),
      'referrer'    => new sfValidatorPass(),
      'categories' => new sfValidatorChoice(array('required' => true, 'choices' => array_keys(self::getCategories(true)))),
      'file'    => new sfValidatorFile(
      									array(
      											'required' => true, 
      											'mime_types' => self::allowedMimes(), 
												'max_size' => 100097152
											 ), 
										array(
												'max_size' => 'File size of 100MB exceeded',
												'mime_types' => 'You are only allowed to upload the following file types: mpeg, mp4, mov, flv, wmv and avi.'
											 )
									   ),
    		)
    );
    
    $this->widgetSchema->setLabels(array(
	  'caption'    => 'Video caption',
	  'categories'   => 'Categories',
	  'file' => 'Video upload field',
	));
	
	
	
  }
}