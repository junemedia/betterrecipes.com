<?php

class opengraphComponents extends sfComponents
{

  public function executeUserRailActivity()
  {
    $page_no = ( $this->page_no ) ? $this->page_no : 1;
    $a = array('results_per_page' => $this->results_per_page, 'user_id' => $this->getUser()->getId(), 'page_no' => $page_no);
    $this->activity = UserActionsTable::getUserPlanningToMakeRecipes($a);
  }

  public function executeUserRailActivityLog()
  {
    $page_no = ( $this->page_no ) ? $this->page_no : 1;
    $a = array('results_per_page' => $this->results_per_page, 'user_id' => $this->getUser()->getId(), 'page_no' => $page_no);
    $this->activity = UserActionsTable::getUserActivities($a);
  }

  public function executeUserRailActivityCompleted()
  {
    // fetch the current activity type by PK
    $this->activity = Doctrine_Core::getTable('UserActions')->find($this->id);
    $friends = null;
    if ($this->getUser()->getRegSourceAttribute('auth_token')) {
      $facebook_helper = new Facebook_helper($this->getGigya(), $this->getUser());
      $friends = $facebook_helper->get_friends_ids_using_app();
    }
    if (sizeof($friends) > 0) {
      $this->activityFriends = UserActionsTable::getActivityByUserFriends(array('recipe_id' => $this->activity->getRecipeId(), 'poll_id' => $this->activity->getPollId(), 'contest_id' => $this->activity->getContestId(), 'action_id' => $this->activity->getActionId(), 'friends' => $friends));
    } else {
      $this->activityFriends = array();
    }
  }

  public function executeTrendingRecipes()
  {
    $a = array();
    if ($this->category_id) {
      $a['category_id'] = $this->category_id;
    } else if ($this->parent_category_id) {
      $a['parent_category_id'] = $this->parent_category_id;
    }
    if (isset($this->limit)) {
      $a['limit'] = $this->limit;
    }
    $this->trending = UserActionsTable::getTrendingRecipes($a);
  }

  public function executeActivityRecipeDetail()
  {
    $a = array('user_id' => $this->getUser()->getId(), 'recipe_id' => $this->recipe_id);
    $activityCount = UserActionsTable::getActivityRecipeDetailCount($a);
    $this->activityCount = count($activityCount);
    $this->activity = UserActionsTable::getActivityRecipeDetail($a);
  }

  public function executeFriendRibbon()
  {
    $friends = null;
    if ($this->getUser()->getRegSourceAttribute('auth_token')) {
      $facebook_helper = new Facebook_helper($this->getGigya(), $this->getUser());
      $friends = $facebook_helper->get_friends_ids_using_app();
    }
    if (sizeof($friends) > 0) {
      $page_no = ( $this->page_no ) ? $this->page_no : 1;
      $a = array('results_per_page' => $this->results_per_page, 'page_no' => $page_no, 'friends' => $friends);
      $this->friends = UserActionsTable::getFriendsWithActivity($a);
    } else {
      $this->friends = array();
    }
  }

  public function executeRecipesByFriends()
  {
    if (isset($this->friends) && sizeof($this->friends) > 0) {
      $a['friends'] = $this->friends;
      if ($this->category_id) {
        $a['category_id'] = $this->category_id;
      }
      if (isset($this->limit)) {
        $a['limit'] = $this->limit;
      }
      $this->recipeFriends = UserActionsTable::getRecipesByFriendsList($a);
    } else {
      $this->recipeFriends = array();
    }
  }

  public function executeFriendsActivityBar()
  {
    $this->friend_id_array = null;
    if ($this->getUser()->getRegSourceAttribute('auth_token')) {
      $facebook_helper = new Facebook_helper($this->getGigya(), $this->getUser());
      $this->friend_id_array = $facebook_helper->get_friends_ids_using_app();
    }
    if (sizeof($this->friend_id_array) > 0) {
      $this->recipeFriends = UserActionsTable::getFriendsWithActivity(array('friends' => $this->friend_id_array));
    } else {
      $this->recipeFriends = array();
    }
  }

  public function executeFacebookLoginModal(sfWebRequest $request)
  {
    
  }

  public function executeUserSavedNotMade()
  {
    $this->saved = UserActionsTable::getUserRecipesSavedNotMade(array('user_id' => $this->getUser()->getId()));
  }

}