<?php

/*
 * Admin Signup Form - creating new users for admin 
 * Authored by: Larry Laski
 */

class AdminAddExistingUserForm extends sfForm {

  public function configure() {
    $this->setWidgets(array(
        'email' => new sfWidgetFormInput(),
    ));

    $this->widgetSchema->setNameFormat('adminaddexistinguserform[%s]');

    $this->widgetSchema['email']->setOption('label', 'Add Existing User');

    $this->validatorSchema['email'] = new sfValidatorEmail(array('required' => true));
  }
/*
  public function save($rest) {
    $userId = $rest->doUserSearch(1, $this->values['email'], true);
    var_dump($userId);
    exit;
    if (!empty($userId)) {
      $networkTiers = $rest->getNetworkTiers();
      foreach ($networkTiers as $nt):
        if ($nt['name'] == 'Network Moderators' || $nt['name'] == 'Network Administrators') {
          $tierIds[$nt['tier_id']] = $nt['name'];
        }
      endforeach;
      $rest->addUserToTier($userId, $adminTier, true);
    } else {
      return null;
    }
  }
*/
}

?>
