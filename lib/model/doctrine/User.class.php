<?php

/**
 * User
 * 
 * @package    betterrecipes
 * @subpackage model
 * @author     Bastian Kuberek <bkuberek@resolute.com>
 * 
 * @property user_id
 * @property username
 * @property display_name
 * @property first_name
 * @property last_name
 * @property gender
 * @property personal_quote
 * @property age
 * @property loc_city
 * @property loc_state
 * @property loc_zip
 * @property loc_country
 * @property loc_custom
 * @property user_avatar
 * @property user_photo
 * @property status
 * 
 * @method getUserId()
 * @method setUserId()
 * @method getUsername()
 * @method setUsername()
 * @method getDisplayName()
 * @method setDisplayName()
 * @method getFirstName()
 * @method setFirstName()
 * @method getLastName()
 * @method setLastName()
 * @method getGender()
 * @method setGender()
 * @method getPersonalQuote()
 * @method setPersonalQuote()
 * @method getAge()
 * @method setAge()
 * @method getUserAvatar()
 * @method setUserAcayar()
 * @method getUserPhoto()
 * @method setUserPhoto()
 * @method getStatus()
 * @method setStatus()
 * 
 * 
 * 
 * 
 */
class User extends BaseUser
{
  public $reg_services_data = array();

  public function getInterests()
  {
    return InterestTable::getInstance()->createQuery('interest')
        ->innerJoin('interest.UserInterest ui')
        ->where('ui.user_id = ?', $this->getId())
        ->orderBy('interest.name ASC')
        ->execute();
  }

  /**
   * Whether this User is active
   * 
   * @return boolean
   */
  public function isActive()
  {
    return $this->is_active ? true : false;
  }

  /**
   * Whether this User is an admin
   * 
   * @return boolean
   */
  public function isAdmin()
  {
    return $this->is_admin ? true : false;
  }

  /**
   * Whether this User is a super admin
   * 
   * @return boolean
   */
  public function isSuperAdmin()
  {
    return $this->is_super_admin ? true : false;
  }

  /**
   * Called before the object is saved
   */
  public function preSave($event)
  {
    $now = date('Y-m-d H:i:s');
    if ($this->isNew()) {
      $this->created_at = $now;
    }
    $this->updated_at = $now;
  }

  /**
   *
   * @param integer $count
   * @param integer $page_no
   * @return type 
   */
  public function getRecentRecipes($count = 3, $page_no = null)
  {
    $q = Doctrine_Core::getTable('Recipe')->createQuery('r')->where('r.is_active = ?', 1)->andWhere('r.user_id = ?', $this->id)->orderBy('r.created_at DESC');
    if ($page_no) {
      $recipes = $q->execute()->getData();
      $recipe_count = count($recipe);
      $page_count = ceil($recipe_count / $count);
      $paginated_recipes = array_chunk($recipes, $page_count);
      return $paginated_recipes[$page_no - 1];
    } else {
      return $q->limit($count)->execute()->getData();
    }
  }

  /**
   * Set Reg services data
   * 
   * @return boolean 
   */
  public function setRegServicesData()
  {
    if ($profile_id = $this->getProfileId()) {
      $reg_services = new RegServices();
      $user_info = $reg_services->getProfile($profile_id);
      $contact_info = @$user_info['user_profile']['contact_info'];
      if (is_null($contact_info)) {
        $contact_info = array('address1' => null, 'address2' => null, 'city' => null, 'state' => null, 'zipcode' => null, 'country' => null);
      }
      $user_profile = array_merge($user_info['user_profile'], $contact_info);
      unset($user_profile['contact_info']);
      $this->reg_services_data = $user_profile;
    }
  }

  /**
   * Get internal values. Note the same as getData()
   * 
   * @return array
   */
  public function getValues()
  {
    return $this->_values;
  }

// do not use this
  public function exposeData()
  {
    print_r($this->_data);
    print_r($this->_values);
  }

  /**
   * Suppress errors if a method doesn't exist. 
   * 
   * @param type $method
   * @param type $arguments
   * @return mixed
   */
  public function __call($method, $arguments)
  {
    try {
      return parent::__call($method, $arguments);
    } catch (Exception $e) {
      return null;
    }
  }

  public function getSaved($limit = null)
  {
    $q = Doctrine_Core::getTable('Saved')->createQuery('s')->where('s.user_id = ?', $this->id);
    if ($limit) {
      $q->limit($limit);
    }
    return $q->execute();
  }

  public function getActiveSaved($limit = null)
  {
    $q = Doctrine_Core::getTable('Saved')->createQuery('s')->innerJoin('s.Recipe r')->where('s.user_id = ?', $this->id)->andWhere('r.is_active = ?', 1);
    if ($limit) {
      $q->limit($limit);
    }
    return $q->execute();
  }

  public function getActiveMade($limit = null)
  {
    $q = Doctrine_Core::getTable('UserActions')->createQuery('u')->innerJoin('u.Recipe r')->where('u.user_id = ?', $this->id)->andWhere('u.action_id = ?', 4)->andWhere('r.is_active = ?', 1);
    if ($limit) {
      $q->limit($limit);
    }
    return $q->execute();
  }

  public function getActivePersonalRecipes($limit = null)
  {
    $q = Doctrine_Core::getTable('Recipe')->createQuery('r')->where('r.user_id = ?', $this->id)->andWhere('r.is_active = ?', 1);
    if ($limit) {
      $q->limit($limit);
    }
    return $q->execute();
  }

  /**
   * Commits the user record in db
   * 
   * @param Array $user_profile.
   */
  public function commitUserData($user_profile)
  {
    $this->setProfileId($user_profile['id']);
    $this->setFirstName($user_profile['first_name']);
    $this->setLastName($user_profile['last_name']);
    $this->setDisplayName($user_profile['display_name']);
    $this->setEmail($user_profile['login']);
    $this->save();
    return $this;
  }

  /**
   * User has a FB account
   * 
   */
  public function hasFb()
  {
    return !is_null($this->fb_id) ? true : false;
  }

  /**
   * Is user eligible to be social (does he/she have fb id and choose fb share?)
   * 
   */
  public function isSocial()
  {
    return $this->fb_share && $this->hasFb() ? true : false;
  }

  /**
   * Get Local User Avatar path
   * 
   */
  public function getLocalAvatarSrc()
  {
    if (strpos($this->avatar, 'default_') === false) {
      return '/uploads/avatars/' . $this->avatar;
    } else {
      return '/img/avatars/' . $this->avatar;
    }
  }

  /**
   * Get User Avatar Path
   * 
   */
  public function getAvatarSrc()
  {
    if (sfContext::getInstance()->getUser()->getRegSourceAttribute('auth_token')) {
      return 'http://graph.facebook.com/' . $this->fb_id . '/picture';
    } else {
      return $this->getLocalAvatarSrc();
    }
  }

}
