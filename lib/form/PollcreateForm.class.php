<?php

class PollcreateForm extends sfForm
{
 
  
  public function configure()
  {
    $this->setWidgets(array(
      'referrer' => new sfWidgetFormInputHidden(),
      'title'    => new sfWidgetFormInput(),
      'answer1'    => new sfWidgetFormInput(),
      'answer2'    => new sfWidgetFormInput(),
      'answer3'    => new sfWidgetFormInput(),
      'answer4'    => new sfWidgetFormInput(),
      'answer5'    => new sfWidgetFormInput(),
    ));
    
    $this->widgetSchema->setNameFormat('pollcreate[%s]');
 
    $this->setValidators(
    	array(
    	        'referrer'    => new sfValidatorPass(),
      			'title'    => new sfValidatorString(array('required' => true, 'max_length' => 300)),
      			'answer1' => new sfValidatorString(array('required' => true, 'max_length' => 200)),
      			'answer2' => new sfValidatorString(array('required' => true, 'max_length' => 200)),
      			'answer3' => new sfValidatorString(array('required' => false, 'max_length' => 200)),
      			'answer4' => new sfValidatorString(array('required' => false, 'max_length' => 200)),
      			'answer5' => new sfValidatorString(array('required' => false, 'max_length' => 200)),
    		)
    );
    
    $this->widgetSchema->setLabels(array(
	  'title'    => 'Poll Title *',
	  'answer1'   => '',
	  'answer2'   => '',
	  'answer3'   => '',
	  'answer4'   => '',
	  'answer5'   => '',
	));
	
	
	
  }
}