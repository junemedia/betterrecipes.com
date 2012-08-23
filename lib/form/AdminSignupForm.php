<?php

/*
 * Admin Signup Form - creating new users for admin 
 * Authored by: Larry Laski
 */

class AdminSignupForm extends SignupForm
{

  public function setup()
  {
    parent::setup();
    unset($this['newsletter_ids'], $this['optin']);
  }

  public function signup()
  {
    $user = parent::signup();
    return $user;
  }

}

?>
