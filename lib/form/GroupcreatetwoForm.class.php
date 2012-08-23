<?php

class GroupcreatetwoForm extends sfForm
{

	protected static function getFriends()
  {
  	// note, hook this up to onesite api call
  	$choices = array();
  		/*$choices[0] = 'Joey';
  		$choices[1] = 'Billy';
  		$choices[2] = 'Thomas';
  		$choices[3] = 'Toros';
  		$choices[4] = 'Tommy';
  		$choices[5] = 'Jimbo';
  		$choices[6] = 'Larry';
  		$choices[7] = 'Angela';
  		$choices[8] = 'Brian';*/
  		$rest = sfContext::getInstance()->getOnesite()->getRest();
  		// pass in logged in user's onesite ID!
  		//$f = $rest->searchFriends(sfContext::getInstance()->getUser()->getOnesiteId());
  		
  		// note: the above api call is fucked up, only returns 10 friends regardless of user; 
  		// by : Rusty Cage, 9.12.20111
  		$f = $rest->getFriends(sfContext::getInstance()->getUser()->getOnesiteId(), 1, 2000, 1);
  		if (sizeof($f)>0) {
  			//for ($i=0; $i < count($f); $i++) {
  			for ($i=0; $i < count($f['items']); $i++) {
  				//$choices[$f[$i]['friend_id'].':'.$f[$i]['display_name']] = $f[$i]['display_name'];
  				$choices[$f['items'][$i]['friend_id'].':'.$f['items'][$i]['display_name']] = $f['items'][$i]['display_name'];
  			}
  		}
  	return $choices;
  }
  
   public function configure()
  {
    $this->setWidgets(array(
      //'contacts' => new sfWidgetFormSelect(array('choices' => '', 'multiple' => true)),
      //'fb_friends' => new sfWidgetFormSelect(array('choices' => '', 'multiple' => true)),
      'friends' => new sfWidgetFormSelect(array('choices' => self::getFriends(), 'multiple' => true)),
      'friends_manual' => new sfWidgetFormTextarea(),
      'message' => new sfWidgetFormTextarea(),
    ));
    
    $this->widgetSchema->setNameFormat('groupcreatetwo[%s]');
 
    /*$this->setValidators(
    	array(
      'friends' => new sfValidatorChoice(array('required' => false, 'choices' => array_keys(self::getFriends()))),
      'friends_manual'    => new sfValidatorString(array('required' => false)),
      
	  'message'    => new sfValidatorString(array('required' => false, 'max_length' => 500)),
    		)
    );*/
    
    $this->widgetSchema->setLabels(array(
      //'contacts' => 'INVITE YOUR CONTACTS',
      //'fb_friends' => 'INVITE YOUR FACEBOOK FRIENDS',
	  'friends'    => 'INVITE YOUR BETTER RECIPES FRIENDS',
	  'friends_manual'   => 'Add friends emails, comma separated',
	  'message' => 'Enter a message',
	));
	
	
	
  }

  
  
}