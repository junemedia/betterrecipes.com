<?php

/**
 * ValidatorRegServicesDisplayName
 * 
 * @package    betterrecipes
 * @subpackage validator
 * @author     Bastian Kuberek <bkuberek@resolute.com>
 */
class ValidatorRegServicesDisplayName extends sfValidatorRegex {
  
  const REGEX_SUBDIR = '/^([a-z0-9_-]+)$/i';

  /**
   * Configure Validator
   *
   * @see sfValidatorBase::configure()
   * @param array $options
   * @param array $messages
   */
  public function configure($options = array(), $messages = array()) {
    parent::configure($options, $messages);
    $this->setMessage('invalid', 'Please use only letter, numbers, dashes and underscores.');
    $this->setOption('pattern', self::REGEX_SUBDIR);
  }
}
