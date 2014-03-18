<?php

/**
 * User form.
 * 
 * This form manages all of user data. It will persist data to the appropriate API,
 * save the User object to the database and return the User object upon success.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Bastian Kuberek <bkuberek@resolute.com>
 */
class UserForm extends BaseForm
{
  protected $state_list = array(
    'AL' => "Alabama",
    'AK' => "Alaska",
    'AZ' => "Arizona",
    'AR' => "Arkansas",
    'CA' => "California",
    'CO' => "Colorado",
    'CT' => "Connecticut",
    'DE' => "Delaware",
    'DC' => "District Of Columbia",
    'FL' => "Florida",
    'GA' => "Georgia",
    'HI' => "Hawaii",
    'ID' => "Idaho",
    'IL' => "Illinois",
    'IN' => "Indiana",
    'IA' => "Iowa",
    'KS' => "Kansas",
    'KY' => "Kentucky",
    'LA' => "Louisiana",
    'ME' => "Maine",
    'MD' => "Maryland",
    'MA' => "Massachusetts",
    'MI' => "Michigan",
    'MN' => "Minnesota",
    'MS' => "Mississippi",
    'MO' => "Missouri",
    'MT' => "Montana",
    'NE' => "Nebraska",
    'NV' => "Nevada",
    'NH' => "New Hampshire",
    'NJ' => "New Jersey",
    'NM' => "New Mexico",
    'NY' => "New York",
    'NC' => "North Carolina",
    'ND' => "North Dakota",
    'OH' => "Ohio",
    'OK' => "Oklahoma",
    'OR' => "Oregon",
    'PA' => "Pennsylvania",
    'RI' => "Rhode Island",
    'SC' => "South Carolina",
    'SD' => "South Dakota",
    'TN' => "Tennessee",
    'TX' => "Texas",
    'UT' => "Utah",
    'VT' => "Vermont",
    'VA' => "Virginia",
    'WA' => "Washington",
    'WV' => "West Virginia",
    'WI' => "Wisconsin",
    'WY' => "Wyoming"
  );
  protected $country_list = array(
    'US' => 'UNITED STATES',
    'CA' => 'CANADA',
    '' => 'OTHER'
  );

  /**
   * @todo before using the timezone choices, the choice has to be converted to an integer (offset in hours from UTC)
   * @fixme this appears to be wrong. It doesnt account for Daylight savings either.
   * @var array
   */
  protected $is_new;
  protected $user;

  /**
   *
   * @param type $defaults
   * @param type $options
   * @param type $CSRFSecret 
   */
  public function __construct($defaults = array(), $options = array(), $CSRFSecret = null)
  {
    $this->user = UserTable::getInstance()->find($defaults['user_id']);
    parent::__construct($defaults, $options, $CSRFSecret);
  }

  /**
   * @return boolean
   */
  public function isNew()
  {
    return $this->is_new;
  }

  /**
   * @return User
   */
  public function getUser()
  {
    return $this->user;
  }

