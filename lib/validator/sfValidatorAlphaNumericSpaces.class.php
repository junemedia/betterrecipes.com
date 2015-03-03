<?php


/**
* sfValidatorZip validates a zip code.
*
* @author Brent Shaffer <bshafs@gmail.com>
*/
class sfValidatorAlphaNumericSpaces extends sfValidatorRegex
{
  protected $_options = array('pattern' => "/^([a-zA-Z0-9\s]+)$/i");
  protected $_messages = array('invalid' => 'Alphanumeric characters only');

  public function __construct($options = array(), $messages = array())
  {
    return parent::__construct(array_merge($this->_options, $options), array_merge($this->_messages, $messages));
  }
}