<?php

/**
 * Message form.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Bastian Kuberek <bkuberek@resolute.com>
 */
class OnesiteMessageForm extends BaseForm {
  
  public function setup() {
    
    $this->setWidgets(array(
        'user_id' => new sfWidgetFormInputHidden(),
        'recipients' => new sfWidgetFormInputHidden(),
        'subject' => new sfWidgetFormInputText(),
        'body' => new sfWidgetFormTextarea()
    ));
    
    $this->setValidators(array(
        'user_id' => new sfValidatorString(),
        'recipients' => new sfValidatorCallback(array('required' => true,'callback' => array($this, 'validateRecipientsCallback'))),
        'subject' => new sfValidatorString(),
        'body' => new sfValidatorString()
    ));
    
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    $this->widgetSchema->setNameFormat('message[%s]');
  }
  
  public function validateRecipientsCallback($validator, $value, $args) {
    return $value;
  }
  
  public function send() {
    if (!$this->isValid()) {
      throw $this->getErrorSchema();
    }
    
    $rest = $this->getOnesite()->getRest();
    $values = $this->values;
    
    $values['body'] = strip_tags($values['body'], '<b><i><s><u><em><strong>');
    
    $response = $rest->send($values['user_id'], $values['recipients'], $values['body'], $values['subject']);
  }
  
}