  public function setup()
  {
    parent::configure();

    $years = range(date('Y') - 105, date('Y') - 5);
    $this->years = array_combine($years, $years);

    $this->setWidgets(array(
      'user_id' => new sfWidgetFormInputHidden(),
      'profile_id' => new sfWidgetFormInputHidden(),
      'avatar' => new sfWidgetFormInputHidden(),
      'fb_share' => new sfWidgetFormInputText(),
      'first_name' => new sfWidgetFormInputText(),
      'last_name' => new sfWidgetFormInputText(),
      'display_name' => new sfWidgetFormInputText(),
      'email' => new sfWidgetFormInputText(),
      'password' => new sfWidgetFormInputPassword(),
      'phone' => new sfWidgetFormInputText(),
      'address1' => new sfWidgetFormInputText(),
      'address2' => new sfWidgetFormInputText(),
      'city' => new sfWidgetFormInputText(),
      'state' => new sfWidgetFormChoice(array('choices' => $this->state_list)),
      'zipcode' => new sfWidgetFormInputText(),
      'country' => new sfWidgetFormChoice(array('choices' => $this->country_list)),
      'personal_quote' => new sfWidgetFormTextarea(),
      'about_me' => new sfWidgetFormTextarea(),
      'interests_list' => new sfWidgetFormDoctrineChoice(array('model' => 'Interest', 'multiple' => true, 'expanded' => true)),
      'profile_photo' => new sfWidgetFormInputFile(),
      'website_name' => new sfWidgetFormInputText(),
      'website_address' => new sfWidgetFormInputText(),
    ));

    $this->widgetSchema['email']->setAttributes(array("autocomplete" => "off"));



    if (($interests = $this->user->getInterests()) && $interests->count()) {
      foreach ($interests as $interest) {
        $this->defaults['interests_list'][] = $interest->getId();
      }
    }

    $this->widgetSchema['country']->setDefault('US');

    $this->widgetSchema->setLabels(array(
      'user_id' => 'User ID',
      'profile_id' => 'Profile ID',
      'fb_share' => 'Socialize',
      'avatar' => 'Avatar',
      'first_name' => 'First Name',
      'last_name' => 'Last Name',
      'display_name' => 'Display Name',
      'email' => 'Email',
      'password' => 'Password',
      'address1' => 'Address',
      'address2' => 'Address 2',
      'city' => 'City',
      'state' => 'State',
      'zipcode' => 'Zip Code',
      'country' => 'Country',
      'about_me' => 'About Me',
      'interests_list' => 'Areas of Interest',
      'website_name' => 'Website Name',
      'website_address' => 'Website Address',
    ));

    $this->setValidators(array(
      'user_id' => new sfValidatorInteger(),
      'profile_id' => new sfValidatorString(array('max_length' => 40, 'required' => false), array('max_length' => 'Max 40 characters')),
      'avatar' => new sfValidatorString(array('max_length' => 50, 'required' => false), array('max_length' => 'Max 50 characters')),
      'fb_share' => new sfValidatorInteger(),
      'password' => new sfValidatorRegex( array('required' => false, 'pattern' => '/^(?=.*[A-Z!@#$,.%\/^&\'"*()\-_=+`~\[\]{}?|]).{6,20}$/'), array('invalid' => 'Must be from 6 to 20 characters in length. Must contain at least one capital letter or special character.') ),
      'email' => new sfValidatorEmail(array('max_length' => 50, 'required' => true), array('max_length' => 'Max 50 characters')),
      'first_name' => new sfValidatorString(array('max_length' => 12, 'required' => true), array('max_length' => 'Max 12 characters')),
      'last_name' => new sfValidatorString(array('max_length' => 17, 'required' => false), array('max_length' => 'Max 17 characters')),
      'birth' => new sfValidatorDate(array('min' => date('Y-m-d', strtotime('-105 years')), 'max' => date('Y-m-d', strtotime('-5 years')), 'required' => false)),
      'address1' => new sfValidatorString(array('max_length' => 30, 'required' => false), array('max_length' => 'Max 30 characters')),
      'address2' => new sfValidatorString(array('max_length' => 30, 'required' => false), array('max_length' => 'Max 30 characters')),
      'city' => new sfValidatorString(array('max_length' => 30, 'required' => false), array('max_length' => 'Max 30 characters')),
      'state' => new sfValidatorChoice(array('required' => false, 'choices' => array_keys($this->state_list))),
      'zipcode' => new sfValidatorString(array('max_length' => 10, 'required' => false), array('max_length' => 'Max 10 characters')),
      'country' => new sfValidatorChoice(array('required' => false, 'choices' => array_keys($this->country_list))),
      'display_name' => new sfValidatorString(array('max_length' => 16, 'required' => true), array('max_length' => 'Max 16 characters')),
      'about_me' => new sfValidatorString(array('max_length' => 16, 'required' => false), array('max_length' => 'Max 16 characters')),
      'interests_list' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Interest', 'multiple' => true)),
      'profile_photo' => new sfValidatorFile(array('required' => false, 'path' => sfConfig::get('sf_upload_dir') . '/tmp', 'mime_types' => 'web_images')),
      'website_name' => new sfValidatorString(array('max_length' => 25, 'required' => false), array('max_length' => 'Max 25 characters')),
      'website_address' => new sfValidatorUrl(array('max_length' => 255, 'required' => false), array('max_length' => 'Max 255 characters', 'invalid' => 'A valid URL is required (http://mywebsite.com)')),
    ));


    $this->widgetSchema['password_again'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['password_again'] = clone $this->validatorSchema['password'];

    $this->widgetSchema->moveField('password_again', 'after', 'password');
    $this->mergePostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_again', array(), array('invalid' => 'The two passwords must be the same.')));

    $this->widgetSchema->setNameFormat('user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  /**
   * Save User data
   * 
   * @return type 
   */
  public function save()
  {
    if (!$this->isValid()) {
      throw $this->getErrorSchema();
    }

    $values = $this->values;
    unset($values['password_again']);

    $user_data = $values;
	$user_data['email_old'] = $this->user->getEmail();

    $reg_services = new RegServices();
    $user_data['old_display_name'] = $this->defaults['display_name'];
    $response = $reg_services->updateProfile($user_data);


    if (isset($values['interests_list'])) {
      unset($values['interests_list']);
    }

    if ($response['code'] !== '0') {
      $this->errorSchema->addError(new sfValidatorError($this->validatorSchema, $response['error'], array('field' => $response['field'])), $response['field']);
      return false;
    }

    /**
     * Step 1
     * 
     * Update User Db Data
     */
    $this->user->setFirstName($values['first_name']);
    $this->user->setLastName($values['last_name']);
    $this->user->setDisplayName($values['display_name']);
    $this->user->setEmail($values['email']);
    $this->user->setAvatar($values['avatar']);
    $this->user->setWebsiteName($values['website_name']);
    $this->user->setWebsiteAddress($values['website_address']);
    $this->user->setAboutMe($values['about_me']);
    $this->user->save();

    if (!(empty($values['profile_photo']) && empty($values['profile_photo_choice']) && empty($this->default_profile_photo))) {
      $photo_url = null;

      if (!empty($values['profile_photo'])) {
        $profile_photo = $values['profile_photo'];
        $profile_photo->save();
        $avatar_pi = pathinfo(realpath($profile_photo->getSavedName()));
        $avatar_path = str_replace('/tmp', '/avatars', $avatar_pi['dirname']);
        $avatar_fn = $this->user->getId() . '.' . $avatar_pi['extension'];
        if (!file_exists($avatar_path)) {
          mkdir($avatar_path, 0777, true);
        }
        $avatar_file = $avatar_path . '/' . $avatar_fn;
        // Resize and move the image
        $temp_file =$profile_photo->getSavedName();
        $command = sfConfig::get('app_resize_command', '/srv/scripts/resize')." --force -s 300x300 " . $temp_file . ' ' . $avatar_file;
        $fs = new sfFilesystem();
        $fs->execute($command);
        unlink($profile_photo->getSavedName());
        
        $this->user->setAvatar($avatar_fn);
        $this->user->save();
      }
    }

    /**
     * Step 2
     * 
     * Handle interests 
     */
    if (isset($this->widgetSchema['interests_list'])) {
      $new_interests = isset($user_data['interests_list']) ? $user_data['interests_list'] : array();
      $current_interests = $this->user->getInterests();
      if ($current_interests->count()) {
        UserInterestTable::getInstance()->createQuery('ut')->delete()->where('ut.user_id = ?', $this->user->getId())->execute();
      }
      foreach ($new_interests as $interest_id) {
        $userIntrest = new UserInterest();
        $userIntrest->setUserId($this->user->getId());
        $userIntrest->setInterestId($interest_id);
        $userIntrest->save();
      }
    }

    /**
     * Step 3
     * 
     * Update Session Data 
     */
    $user_info = $reg_services->getProfile($values['profile_id']);
    $contact_info = @$user_info['user_profile']['contact_info'];
    if (is_null($contact_info)) {
      $contact_info = array('address1' => null, 'address2' => null, 'city' => null, 'state' => null, 'zipcode' => null, 'country' => null);
    }
    $user_profile = array_merge($user_info['user_profile'], $contact_info);
    unset($user_profile['contact_info']);
    $user_data = array_merge($user_profile, $this->user->toArray());
    sfContext::getInstance()->getUser()->setUserData($user_data);

    return $this->user;
  }

}
