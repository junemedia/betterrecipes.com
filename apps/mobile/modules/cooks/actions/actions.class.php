<?php

/**
 * cooks actions.
 *
 * @package    betterrecipes
 * @subpackage people
 * @author     Rusty Cage <rcage@resolute.com>
 */
class cooksActions extends sfActions
{

  public function preExecute()
  {
    $this->rest = $this->getOnesite()->getRest();
    if ($this->getUser()->isAuthenticated()) {
      $this->user_id = $this->getUser()->getOnesiteId();
    } else {
      $this->user_id = null;
    }
  }

  /**
   *
   * @param sfWebRequest $request 
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->cooks = $this->rest->getTopUsers(1, 48);
	
    // load featured cook wonder
    //$this->featured_cook_wonder = $this->rest->peopleLandingWonder();

    // meta
    $response = $this->getResponse();
    $response->setTitle('Cooks | Recipe Community | Share Recipes | Online Recipes | Better Recipes');
    $response->addMeta('description', 'Learn more about the cooks in our recipe community on this page. Connect with the Better Recipes cooks, share recipes, trade cooking tips and more.');
    $response->addMeta('keywords', 'share recipes, recipe community, online recipes, cooking tips');
	
	
    /**
     * Omniture
     */
    $this->getOmniture()->setMany(array(
      'pageName' => 'Category:Cooks',
      'server' => 'www.betterrecipes.com',
      'channel' => 'Cooks',
      'prop7' => $this->getUser()->isAuthenticated(),
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $this->getRequest()->getUri(),
      'eVar9' => 'Category:Cooks',
      'eVar14' => 'Cooks',
      'eVar24' => $this->getUser()->isAuthenticated()
    ));
  }

  /**
   * Executes profile action
   *
   * @param sfRequest $request A request object
   */
  public function executeProfile(sfWebRequest $request)
  {
    // no need to handle is_active and 404 here because it is handled at the route
    $this->user = $this->getRoute()->getObject();
    $this->user->loadOnesite();

    $this->my_profile = ($this->getUser()->isAuthenticated() && $this->getUser()->getId() === $this->user->getId()) ? true : false;
	
    $this->profile = $this->rest->viewUserDetail($this->user->getOnesiteId());
    $this->subdir = @$this->profile['subdir'];
    $this->profile_id = $this->user->getOnesiteId();
    //$this->points = $this->rest->getUserPoints($this->user->getOnesiteId());

    $response = $this->getResponse();
    $response->setTitle(@$this->profile['username'] . ' | Cooks | Better Recipes');

    // increment the views for user
    $this->rest->incrementViewsUser($this->user->getBlogId());

    $this->makeFriend = false;

    if ($this->user_id) {
      $this->makeFriend = $this->my_profile ? false : true;

      // if makeFriend is true (user is viewing somebody else's profile, do execute getFriends + loop)
      if ($this->makeFriend) {
        $friends = $this->rest->getFriends($this->user_id, 1, 2000);
        if (!empty($friends['items'])) {
          for ($i = 0; $i < count($friends['items']); $i++) {
            if ($this->user->getOnesiteId() == $friends['items'][$i]['friend_id']) {
              $this->makeFriend = false;
              break;
            }
          }
        }
      }
    } else {
      $this->makeFriend = true;
    }


    // get list of pending friends if user is viewing their own profile
    if ($this->my_profile) {
      $pending = $this->rest->getFriends($this->user->getOnesiteId(), 1, 20, 1, 'pending', false);
      if (sizeof($pending) > 0) {
        $this->p = $pending['items'];
        $this->p_perPage = $pending['perPage'];
        $this->p_total = $pending['total'];

        $this->p_pager = new Arraypager(null, 20);
        $this->p_pager->setResultTotal($this->p_total);
        $this->p_pager->setPage($this->getRequestParameter('page', 1));
        $this->p_pager->init();
      } else {
        $this->p = array();
        $this->p_pager = '';
      }
    } else {
      $this->p = array();
      $this->p_pager = '';
    }

    //Title Tag & Meta Data
    $this->getResponse()->setTitle(Microformat::correct_caps($this->user->getDisplayName() . '| Cooks | Better Recipes'));

    $this->discussions = $this->rest->getNetworkThreads(1, 3, 'date', 'DESC', null, null, 1, $this->user->getOnesiteId());
    $this->photos = $this->rest->getPhotos(1, 3, 'date', $this->user->getOnesiteId());
    $this->videos = $this->rest->getVideos(1, 3, 'date', $this->user->getOnesiteId());
    $this->journals = $this->rest->getBlogs(1, 3, $this->user->getOnesiteId(), 'date');
    $this->groups = $this->rest->getUserGroups($this->user->getOnesiteId(), 1, 3, 'member,moderator,owner');
    $reset_cache = $this->getUser()->getAttribute('clear_friend_cache', false);
    $this->friends = $this->rest->getFriends($this->user->getOnesiteId(), 1, 3, 1, 'friends', $reset_cache);
    if ($reset_cache) {
      $this->getUser()->setAttribute('clear_friend_cache', false);
    }
    $this->polls = $this->rest->getPolls(1, 3, null, null, null, $this->user->getOnesiteId());
    
    $this->recipes = new sfDoctrinePager('Recipe', '3');
    $this->recipes->setQuery(RecipeTable::getUserRecipes($this->user->getId()));
    $this->recipes->setPage($request->getParameter('page', 1));
    $this->recipes->init();

    // check if a discussion object exists for this user (raves) (needed for comment creation and fetching)
    $content_id = $this->user->getOnesiteId();
    $this->contentId = $this->user->getOnesiteId();
    $this->discussionObject = DiscussionTable::getDiscussion(compact('content_id'));
    if ($this->discussionObject) {
      $reset_cache = $this->getUser()->getAttribute('clear_comment_cache', false);
      // fetch comments
      $c = $this->getComments(1, 3, $this->discussionObject['discussion_id'], $reset_cache);
      if (sizeof($c) > 0) {
        $this->comments = $c['items'];
        if ($reset_cache) {
          $this->getUser()->setAttribute('clear_comment_cache', false);
        }
      } else {
        $this->comments = array();
      }
    } else {
      $this->comments = array();
    }
    /**
     * Omniture
     */
    $this->getOmniture()->setMany(array(
      'pageName' => sprintf('MixingBowl:User:%s:%s', $this->my_profile ? 'Private' : 'Public', $this->user->getDisplayName()),
      'server' => 'www.betterrecipes.com',
      'channel' => 'Mixing Bowl',
      'prop1' => 'MixingBowl:User',
      'prop2' => 'MixingBowl:User:' . ($this->my_profile ? 'Private' : 'Public'),
      'prop7' => $this->getUser()->isAuthenticated(),
      'prop11' => '', // partner name - sponsored profile - omniture_tbd
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $this->getRequest()->getUri(),
      'eVar9' => sprintf('MixingBowl:User:%s:%s', $this->my_profile ? 'Private' : 'Public', $this->user->getDisplayName()),
      'eVar14' => 'Mixing Bowl',
      'eVar24' => $this->getUser()->isAuthenticated() ? true : false,
    ));
  }

  /**
   *
   * @param sfWebRequest $request 
   */
  public function executeEditProfile(sfWebRequest $request)
  {
    $this->user = $this->getRoute()->getObject();

    $this->my_profile = ($this->getUser()->isAuthenticated() && $this->getUser()->getId() === $this->user->getId()) ? true : false;
    $this->redirectUnless($this->my_profile, $this->generateUrl('cook_profile', $this->user));
    $this->user->loadOnesite();

    $this->userForm = new UserProfileForm($this->user->toArray());

    if ($request->isMethod(sfRequest::POST)) {
      $this->userForm->bind($request->getParameter($this->userForm->getName()), $request->getFiles($this->userForm->getName()));
      if ($this->userForm->isValid() && $this->userForm->save()) {
        $this->getUser()->setFlash('notice', 'Your profile was saved');
        $this->redirect('cook_profile_edit', $this->user);
      }
    }

    $this->profile = $this->rest->viewUserDetail($this->user->getOnesiteId());
    $this->points = $this->rest->getUserPoints($this->user->getOnesiteId());

    // check user auth
    if (is_null($this->user_id)) {
      $this->getUser()->setReferrer(UrlToolkit::getDomainUri() . $this->getController()->genUrl('/cooks/' . $this->profile['username'] . '/edit'));
      $this->redirect('@signin');
    } else {
      // check that logged in user matches profile 
      if ($this->user_id != $this->user->getOnesiteId()) {
        $this->redirect('@homepage');
      }
    }

    $this->discussions = $this->rest->getNetworkThreads(1, 3, 'date', 'DESC', null, null, 1, $this->user->getOnesiteId());
    $this->photos = $this->rest->getPhotos(1, 5, 'date', $this->user->getOnesiteId());
    $this->videos = $this->rest->getVideos(1, 5, 'date', $this->user->getOnesiteId());
    $this->journals = $this->rest->getBlogs(1, 3, $this->user->getOnesiteId(), 'date');
    $this->groups = $this->rest->getUserGroups($this->user->getOnesiteId(), 1, 5, 'member,moderator,owner');
    $this->friends = $this->rest->getFriends($this->user->getOnesiteId(), 1, 5, 1);

    // check if a discussion object exists for this user (raves) (needed for comment creation and fetching)
    $content_id = $this->user->getOnesiteId();
    $this->contentId = $this->user->getOnesiteId();
    $this->discussionObject = DiscussionTable::getDiscussion(compact('content_id'));
    if ($this->discussionObject) {
      $reset_cache = $this->getUser()->getAttribute('clear_comment_cache', false);
      // fetch comments
      $c = $this->getComments(1, 2, $this->discussionObject['discussion_id'], $reset_cache);
      if (sizeof($c) > 0) {
        $this->comments = $c['items'];
        if ($reset_cache) {
          $this->getUser()->setAttribute('clear_comment_cache', false);
        }
      } else {
        $this->comments = array();
      }
    } else {
      $this->comments = array();
    }

    $this->pending_friends = $this->rest->getFriends($this->user->getOnesiteId(), 1, 2, 1, 'pending', false);

    /**
     * Omniture
     */
    $this->getOmniture()->setMany(array(
      'pageName' => sprintf('MixingBowl:User:%s:%s', 'EditSettings', $this->user->getDisplayName()),
      'server' => 'www.betterrecipes.com',
      'channel' => 'Mixing Bowl',
      'prop1' => 'MixingBowl:User',
      'prop2' => 'MixingBowl:User:' . 'EditSettings',
      'prop7' => $this->getUser()->isAuthenticated(),
      'prop11' => '', // partner name - sponsored profile - omniture_tbd
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $this->getRequest()->getUri(),
      'eVar9' => sprintf('MixingBowl:User:%s:%s', 'EditSettings', $this->user->getDisplayName()),
      'eVar14' => 'Mixing Bowl',
      'eVar18' => $this->getUser()->isAuthenticated() ? $this->getUser()->getAttribute('regSource') : '',
      'eVar24' => $this->getUser()->isAuthenticated() ? true : false,
      'eVar26' => '', // party ID - omniture_tbd
      'eVar32' => $this->getUser()->isAuthenticated() ? $this->getUser()->getProfileId() : ''
    ));
  }

  /**
   *
   * @param sfWebRequest $request 
   */
  public function executeEmailSettings(sfWebRequest $request)
  {
    $this->user = $this->getRoute()->getObject();
    $this->my_profile = ($this->getUser()->isAuthenticated() && $this->getUser()->getId() === $this->user->getId()) ? true : false;
    $this->redirectUnless($this->my_profile, $this->generateUrl('cook_profile', $this->user));
    $this->user->loadOnesite();
    $this->points = $this->rest->getUserPoints($this->user->getOnesiteId());

    $this->form = new UserEmailSettings($this->user->toArray(false));

    if ($request->isMethod(sfRequest::POST)) {
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid()) {
        $this->form->save();
        $this->getUser()->setFlash('notice', 'Email settings were saved.');
        $this->redirect('cook_profile_email_settings', $this->user);
      }
    }

    /**
     * Omniture
     */
    $this->getOmniture()->setMany(array(
      'pageName' => sprintf('MixingBowl:User:%s:%s', 'EmailSettings', $this->user->getDisplayName()),
      'server' => 'www.betterrecipes.com',
      'channel' => 'Mixing Bowl',
      'prop1' => 'MixingBowl:User',
      'prop2' => 'MixingBowl:User:' . 'EmailSettings',
      'prop7' => $this->getUser()->isAuthenticated(),
      'prop11' => '', // partner name - sponsored profile - omniture_tbd
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $this->getRequest()->getUri(),
      'eVar9' => sprintf('MixingBowl:User:%s:%s', 'EmailSettings', $this->user->getDisplayName()),
      'eVar14' => 'Mixing Bowl',
      'eVar18' => $this->getUser()->isAuthenticated() ? $this->getUser()->getAttribute('regSource') : '',
      'eVar24' => $this->getUser()->isAuthenticated() ? true : false,
      'eVar26' => '', // party ID - omniture_tbd
      'eVar32' => $this->getUser()->isAuthenticated() ? $this->getUser()->getProfileId() : ''
    ));
  }

  /**
   *
   * @param sfWebRequest $request 
   */
  public function executeFriends(sfWebRequest $request)
  {
    $this->user = $this->getRoute()->getObject();
    $this->my_profile = ($this->getUser()->isAuthenticated() && $this->getUser()->getId() === $this->user->getId()) ? true : false;
//    $this->redirectUnless($this->my_profile, $this->generateUrl('cook_profile', $this->user));
    $this->user->loadOnesite();

    $this->profile = $this->rest->viewUserDetail($this->user->getOnesiteId());

    $this->profile_id = $this->user->getOnesiteId();
    //$this->points = $this->rest->getUserPoints($this->user->getOnesiteId());
    
    $this->userId = $this->user->getOnesiteId();

    //$this->groups = $this->rest->getUserGroups($this->user->getOnesiteId(), 1, 5, 'member,moderator,owner');
    $reset_cache = $this->getUser()->getAttribute('clear_friend_cache', false);
    //$this->friends = $this->rest->getFriends($this->user->getOnesiteId(), 1, 10, 1, 'friends', $reset_cache);
    if ($reset_cache) {
      $this->getUser()->setAttribute('clear_friend_cache', false);
    }
	
	/*
    // check if a discussion object exists for this user (raves) (needed for comment creation and fetching)
    $content_id = $this->user->getOnesiteId();
    $this->contentId = $this->user->getOnesiteId();
    $this->discussionObject = DiscussionTable::getDiscussion(compact('content_id'));
    if ($this->discussionObject) {
      $reset_cache = $this->getUser()->getAttribute('clear_comment_cache', false);
      // fetch comments
      $c = $this->getComments(1, 2, $this->discussionObject['discussion_id'], $reset_cache);
      if (sizeof($c) > 0) {
        $this->comments = $c['items'];
        if ($reset_cache) {
          $this->getUser()->setAttribute('clear_comment_cache', false);
        }
      } else {
        $this->comments = array();
      }
    } else {
      $this->comments = array();
    }
	*/
	
	
    $this->subdir = $this->profile['subdir'];
	
	/*
    $pending = $this->rest->getFriends($this->user->getOnesiteId(), 1, 20, 1, 'pending', false);

    if (sizeof($pending) > 0) {
      $this->p = $pending['items'];
      $this->p_perPage = $pending['perPage'];
      $this->p_total = $pending['total'];

      $this->p_pager = new Arraypager(null, 20);
      $this->p_pager->setResultTotal($this->p_total);
      $this->p_pager->setPage($this->getRequestParameter('page', 1));
      $this->p_pager->init();
    } else {
      $this->p = array();
      $this->p_pager = '';
    }
    */

    $friends = $this->rest->getFriends($this->user->getOnesiteId(), 1, 10, 1, 'friends', false);
    if (sizeof($friends) > 0) {
      $this->f = $friends['items'];
      $this->f_perPage = $friends['perPage'];
      $this->f_total = $friends['total'];

      $this->f_pager = new Arraypager(null, 10);
      $this->f_pager->setResultTotal($this->f_total);
      $this->f_pager->setPage($this->getRequestParameter('page', 1));
      $this->f_pager->init();
    } else {
      $this->f = array();
      $this->f_pager = '';
    }
	
	/*
    $this->bread_crumbs = array(
      'better recipes' => UrlToolkit::getDomainUri(),
      'cooks' => UrlToolkit::getDomainUri() . '/cooks',
      $this->user->getDisplayName() => UrlToolkit::getDomainUri() . '/cooks/' . $this->user->getDisplayName(),
      'friends' => null
    );*/
  }
  
  
  public function executeFriends_paginate(sfWebRequest $request)
  {
  	$this->forward404Unless($request->isXmlHttpRequest());
	$userId =$request->getParameter('userId');
    
    $friends = $this->rest->getFriends($userId, $request->getParameter('page', 1), 10, 1, 'friends', false);
    if (sizeof($friends) > 0) {
      $f = $friends['items'];
      $f_perPage = $friends['perPage'];
      $f_total = $friends['total'];

      $f_pager = new Arraypager(null, 10);
      $f_pager->setResultTotal($f_total);
      $f_pager->setPage($this->getRequestParameter('page', 1));
      $f_pager->init();
    } else {
      $f = array();
      $f_pager = '';
    }
	
	$this->renderPartial('friendList', compact('userId', 'f', 'f_pager'));
	return sfView::NONE;
  }
  

  /**
   *
   * @param sfWebRequest $request
   * @return type 
   */
  public function executePaginatefriends(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $type = $request->getParameter('type');
    $profile_id = $request->getParameter('user_id');
    $subdir = $request->getParameter('subdir');
    $my_profile = $request->getParameter('my_profile');
    if ($type == 'pending') {
      $pending = $this->rest->getFriends($profile_id, $request->getParameter('page', 1), 20, 1, 'pending', false);
      if (sizeof($pending) > 0) {
        $p = $pending['items'];
        $p_perPage = $pending['perPage'];
        $p_total = $pending['total'];

        $p_pager = new Arraypager(null, 20);
        $p_pager->setResultTotal($p_total);
        $p_pager->setPage($request->getParameter('page', 1));
        $p_pager->init();
      } else {
        $p = array();
        $p_pager = '';
      }
      $this->renderPartial('pending_friends', compact('p', 'p_pager', 'subdir', 'profile_id', 'my_profile'));
    } else {
      $friends = $this->rest->getFriends($profile_id, $request->getParameter('page', 1), 20, 1, 'friends', false);
      if (sizeof($friends) > 0) {
        $f = $friends['items'];
        $f_perPage = $friends['perPage'];
        $f_total = $friends['total'];

        $f_pager = new Arraypager(null, 20);
        $f_pager->setResultTotal($f_total);
        $f_pager->setPage($request->getParameter('page', 1));
        $f_pager->init();
      } else {
        $f = array();
        $f_pager = '';
      }
      $this->renderPartial('current_friends', compact('f', 'f_pager', 'subdir', 'profile_id', 'my_profile'));
    }
    return sfView::NONE;
  }

  /**
   *
   * @param sfWebRequest $request
   * @return type 
   */
  public function executeMakefriend(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $user_id = $request->getParameter('user_id');
    $friend_id = $request->getParameter('friend_id');
    $this->forward404Unless($user_id);
    $this->forward404Unless($friend_id);
    // check that the user id matches the authorized logged in user
    if (!is_null($this->user_id)) {
      if ($this->user_id != $user_id) {
        $response = array('code' => 999, 'message' => 'You are not authorized to make this friend request');
        return $this->renderText(json_encode($response));
      }
    } else {
      $response = array('code' => 999, 'message' => 'You must be logged in to make a friend request');
      return $this->renderText(json_encode($response));
    }

    $status = $this->rest->makeFriend($user_id, $friend_id);
    $response = array('code' => $status['code'], 'message' => $status['message']);
    return $this->renderText(json_encode($response));
    return sfView::NONE;
  }

  /**
   *
   * @param sfWebRequest $request
   * @return type 
   */
  public function executeAcceptfriend(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $friend_id = $request->getParameter('friend_id');
    $user_id = $request->getParameter('user_id');
    $r = $this->rest->acceptFriendship($friend_id, $user_id);
    if (sizeof($r) > 0 && isset($r['code'])) {
      $this->getUser()->setAttribute('clear_friend_cache', true);
      $response = array('code' => $r['code'], 'message' => $r['message']);
    } else {
      $response = array('code' => 999, 'message' => 'There was an issue submitting your request. Please try again');
    }
    return $this->renderText(json_encode($response));
    return sfView::NONE;
  }

  public function executeSearch(sfWebRequest $request)
  {
//    $this->forward404Unless($request->isXmlHttpRequest());
    sfConfig::set('sf_web_debug', false);

    $limit = $request->getParameter('limit', 500);
    $term = $request->getParameter('q');
    $params = $request->getParameter('params');
    $exclude_ids = $request->getParameter('exclude_ids');

    $q = UserTable::getInstance()->createQuery('user')
      ->addWhere('user.display_name LIKE ?', $term . '%')
      ->orderBy('user.display_name ASC')
      ->limit($limit);

    if ($exclude_ids) {
      $q->whereNotIn('user.onesite_id', $exclude_ids);
    }

    $users = $q->execute(array(), Doctrine_Core::HYDRATE_ARRAY);

    $this->renderText(json_encode(array('results' => $users)));

    return sfView::NONE;
  }

  /**
   *
   * @param sfWebRequest $request
   * @return type 
   */
  public function executeDropfriend(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $friend_id = $request->getParameter('friend_id');
    $user_id = $request->getParameter('user_id');
    $r = $this->rest->dropFriend($user_id, $friend_id);
    if (sizeof($r) > 0 && isset($r['code'])) {
      $this->getUser()->setAttribute('clear_friend_cache', true);
      $response = array('code' => $r['code'], 'message' => $r['message']);
    } else {
      $response = array('code' => 999, 'message' => 'There was an issue submitting your request. Please try again');
    }
    return $this->renderText(json_encode($response));
    return sfView::NONE;
  }

  /**
   *
   * @param sfWebRequest $request 
   */
  public function executeGroups(sfWebRequest $request)
  {
    $this->user = $this->getRoute()->getObject();
    $this->my_profile = ($this->getUser()->isAuthenticated() && $this->getUser()->getId() === $this->user->getId()) ? true : false;
//    $this->redirectUnless($this->my_profile, $this->generateUrl('cook_profile', $this->user));
    $this->user->loadOnesite();

    $this->profile = $this->rest->viewUserDetail($this->user->getOnesiteId());
    //$this->points = $this->rest->getUserPoints($this->user->getOnesiteId());

    //$this->friends = $this->rest->getFriends($this->user->getOnesiteId(), 1, 5, 1);
    
    $this->userId = $this->user->getOnesiteId();
    $groups = $this->rest->getUserGroups($this->user->getOnesiteId(), $request->getParameter('page', 1), 10, 'member,moderator,owner');

    if (sizeof($groups) > 0) {
      $this->groups = $groups['items'];
      $this->groups_perPage = $groups['perPage'];
      $this->groups_total = $groups['total'];

      $this->groups_pager = new Arraypager(null, 20);
      $this->groups_pager->setResultTotal($this->groups_total);
      $this->groups_pager->setPage($request->getParameter('page', 1));
      $this->groups_pager->init();
    } else {
      $this->groups = array();
      $this->groups_pager = '';
    }
    // check if a discussion object exists for this user (raves) (needed for comment creation and fetching)
    /*$content_id = $this->user->getOnesiteId();
    $this->contentId = $this->user->getOnesiteId();
    $this->discussionObject = DiscussionTable::getDiscussion(compact('content_id'));
    if ($this->discussionObject) {
      $reset_cache = $this->getUser()->getAttribute('clear_comment_cache', false);
      // fetch comments
      $c = $this->getComments(1, 2, $this->discussionObject['discussion_id'], $reset_cache);
      if (sizeof($c) > 0) {
        $this->comments = $c['items'];
        if ($reset_cache) {
          $this->getUser()->setAttribute('clear_comment_cache', false);
        }
      } else {
        $this->comments = array();
      }
    } else {
      $this->comments = array();
    }*/
	
	/*
    $this->bread_crumbs = array(
      'better recipes' => UrlToolkit::getDomainUri(),
      'cooks' => UrlToolkit::getDomainUri() . '/cooks',
      $this->user->getDisplayName() => UrlToolkit::getDomainUri() . '/cooks/' . $this->user->getDisplayName(),
      'groups' => null
    );*/
  }
  
  public function executeGroups_paginate(sfWebRequest $request)
  {
  	$this->forward404Unless($request->isXmlHttpRequest());
	$userId = $request->getParameter('userId');
    $g = $this->rest->getUserGroups($userId, $request->getParameter('page', 1), 10, 'member,moderator,owner');
    
    if (sizeof($g) > 0) {
      $groups = $g['items'];
      $groups_perPage = $g['perPage'];
      $groups_total = $g['total'];

      $groups_pager = new Arraypager(null, 10);
      $groups_pager->setResultTotal($groups_total);
      $groups_pager->setPage($request->getParameter('page', 1));
      $groups_pager->init();
    } else {
      $groups = array();
      $groups_pager = '';
    }
	
	$this->renderPartial('groupList', compact('userId', 'groups', 'groups_pager'));
	return sfView::NONE;
  }


  /**
   *
   * @param sfWebRequest $request 
   */
  public function executePhotos(sfWebRequest $request)
  {
    $this->user = $this->getRoute()->getObject();
    $this->my_profile = ($this->getUser()->isAuthenticated() && $this->getUser()->getId() === $this->user->getId()) ? true : false;
//    $this->redirectUnless($this->my_profile, $this->generateUrl('cook_profile', $this->user));
    $this->user->loadOnesite();
    $this->profile = $this->rest->viewUserDetail($this->user->getOnesiteId());
    //$this->points = $this->rest->getUserPoints($this->user->getOnesiteId());
	
	$this->userId = $this->user->getOnesiteId();
    //$this->groups = $this->rest->getUserGroups($this->user->getOnesiteId(), 1, 5, 'member,moderator,owner');
    $photos = $this->rest->getPhotos($request->getParameter('page', 1), 10, 'date', $this->user->getOnesiteId());

    if (sizeof($photos) > 0) {
      $this->photos = $photos['items'];
      $this->photos_perPage = $photos['perPage'];
      $this->photos_total = $photos['total'];

      $this->photos_pager = new Arraypager(null, 10);
      $this->photos_pager->setResultTotal($this->photos_total);
      $this->photos_pager->setPage($request->getParameter('page', 1));
      $this->photos_pager->init();
    } else {
      $this->photos = array();
      $this->photos_pager = '';
    }


    // check if a discussion object exists for this user (raves) (needed for comment creation and fetching)
    /*$content_id = $this->user->getOnesiteId();
    $this->contentId = $this->user->getOnesiteId();
    $this->discussionObject = DiscussionTable::getDiscussion(compact('content_id'));
    if ($this->discussionObject) {
      $reset_cache = $this->getUser()->getAttribute('clear_comment_cache', false);
      // fetch comments
      $c = $this->getComments(1, 2, $this->discussionObject['discussion_id'], $reset_cache);
      if (sizeof($c) > 0) {
        $this->comments = $c['items'];
        if ($reset_cache) {
          $this->getUser()->setAttribute('clear_comment_cache', false);
        }
      } else {
        $this->comments = array();
      }
    } else {
      $this->comments = array();
    }*/
	
	/*
    $this->bread_crumbs = array(
      'better recipes' => UrlToolkit::getDomainUri(),
      'cooks' => UrlToolkit::getDomainUri() . '/cooks',
      $this->user->getDisplayName() => UrlToolkit::getDomainUri() . '/cooks/' . $this->user->getDisplayName(),
      'photos' => null
    );*/
  }
  
  
  public function executePhotos_paginate(sfWebRequest $request)
  {
  	$this->forward404Unless($request->isXmlHttpRequest());
	$userId =$request->getParameter('userId');
	
	$p = $this->rest->getPhotos($request->getParameter('page', 1), 10, 'date', $userId);
	if (sizeof($p) > 0) {
      $photos = $p['items'];
      $photos_perPage = $p['perPage'];
      $photos_total = $p['total'];

      $photos_pager = new Arraypager(null, 10);
      $photos_pager->setResultTotal($photos_total);
      $photos_pager->setPage($request->getParameter('page', 1));
      $photos_pager->init();
    } else {
      $photos = array();
      $photos_pager = '';
    }
    	
	$this->renderPartial('photoList', compact('userId', 'photos', 'photos_pager'));
	return sfView::NONE;
  }



  public function executeVideos(sfWebRequest $request)
  {
    $this->user = $this->getRoute()->getObject();
    $this->my_profile = ($this->getUser()->isAuthenticated() && $this->getUser()->getId() === $this->user->getId()) ? true : false;
//    $this->redirectUnless($this->my_profile, $this->generateUrl('cook_profile', $this->user));
    $this->user->loadOnesite();

    $this->profile = $this->rest->viewUserDetail($this->user->getOnesiteId());
    //$this->points = $this->rest->getUserPoints($this->user->getOnesiteId());

    //$this->groups = $this->rest->getUserGroups($this->user->getOnesiteId(), 1, 5, 'member,moderator,owner');
    
    $this->userId = $this->user->getOnesiteId();
    $videos = $this->rest->getVideos($request->getParameter('page', 1), 10, 'date', $this->user->getOnesiteId());

    if (sizeof($videos) > 0) {
      $this->videos = $videos['items'];
      $this->videos_perPage = $videos['perPage'];
      $this->videos_total = $videos['total'];

      $this->videos_pager = new Arraypager(null, 10);
      $this->videos_pager->setResultTotal($this->videos_total);
      $this->videos_pager->setPage($request->getParameter('page', 1));
      $this->videos_pager->init();
    } else {
      $this->videos = array();
      $this->videos_pager = '';
    }

    // check if a discussion object exists for this user (raves) (needed for comment creation and fetching)
    /*$content_id = $this->user->getOnesiteId();
    $this->contentId = $this->user->getOnesiteId();
    $this->discussionObject = DiscussionTable::getDiscussion(compact('content_id'));
    if ($this->discussionObject) {
      $reset_cache = $this->getUser()->getAttribute('clear_comment_cache', false);
      // fetch comments
      $c = $this->getComments(1, 2, $this->discussionObject['discussion_id'], $reset_cache);
      if (sizeof($c) > 0) {
        $this->comments = $c['items'];
        if ($reset_cache) {
          $this->getUser()->setAttribute('clear_comment_cache', false);
        }
      } else {
        $this->comments = array();
      }
    } else {
      $this->comments = array();
    }*/
	
	/*
    $this->bread_crumbs = array(
      'better recipes' => UrlToolkit::getDomainUri(),
      'cooks' => UrlToolkit::getDomainUri() . '/cooks',
      $this->user->getDisplayName() => UrlToolkit::getDomainUri() . '/cooks/' . $this->user->getDisplayName(),
      'videos' => null
    );
    */
  }
  
  public function executeVideos_paginate(sfWebRequest $request)
  {
  	$this->forward404Unless($request->isXmlHttpRequest());
	$userId = $request->getParameter('userId');
    
    $v = $this->rest->getVideos($request->getParameter('page', 1), 10, 'date', $userId);

    if (sizeof($v) > 0) {
      $videos = $v['items'];
      $videos_perPage = $v['perPage'];
      $videos_total = $v['total'];

      $videos_pager = new Arraypager(null, 10);
      $videos_pager->setResultTotal($videos_total);
      $videos_pager->setPage($request->getParameter('page', 1));
      $videos_pager->init();
    } else {
      $videos = array();
      $videos_pager = '';
    }
	
	$this->renderPartial('videoList', compact('userId', 'videos', 'videos_pager'));
	return sfView::NONE;
  }


  public function executePolls(sfWebRequest $request)
  {
    $this->user = $this->getRoute()->getObject();
    $this->my_profile = ($this->getUser()->isAuthenticated() && $this->getUser()->getId() === $this->user->getId()) ? true : false;
//    $this->redirectUnless($this->my_profile, $this->generateUrl('cook_profile', $this->user));
    $this->user->loadOnesite();

    $this->profile = $this->rest->viewUserDetail($this->user->getOnesiteId());
    //$this->points = $this->rest->getUserPoints($this->user->getOnesiteId());

    //$this->groups = $this->rest->getUserGroups($this->user->getOnesiteId(), 1, 5, 'member,moderator,owner');
    
    $this->userId = $this->user->getOnesiteId();
    $polls = $this->rest->getPolls($request->getParameter('page', 1), 10, null, null, null, $this->user->getOnesiteId());

    if (sizeof($polls) > 0) {
      $this->polls = $polls['items'];
      $this->polls_perPage = $polls['perPage'];
      $this->polls_total = $polls['total'];

      $this->polls_pager = new Arraypager(null, 10);
      $this->polls_pager->setResultTotal($this->polls_total);
      $this->polls_pager->setPage($request->getParameter('page', 1));
      $this->polls_pager->init();
    } else {
      $this->polls = array();
      $this->polls_pager = '';
    }

    // check if a discussion object exists for this user (raves) (needed for comment creation and fetching)
    /*$content_id = $this->user->getOnesiteId();
    $this->contentId = $this->user->getOnesiteId();
    $this->discussionObject = DiscussionTable::getDiscussion(compact('content_id'));
    if ($this->discussionObject) {
      $reset_cache = $this->getUser()->getAttribute('clear_comment_cache', false);
      // fetch comments
      $c = $this->getComments(1, 2, $this->discussionObject['discussion_id'], $reset_cache);
      if (sizeof($c) > 0) {
        $this->comments = $c['items'];
        if ($reset_cache) {
          $this->getUser()->setAttribute('clear_comment_cache', false);
        }
      } else {
        $this->comments = array();
      }
    } else {
      $this->comments = array();
    }*/
	
	/*
    $this->bread_crumbs = array(
      'better recipes' => UrlToolkit::getDomainUri(),
      'cooks' => UrlToolkit::getDomainUri() . '/cooks',
      $this->user->getDisplayName() => UrlToolkit::getDomainUri() . '/cooks/' . $this->user->getDisplayName(),
      'polls' => null
    );
    */
  }
  
  public function executePolls_paginate(sfWebRequest $request)
  {
  	$this->forward404Unless($request->isXmlHttpRequest());
	$userId = $request->getParameter('userId');
    
    $p = $this->rest->getPolls($request->getParameter('page', 1), 10, null, null, null, $userId);

    if (sizeof($p) > 0) {
      $polls = $p['items'];
      $polls_perPage = $p['perPage'];
      $polls_total = $p['total'];

      $polls_pager = new Arraypager(null, 10);
      $polls_pager->setResultTotal($polls_total);
      $polls_pager->setPage($request->getParameter('page', 1));
      $polls_pager->init();
    } else {
      $polls = array();
      $polls_pager = '';
    }
	
	$this->renderPartial('pollList', compact('userId', 'polls', 'polls_pager'));
	return sfView::NONE;
  }


  public function executeDiscussions(sfWebRequest $request)
  {
    $this->user = $this->getRoute()->getObject();
    $this->my_profile = ($this->getUser()->isAuthenticated() && $this->getUser()->getId() === $this->user->getId()) ? true : false;
//    $this->redirectUnless($this->my_profile, $this->generateUrl('cook_profile', $this->user));
    $this->user->loadOnesite();

    $this->profile = $this->rest->viewUserDetail($this->user->getOnesiteId());
    //$this->points = $this->rest->getUserPoints($this->user->getOnesiteId());
	$this->userId = $this->user->getOnesiteId();
    //$this->groups = $this->rest->getUserGroups($this->user->getOnesiteId(), 1, 5, 'member,moderator,owner');
    $discussions = $this->rest->getNetworkThreads($request->getParameter('page', 1), 10, 'date', 'DESC', null, null, 1, $this->user->getOnesiteId());

    if (sizeof($discussions) > 0) {
      $this->discussions = $discussions['items'];
      $this->discussions_perPage = $discussions['perPage'];
      $this->discussions_total = $discussions['total'];

      $this->discussions_pager = new Arraypager(null, 10);
      $this->discussions_pager->setResultTotal($this->discussions_total);
      $this->discussions_pager->setPage($request->getParameter('page', 1));
      $this->discussions_pager->init();
    } else {
      $this->discussions = array();
      $this->discussions_pager = '';
    }

    // check if a discussion object exists for this user (raves) (needed for comment creation and fetching)
    /*$content_id = $this->user->getOnesiteId();
    $this->contentId = $this->user->getOnesiteId();
    $this->discussionObject = DiscussionTable::getDiscussion(compact('content_id'));
    if ($this->discussionObject) {
      $reset_cache = $this->getUser()->getAttribute('clear_comment_cache', false);
      // fetch comments
      $c = $this->getComments(1, 2, $this->discussionObject['discussion_id'], $reset_cache);
      if (sizeof($c) > 0) {
        $this->comments = $c['items'];
        if ($reset_cache) {
          $this->getUser()->setAttribute('clear_comment_cache', false);
        }
      } else {
        $this->comments = array();
      }
    } else {
      $this->comments = array();
    }*/
  }
  
  
  public function executeDiscussions_paginate(sfWebRequest $request)
  {
  	$this->forward404Unless($request->isXmlHttpRequest());
	$userId = $request->getParameter('userId');
	
	$d = $this->rest->getNetworkThreads($request->getParameter('page', 1), 10, 'date', 'DESC', null, null, 1, $userId);

    if (sizeof($d) > 0) {
      $discussions = $d['items'];
      $discussions_perPage = $d['perPage'];
      $discussions_total = $d['total'];

      $discussions_pager = new Arraypager(null, 10);
      $discussions_pager->setResultTotal($discussions_total);
      $discussions_pager->setPage($request->getParameter('page', 1));
      $discussions_pager->init();
    } else {
      $discussions = array();
      $discussions_pager = '';
    }
	
	$this->renderPartial('discussionList', compact('userId', 'discussions', 'discussions_pager'));
	return sfView::NONE;
  }

  

  public function executeJournals(sfWebRequest $request)
  {
    $this->user = $this->getRoute()->getObject();
    $this->my_profile = ($this->getUser()->isAuthenticated() && $this->getUser()->getId() === $this->user->getId()) ? true : false;
//    $this->redirectUnless($this->my_profile, $this->generateUrl('cook_profile', $this->user));
    $this->user->loadOnesite();

    $this->profile = $this->rest->viewUserDetail($this->user->getOnesiteId());
    //$this->points = $this->rest->getUserPoints($this->user->getOnesiteId());

    //$this->groups = $this->rest->getUserGroups($this->user->getOnesiteId(), 1, 5, 'member,moderator,owner');
    
    $this->userId = $this->user->getOnesiteId();
    $journals = $this->rest->getBlogs($request->getParameter('page', 1), 10, $this->user->getOnesiteId(), 'date');

    if (sizeof($journals) > 0) {
      $this->journals = $journals['items'];
      $this->journals_perPage = $journals['perPage'];
      $this->journals_total = $journals['total'];

      $this->journals_pager = new Arraypager(null, 10);
      $this->journals_pager->setResultTotal($this->journals_total);
      $this->journals_pager->setPage($request->getParameter('page', 1));
      $this->journals_pager->init();
    } else {
      $this->journals = array();
      $this->journals_pager = '';
    }

    // check if a discussion object exists for this user (raves) (needed for comment creation and fetching)
    /*$content_id = $this->user->getOnesiteId();
    $this->contentId = $this->user->getOnesiteId();
    $this->discussionObject = DiscussionTable::getDiscussion(compact('content_id'));
    if ($this->discussionObject) {
      $reset_cache = $this->getUser()->getAttribute('clear_comment_cache', false);
      // fetch comments
      $c = $this->getComments(1, 2, $this->discussionObject['discussion_id'], $reset_cache);
      if (sizeof($c) > 0) {
        $this->comments = $c['items'];
        if ($reset_cache) {
          $this->getUser()->setAttribute('clear_comment_cache', false);
        }
      } else {
        $this->comments = array();
      }
    } else {
      $this->comments = array();
    }*/
	
	/*
    $this->bread_crumbs = array(
      'better recipes' => UrlToolkit::getDomainUri(),
      'cooks' => UrlToolkit::getDomainUri() . '/cooks',
      $this->user->getDisplayName() => UrlToolkit::getDomainUri() . '/cooks/' . $this->user->getDisplayName(),
      'journals' => null
    );*/
  }
  
  
  public function executeJournals_paginate(sfWebRequest $request)
  {
  	$this->forward404Unless($request->isXmlHttpRequest());
	$userId = $request->getParameter('userId');
    
    $j = $this->rest->getBlogs($request->getParameter('page', 1), 10, $userId, 'date');

    if (sizeof($j) > 0) {
      $journals = $j['items'];
      $journals_perPage = $j['perPage'];
      $journals_total = $j['total'];

      $journals_pager = new Arraypager(null, 10);
      $journals_pager->setResultTotal($journals_total);
      $journals_pager->setPage($request->getParameter('page', 1));
      $journals_pager->init();
    } else {
      $journals = array();
      $journals_pager = '';
    }
	
	$this->renderPartial('journalList', compact('userId', 'journals', 'journals_pager'));
	return sfView::NONE;
  }


  public function executeRaves(sfWebRequest $request)
  {
    $this->user = $this->getRoute()->getObject();
    $this->my_profile = ($this->getUser()->isAuthenticated() && $this->getUser()->getId() === $this->user->getId()) ? true : false;
//    $this->redirectUnless($this->my_profile, $this->generateUrl('cook_profile', $this->user));
    $this->user->loadOnesite();

    $this->profile = $this->rest->viewUserDetail($this->user->getOnesiteId());
    //$this->points = $this->rest->getUserPoints($this->user->getOnesiteId());

    //$this->groups = $this->rest->getUserGroups($this->user->getOnesiteId(), 1, 5, 'member,moderator,owner');
    // check if a discussion object exists for this user (raves) (needed for comment creation and fetching)
    $content_id = $this->user->getOnesiteId();
    $this->content_id = $this->user->getOnesiteId();
    $this->discussionObject = DiscussionTable::getDiscussion(compact('content_id'));
    if ($this->discussionObject) {
      $reset_cache = $this->getUser()->getAttribute('clear_comment_cache', false);
      // fetch comments
      $c = $this->getComments($request->getParameter('page', 1), 10, $this->discussionObject['discussion_id'], $reset_cache);

      if (sizeof($c) > 0) {
        $this->comments = $c['items'];
        $this->comments_perPage = $c['perPage'];
        $this->comments_total = $c['total'];

        $this->comments_pager = new Arraypager(null, 10);
        $this->comments_pager->setResultTotal($this->comments_total);
        $this->comments_pager->setPage($request->getParameter('page', 1));
        $this->comments_pager->init();
        if ($reset_cache) {
          $this->getUser()->setAttribute('clear_comment_cache', false);
        }
      } else {
        $this->comments = array();
        $this->comments_pager = '';
        $this->comments = '';
      }
    } else {
      $this->comments = array();
      $this->comments_pager = '';
      $this->comments = '';
    }
	
	/*
    $this->bread_crumbs = array(
      'better recipes' => UrlToolkit::getDomainUri(),
      'cooks' => UrlToolkit::getDomainUri() . '/cooks',
      $this->user->getDisplayName() => UrlToolkit::getDomainUri() . '/cooks/' . $this->user->getDisplayName(),
      'raves' => null
    );*/
  }
  
  
  public function executeRaves_paginate(sfWebRequest $request)
  {
  	$this->forward404Unless($request->isXmlHttpRequest());
    
    $content_id = $request->getParameter('content_id');
    $this->discussionObject = DiscussionTable::getDiscussion(compact('content_id'));
    if ($this->discussionObject) {
      $reset_cache = $this->getUser()->getAttribute('clear_comment_cache', false);
      // fetch comments
      $c = $this->getComments($request->getParameter('page', 1), 10, $this->discussionObject['discussion_id'], $reset_cache);

      if (sizeof($c) > 0) {
        $comments = $c['items'];
        $comments_perPage = $c['perPage'];
        $comments_total = $c['total'];

        $comments_pager = new Arraypager(null, 10);
        $comments_pager->setResultTotal($comments_total);
        $comments_pager->setPage($request->getParameter('page', 1));
        $comments_pager->init();
        if ($reset_cache) {
          $this->getUser()->setAttribute('clear_comment_cache', false);
        }
      } else {
        $comments = array();
        $comments_pager = '';
        $comments = '';
      }
    } else {
      $comments = array();
      $comments_pager = '';
      $comments = '';
    }
    
	
	$this->renderPartial('raveList', compact('content_id', 'comments', 'comments_pager'));
	return sfView::NONE;
  }

  

  public function executeRecipes(sfWebRequest $request)
  {
    $this->user = $this->getRoute()->getObject();
    $this->my_profile = ($this->getUser()->isAuthenticated() && $this->getUser()->getId() === $this->user->getId()) ? true : false;
//    $this->redirectUnless($this->my_profile, $this->generateUrl('cook_profile', $this->user));
    $this->user->loadOnesite();

    $this->profile = $this->rest->viewUserDetail($this->user->getOnesiteId());
    //$this->points = $this->rest->getUserPoints($this->user->getOnesiteId());

    $this->groups = $this->rest->getUserGroups($this->user->getOnesiteId(), 1, 5, 'member,moderator,owner');
	
	$this->userId = $this->user->getId();
    $this->recipes = new sfDoctrinePager('Recipe', '10');
    $this->recipes->setQuery(RecipeTable::getUserRecipes($this->user->getId()));
    $this->recipes->setPage($request->getParameter('page', 1));
    $this->recipes->init();

    // check if a discussion object exists for this user (raves) (needed for comment creation and fetching)
    /*$content_id = $this->user->getOnesiteId();
    $this->contentId = $this->user->getOnesiteId();
    $this->discussionObject = DiscussionTable::getDiscussion(compact('content_id'));
    if ($this->discussionObject) {
      $reset_cache = $this->getUser()->getAttribute('clear_comment_cache', false);
      // fetch comments
      $c = $this->getComments(1, 2, $this->discussionObject['discussion_id'], $reset_cache);
      if (sizeof($c) > 0) {
        $this->comments = $c['items'];
        if ($reset_cache) {
          $this->getUser()->setAttribute('clear_comment_cache', false);
        }
      } else {
        $this->comments = array();
      }
    } else {
      $this->comments = array();
    }*/
	
	/*
    $this->bread_crumbs = array(
      'better recipes' => UrlToolkit::getDomainUri(),
      'cooks' => UrlToolkit::getDomainUri() . '/cooks',
      $this->user->getDisplayName() => UrlToolkit::getDomainUri() . '/cooks/' . $this->user->getDisplayName(),
      'recipes' => null
    );*/
  }
  
  
  public function executeRecipes_paginate(sfWebRequest $request)
  {
  	$this->forward404Unless($request->isXmlHttpRequest());
	$userId = $request->getParameter('userId');
    $recipes = new sfDoctrinePager('Recipe', '10');
    $recipes->setQuery(RecipeTable::getUserRecipes($userId));
    $recipes->setPage($request->getParameter('page', 1));
    $recipes->init();
	
	$this->renderPartial('recipeList', compact('userId', 'recipes'));
	return sfView::NONE;
  }
  

  public function executeSavedRecipes(sfWebRequest $request)
  {
    $this->user = $this->getRoute()->getObject();
    $this->my_profile = ($this->getUser()->isAuthenticated() && $this->getUser()->getId() === $this->user->getId()) ? true : false;
//    $this->redirectUnless($this->my_profile, $this->generateUrl('cook_profile', $this->user));
    $this->user->loadOnesite();

    $this->profile = $this->rest->viewUserDetail($this->user->getOnesiteId());
    //$this->points = $this->rest->getUserPoints($this->user->getOnesiteId());

    $this->groups = $this->rest->getUserGroups($this->user->getOnesiteId(), 1, 5, 'member,moderator,owner');
    //$this->savedRecipes = $this->user->getSaved();
    $pageNo = $request->getParameter('page', 1);
    $recipeParams = array('user_id' => $this->user->getId(), 'folder' => 'saved', 'page_no' => $pageNo, 'results_per_page' => 5);
    $this->recipes = RecipeTable::getUserRecipesPaginated($recipeParams);

    // check if a discussion object exists for this user (raves) (needed for comment creation and fetching)
    $content_id = $this->user->getOnesiteId();
    $this->contentId = $this->user->getOnesiteId();
    $this->discussionObject = DiscussionTable::getDiscussion(compact('content_id'));
    if ($this->discussionObject) {
      $reset_cache = $this->getUser()->getAttribute('clear_comment_cache', false);
      // fetch comments
      $c = $this->getComments(1, 2, $this->discussionObject['discussion_id'], $reset_cache);
      if (sizeof($c) > 0) {
        $this->comments = $c['items'];
        if ($reset_cache) {
          $this->getUser()->setAttribute('clear_comment_cache', false);
        }
      } else {
        $this->comments = array();
      }
    } else {
      $this->comments = array();
    }
	
	/*
    $this->bread_crumbs = array(
      'better recipes' => UrlToolkit::getDomainUri(),
      'cooks' => UrlToolkit::getDomainUri() . '/cooks',
      $this->user->getDisplayName() => UrlToolkit::getDomainUri() . '/cooks/' . $this->user->getDisplayName(),
      'saved recipes' => null
    );*/
  }

  public function executeRaveredirect(sfWebRequest $request)
  {
    $this->getUser()->setReferrer($this->getRequest()->getReferer());
    $this->redirect('@signin');
    return sfView::NONE;
  }

  /**
   *
   * @param type $page
   * @param type $num
   * @param type $discussion_id
   * @return type 
   */
  protected function getComments($page, $num, $discussion_id, $reset_cache = false)
  {
    return $this->rest->getComments($page, $num, $discussion_id, 'date_created', 'DESC', $reset_cache);
  }

}
