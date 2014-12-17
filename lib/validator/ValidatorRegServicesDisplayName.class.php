<?php

/**
 * ValidatorRegServicesDisplayName
 * 
 * @package    betterrecipes
 * @subpackage validator
 * @author     Bastian Kuberek <bkuberek@resolute.com>
 */
class ValidatorRegServicesDisplayName extends sfValidatorRegex {
  
  //const REGEX_SUBDIR = '/^([a-z0-9_-]+)$/i';
  const REGEX_SUBDIR = '/^[A-Za-z][A-Za-z0-9_-]{2,14}$/i'; // note: Rusty Cage, had to make display name requirements less relaxed

  /**
   * Configure Validator
   *
   * @see sfValidatorBase::configure()
   * @param array $options
   * @param array $messages
   */
  public function configure($options = array(), $messages = array()) {
    parent::configure($options, $messages);
    $this->setMessage('invalid', 'Must be from 3 to 15 characters in length. Please use only letter, numbers, dashes and underscores.');
    $this->setOption('pattern', self::REGEX_SUBDIR);
  }
}
