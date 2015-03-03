<?php

class authComponents extends sfComponents
{

  // retrieve user info if logged in
  public function executeHeader_user_area()
  {
  	if ($this->getUser()->isAuthenticated()) {
  		$this->profile = $this->getOnesite()->getRest()->viewUserDetail($this->getUser()->getUser()->getOnesiteId());
  	} else {
  		$this->profile = array();
  	}
  }

}