<?php

/**
 * ValidatorRegServicesPassword
 * 
 * @package    betterrecipes
 * @subpackage validator
 * @author     Rusty CAge <rcage@resolute.com>
 */
class ValidatorRegServicesPassword extends sfValidatorRegex {
  
  const REGEX_SUBDIR = '/^(?=.*[A-Z!@#$,.%\/^&\'"*()\-_=+`~\[\]{}?|]).{6,20}$/'; 
  
  /* note: Rusty Cage, based on the following criteria:
  At least one character must be a Capital or special character).  
  (Special characters accepted are {!"# $%&'()*+-./:;,<=>?@[]^_`{| }~})
  Minimum 6 characters, max 20 characters
  */
  
  /**
   * Configure Validator
   *
   * @see sfValidatorBase::configure()
   * @param array $options
   * @param array $messages
   */
  public function configure($options = array(), $messages = array()) {
    parent::configure($options, $messages);
    $this->setMessage('invalid', 'Must be from 6 to 20 characters in length. Must contain at least one capital letter or special character.');
    $this->setOption('pattern', self::REGEX_SUBDIR);
  }
}
