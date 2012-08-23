<?php

/**
 * UserTable
 * 
 * @package    betterrecipes
 * @subpackage model
 * @author     Bastian Kuberek <bkuberek@resolute.com>
 */
class UserTable extends Doctrine_Table
{

  /**
   * Returns an instance of this class.
   *
   * @return UserTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('User');
  }

  /**
   * Retrieve a user given the params and its `is_active` property
   * 
   * @param array $params
   * @param boolean $is_active
   * @return User
   */
  public function retrieveUser(array $params, $is_active = 1)
  {
    //print_r($params);
    $query = $this->createQuery('user');

    foreach ($params as $col => $val) {
      $query->addWhere(sprintf('%s.%s = ?', $query->getRootAlias(), $col), $val);
    }

    if (!is_null($is_active)) {
      $query->addWhere($query->getRootAlias() . '.is_active = ?', $is_active);
    }

    return $query->fetchOne();
  }

  public static function getUserByFbId($fb_id)
  {
    return Doctrine_Core::getTable('User')->createQuery('u')->where('u.fb_id = ?', $fb_id)->andWhere('u.is_active = ?', 1)->fetchOne();
  }

  public static function getUserByEmail($email)
  {
    return Doctrine_Core::getTable('User')->createQuery('u')->where('u.email = ?', $email)->andWhere('u.is_active = ?', 1)->fetchOne();
  }

  public static function getUserByProfileId($profile_id)
  {
    return Doctrine_Core::getTable('User')->createQuery('u')->where('u.profile_id = ?', $profile_id)->andWhere('u.is_active = ?', 1)->fetchOne();
  }

  public static function getUserByDisplayName($display_name)
  {
    return Doctrine_Core::getTable('User')->createQuery('u')->where('u.display_name = ?', $display_name)->andWhere('u.is_active = ?', 1)->fetchOne();
  }

  public static function getFilteredAdmins($params = null)
  {
    $q = Doctrine_Core::getTable('User')->createQuery('u')->where('u.is_admin = 1');

    if (isset($params['email']) && ($params['email'] != "Enter Email"))
      $q->andWhere('u.email LIKE ?', "%" . $params['email'] . "%");
    if (isset($params['sort'])) {
      switch ($params['sort']) {
        case "email":
          $q->orderBy('u.email ' . $params['sortDir']);
          break;
        case "dateAdded":
          $q->orderBy('u.created_at ' . $params['sortDir']);
          break;
        case "accountType":
          $q->orderBy('u.is_admin ' . $params['sortDir']);
          break;
        case "active":
          $q->orderBy('u.is_active ' . $params['sortDir']);
          $q->addOrderBy('u.created_at DESC');
          break;
        default:
          $q->orderBy('u.created_at ' . $params['sortDir']);
      }
    } else
      $q->orderBy('u.created_at DESC');

    return $q;
  }

  public static function getPremiumUsersQuery($params = null)
  {
    $q = Doctrine_Core::getTable('User')->createQuery('u')->where('u.is_premium = 1');
    $q->orderBy($params['sortby'] . ' ' . $params['order']);
    return $q;
  }

  public static function getSearchQuery($criteria = array())
  {
    if (!isset($criteria['searchby']) || is_null($criteria['searchby'])) {
      $criteria['searchby'] = 'email';
    }
    $criteria_str = 'u.';
    $criteria_str .= $criteria['searchby'];
    $keyword = $criteria['keyword'];
    if (!isset($criteria['method']) || $criteria['method'] == 'like') {
      $criteria_str .= " LIKE '%$keyword%'";
    } else {
      $criteria_str .= " = '$keyword'";
    }
    $q = Doctrine_Core::getTable('User')->createQuery('u')->where($criteria_str)->orderBy("id DESC");
    return $q;
  }

}