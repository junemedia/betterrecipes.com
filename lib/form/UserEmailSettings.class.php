<?php

class UserEmailSettings extends UserForm {

  public function configure() {
    parent::configure();

    $this->useFields(array(
        'user_id',
        'profile_id',
        'username',
        'email_notification'
    ), true);

    $this->widgetSchema['email_notification'] = new sfWidgetFormSelectRadio(array('choices' => $this->email_notification, 'formatter' => array($this, 'formatter')));
  }

  public function formatter($widget, $inputs) {
    $rows = array();
    foreach ($inputs as $input) {
      $rows[] = $widget->renderContentTag('td', $input['input'].$widget->getOption('label_separator').$input['label']);
    }

    return!$rows ? '' : $widget->renderContentTag('tr', implode($widget->getOption('separator'), $rows), array('class' => $widget->getOption('class')));
  }

}