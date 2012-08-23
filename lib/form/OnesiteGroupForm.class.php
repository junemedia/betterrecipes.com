<?php

class OnesiteGroupForm extends BaseForm {

  protected $join_method = array(
      'open' => 'open',
      'invite' => 'invite',
      'screen' => 'screen',
      'group_suspended' => 'group_suspended'
  );
  protected $forum_access = array(
      'private' => 'private',
      'topic_preview' => 'topic_preview',
      'outside_read' => 'outside_read',
      'outside_post' => 'outside_post'
  );
  protected $group_access = array(
      'private' => 'private',
      'semi_private' => 'semi_private',
      'public' => 'public'
  );
  protected $allow_member_content_association = array(
      'never' => 'never',
      'moderators' => 'moderators',
      'screen' => 'screen',
      'allow' => 'allow'
  );

  /**
   * Constructor.

   * @see sfForm
   */
  public function __construct($defaults = array(), $options = array(), $CSRFSecret = null) {
    $this->is_new = empty($defaults['group_id']) ? true : false;
    
    if (isset($defaults['desc_full'])) {
      $defaults['desc_large'] = $defaults['desc_full'];
    }
    
    parent::__construct($defaults, $options, $CSRFSecret);
  }

  /**
   * @return boolean
   */
  public function isNew() {
    return $this->is_new;
  }

  public function setup() {
    $this->setWidgets(array(
        'group_id' => new sfWidgetFormInputHidden(),
        'groupname' => new sfWidgetFormInputText(),
        'display_name' => new sfWidgetFormInputText(),
        'subdir' => new sfWidgetFormInputText(),
        'desc_small' => new sfWidgetFormTextarea(),
//        'desc_large' => CKToolkit::createSimpleFormWidget(),
        'desc_large' => new sfWidgetFormTextarea(),
        'join_method' => new sfWidgetFormChoice(array('choices' => $this->join_method)),
        'forum_access' => new sfWidgetFormChoice(array('choices' => $this->forum_access)),
        'group_access' => new sfWidgetFormChoice(array('choices' => $this->group_access)),
        'category_id' => new sfWidgetFormInputText(),
        'master_category' => new sfWidgetFormInputText(),
        'owner_id' => new sfWidgetFormInputText(),
        'featured' => new sfWidgetFormChoice(array('choices' => array(0 => 'no', 1 => 'yes'))),
        'allow_member_content_association' => new sfWidgetFormChoice(array('choices' => $this->allow_member_content_association)),
    ));

    $this->widgetSchema->setLabels(array(
        'group_id' => 'Group ID',
        'groupname' => 'Group Name',
        'display_name' => 'Display Name',
        'subdir' => 'Permalink',
        'desc_small' => 'Short Description',
        'desc_large' => 'Full Description',
        'join_method' => 'Join Method',
        'forum_access' => 'Forum Access',
        'group_access' => 'Group Access',
        'category_id' => 'Category',
        'master_category' => 'Master Category',
        'owner_id' => 'Owner',
        'featured' => 'Is Featured?',
        'allow_member_content_association' => 'Allow Memeber COntent Association',
    ));

    $this->setValidators(array(
        'group_id' => new sfValidatorInteger(),
        'groupname' => new sfValidatorString(array('max_length' => 128)),
        'display_name' => new sfValidatorString(array('max_length' => 75)),
        'subdir' => new ValidatorOnesiteSubdir(array('max_length' => 100)),
        'desc_small' => new sfValidatorString(array('max_length' => 150)),
        'desc_large' => new sfValidatorString(array('required' => true, 'max_length' => 500), array('max_length' => 'You have exceeded the max lenght of 500 characters.')),
        'join_method' => new sfValidatorAnd(array(
            new sfValidatorChoice(array('required' => false, 'choices' => array_keys($this->join_method))),
            new sfValidatorInteger(array('required' => false))
        )),
        'forum_access' => new sfValidatorAnd(array(
            new sfValidatorChoice(array('required' => false, 'choices' => array_keys($this->forum_access))),
            new sfValidatorInteger(array('required' => false))
        )),
        'group_access' => new sfValidatorAnd(array(
            new sfValidatorChoice(array('required' => false, 'choices' => array_keys($this->group_access))),
            new sfValidatorInteger(array('required' => false))
        )),
        'category_id' => new sfValidatorInteger(array('required' => false)),
        'master_category' => new sfValidatorInteger(array('required' => false)),
        'owner_id' => new sfValidatorInteger(array('required' => false)),
        'featured' => new sfValidatorAnd(array(
            new sfValidatorChoice(array('required' => false, 'choices' => array(0, 1))),
            new sfValidatorInteger(array('required' => false))
        )),
        'allow_member_content_association' => new sfValidatorAnd(array(
            new sfValidatorChoice(array('required' => false, 'choices' => array_keys($this->allow_member_content_association))),
            new sfValidatorString(array('required' => false))
        )),
    ));

    $this->widgetSchema['photo'] = new sfWidgetFormInputFileEditable(array(
                'label' => 'Photo',
                'file_src' => $this->getDefault('photo'),
                'is_image' => true,
                'edit_mode' => true,
                'template' => '<fieldset class="edit_img pl20">%file%<fieldset>%input%</fieldset></fieldset>',
//                'template' => '<fieldset class="edit_img pl20">%file%<fieldset>%input%</fieldset><fieldset>%delete% %delete_label%</fieldset></fieldset>',
            ));

    $this->validatorSchema['photo'] = new sfValidatorFile(array(
                'required' => false,
                'path' => sfConfig::get('sf_upload_dir').'/tmp',
                'mime_types' => 'web_images',
            ));
    $this->validatorSchema['photo_delete'] = new sfValidatorPass();

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    $this->widgetSchema->setNameFormat('group[%s]');
  }

  public function save() {
    if (!$this->isValid()) {
      throw $this->getErrorSchema();
    }

    $rpc = $this->getOnesite()->getRpc();
    $rest = $this->getOnesite()->getRest();
    $values = $this->values;

    if (!empty($values['photo'])) {
      $photo = $values['photo'];
      $photo->save();

      $photo_url = str_replace(realpath(sfConfig::get('sf_upload_dir').'/tmp'), UrlToolkit::getDomainUri().'/uploads/tmp', realpath($photo->getSavedName()));
      
//      echo $photo_url; die;

      $response = $rest->setProfilePhoto($this->defaults['blog_id'], 'group', $photo_url);
    }

    unset($values['photo'], $values['photo_delete']);

    $response = $rpc->groupUpdate($values);

    if ($response['code'] == 0) {

//      $group = GroupTable::getInstance()->findById($response['response']);
//
//      if (!$group) {
//        $group = new Group();
//        
//        $group_data = $rest->viewGroup($response['response']);
//        
//        $group->fromArray($group_data);
//      }
//      
//      $group->save();
      
      sfContext::getInstance()->getUser()->setAttribute('clear_group_cache', true);

      return true;
    } else {
      $message = 'There was an error communicating with the server. We have been notified of the error and will address it asap. Please try again later.';
      $field = null;

      if (isset($response['error'])) {
        $message = 'Error ('.$response['error']['code'].'): '.$response['error']['msg'];

//        if ($response['error']['code'] == 1005) {
//          $message = 'Not Available. Please choose a different value.';
//          $field = 'display_name';
//        } elseif ($response['error']['code'] == 1007) {
//          $message = $response['error']['msg'];
//        }
      }

      $this->errorSchema->addError(new sfValidatorError($this->validatorSchema, $message, array('field' => $field)), $field);

      return false;
    }
  }

}