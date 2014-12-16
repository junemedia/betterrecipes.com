<?php

class UserProfileForm extends UserForm
{

  public function configure()
  {
    parent::configure();

    $this->useFields(array(
      'user_id',
      'profile_id',
      'avatar',
      'display_name',
      'first_name',
      'last_name',
      'email',
      'password',
      'password_again',
      'address1',
      'address2',
      'zipcode',
      'city',
      'state',
      'country',
      'about_me',
      'interests_list',
      'fb_share',
      'avatar',
      'profile_photo',
      'website_name',
      'website_address'
      ), true);
    
    $this->widgetSchema['last_name']->setAttribute('autocomplete', 'off');
    $this->widgetSchema['password']->setAttribute('autocomplete', 'off');
    $this->validatorSchema['first_name']->setOption('required', true);
    $this->validatorSchema['last_name']->setOption('required', true);
    $this->validatorSchema['address1']->setOption('required', true);
    $this->validatorSchema['address2']->setOption('required', false);
    $this->validatorSchema['zipcode']->setOption('required', true);
    $this->validatorSchema['city']->setOption('required', true);
    $this->validatorSchema['state']->setOption('required', true);
    $this->validatorSchema['country']->setOption('required', false);
  }

}