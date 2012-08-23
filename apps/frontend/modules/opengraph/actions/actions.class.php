<?php

/**
 * opengraph actions.
 *
 * @package    betterrecipes
 * @subpackage opengraph
 * @author     Rusty Cage <rcage@resolute.com>
 */
class opengraphActions extends sfActions
{

  public function executeAddPrint(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $this->forward404Unless($recipe = $request->getParameter('recipe'));
    // note: TODO -> hook up open graph publish call if logged in user has FB credentials and has social turned "on" 

    $parts = explode('|', $recipe);
    $recipe_id = $parts[0];
    $recipe_title = $parts[1];
    $recipe_url = $parts[2];

    // if user is a Facebook user and has social sharing turned on
    if ($this->getUser()->hasFb() && $this->getUser()->isSocial() && $this->getUser()->getRegSourceAttribute('auth_token')) {
      if (!UserActionsTable::isPrinted($recipe_id, $this->getUser()->getId())) {
        $facebook_helper = new Facebook_helper($this->getGigya(), $this->getUser());
        $fb_object_id = $facebook_helper->post_action_recipe('Print', $recipe_url);
        $fb_user_id = $this->getUser()->getSocial('loginProviderUID');
      } else {
        $fb_object_id = null;
        $fb_user_id = null;
      }
    } else {
      $fb_object_id = null;
      $fb_user_id = null;
    }
    $user_id = $this->getUser()->getId();
    // push print action to UserActions table
    $id = UserActionsTable::addActionPrinted($recipe_id, $recipe_title, $user_id, $fb_user_id, $fb_object_id);
    // as per ET#6800, need to check how many "views" of log is stored in session (must be 5 to force log open)
    $views = Utilities::userLogCompletedIncrement();
    // evaluate if user has social "on" in session, if yes, return the ID to ajax caller so that activityCompleted module is displayed
    $notify = ( $this->getUser()->hasFb() && $this->getUser()->isSocial() ) ? true : false;
    if ($notify && isset($id) && $views == 5) {
      return $this->renderText(json_encode(array('id' => $id)));
    }
    return sfView::NONE;
  }

  public function executeAddSaved(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $this->forward404Unless($recipe_id = $request->getParameter('recipe_id'));
    $this->forward404Unless($recipe_title = urldecode($request->getParameter('recipe_title')));
    $this->forward404Unless($recipe_url = $request->getParameter('recipe_url'));

    // if user is a Facebook user and has social sharing turned on
    if ($this->getUser()->hasFb() && $this->getUser()->isSocial() && $this->getUser()->getRegSourceAttribute('auth_token')) {
      if (!UserActionsTable::isSaved($recipe_id, $this->getUser()->getId())) {
        $facebook_helper = new Facebook_helper($this->getGigya(), $this->getUser());
        $fb_object_id = $facebook_helper->post_action_recipe('Save', $recipe_url);
        $fb_user_id = $this->getUser()->getSocial('loginProviderUID');
      } else {
        $fb_object_id = null;
        $fb_user_id = null;
      }
    } else {
      $fb_object_id = null;
      $fb_user_id = null;
    }
    $user_id = $this->getUser()->getId();
    // push save action to UserActions table
    $id = UserActionsTable::addActionSaved($recipe_id, $recipe_title, $user_id, $fb_user_id, $fb_object_id);
    // as per ET#6800, need to check how many "views" of log is stored in session (must be 5 to force log open)
    $views = Utilities::userLogCompletedIncrement();
    // evaluate if user has social "on" in session, if yes, return the ID to ajax caller so that activityCompleted module is displayed
    $notify = ( $this->getUser()->hasFb() && $this->getUser()->isSocial() ) ? true : false;
    if ($notify && isset($id) && $views == 5) {
      return $this->renderText(json_encode(array('id' => $id)));
    }
    return sfView::NONE;
  }

  public function executeAddMade(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $this->forward404Unless($recipe_id = $request->getParameter('recipe_id'));
    $this->forward404Unless($recipe_title = urldecode($request->getParameter('recipe_title')));
    $this->forward404Unless($recipe_url = $request->getParameter('recipe_url'));

    // if user is a Facebook user and has social sharing turned on
    if ($this->getUser()->hasFb() && $this->getUser()->isSocial() && $this->getUser()->getRegSourceAttribute('auth_token')) {
      if (!UserActionsTable::isMade($recipe_id, $this->getUser()->getId())) {
        $facebook_helper = new Facebook_helper($this->getGigya(), $this->getUser());
        $fb_object_id = $facebook_helper->post_action_recipe('Made', $recipe_url);
        if (!is_string($fb_object_id)) {
          $fb_object_id = null;
        }
        $fb_user_id = $this->getUser()->getSocial('loginProviderUID');
      } else {
        $fb_object_id = null;
        $fb_user_id = null;
      }
    } else {
      $fb_object_id = null;
      $fb_user_id = null;
    }
    $user_id = $this->getUser()->getId();
    // push save action to UserActions table
    $id = UserActionsTable::addActionMade($recipe_id, $recipe_title, $user_id, $fb_user_id, $fb_object_id);
    // as per ET#6800, need to check how many "views" of log is stored in session (must be 5 to force log open)
    $views = Utilities::userLogCompletedIncrement();
    // evaluate if user has social "on" in session, if yes, return the ID to ajax caller so that activityCompleted module is displayed
    $notify = ( $this->getUser()->hasFb() && $this->getUser()->isSocial() ) ? true : false;
    if ($notify && isset($id) && $views == 5) {
      return $this->renderText(json_encode(array('id' => $id)));
    }
    return sfView::NONE;
  }

  public function executeAddRecommend(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $this->forward404Unless($recipe_id = $request->getParameter('recipe_id'));
    $this->forward404Unless($recipe_title = urldecode($request->getParameter('recipe_title')));
    $this->forward404Unless($recipe_url = $request->getParameter('recipe_url'));

    // if user is a Facebook user and has social sharing turned on
    if ($this->getUser()->hasFb() && $this->getUser()->isSocial() && $this->getUser()->getRegSourceAttribute('auth_token')) {
      if (!UserActionsTable::isRecommended($recipe_id, $this->getUser()->getId())) {
        $facebook_helper = new Facebook_helper($this->getGigya(), $this->getUser());
        $fb_object_id = $facebook_helper->post_action_recipe('Recommend', $recipe_url);
        $fb_user_id = $this->getUser()->getSocial('loginProviderUID');
      } else {
        $fb_object_id = null;
        $fb_user_id = null;
      }
    } else {
      $fb_object_id = null;
      $fb_user_id = null;
    }
    $user_id = $this->getUser()->getId();
    // push save action to UserActions table
    $id = UserActionsTable::addActionRecommended($recipe_id, $recipe_title, $user_id, $fb_user_id, $fb_object_id);
    // as per ET#6800, need to check how many "views" of log is stored in session (must be 5 to force log open)
    $views = Utilities::userLogCompletedIncrement();
    // evaluate if user has social "on" in session, if yes, return the ID to ajax caller so that activityCompleted module is displayed
    $notify = ( $this->getUser()->hasFb() && $this->getUser()->isSocial() ) ? true : false;
    if ($notify && isset($id) && $views == 5) {
      return $this->renderText(json_encode(array('id' => $id)));
    }
    return sfView::NONE;
  }

  public function executeAddVotedPoll(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $this->forward404Unless($option_id = $request->getParameter('option_id'));
    $this->forward404Unless($poll_title = urldecode($request->getParameter('poll_title')));
    $this->forward404Unless($option_title = $request->getParameter('option_title'));

    // note: anonymous voting is possible so we need to check if user is authenticated before continuing
    if ($this->getUser()->isAuthenticated()) {

      // note: TODO -> hook up open graph publish call if logged in user has FB credentials and has social turned "on" 

      $fb_user_id = null;
      $fb_object_id = null;
      $user_id = $this->getUser()->getId();
      // push save action to UserActions table
      $id = UserActionsTable::addVotedPoll($option_id, $option_title, $poll_title, $user_id, $fb_user_id, $fb_object_id);
      // as per ET#6800, need to check how many "views" of log is stored in session (must be 5 to force log open)
      $views = Utilities::userLogCompletedIncrement();
      // note: TODO - evaluate if user has social "on" in session, if yes, return the ID to ajax caller so that activityCompleted module is displayed
      $notify = ( $this->getUser()->hasFb() && $this->getUser()->isSocial() ) ? true : false;
      if ($notify && isset($id) && $views == 5) {
        return $this->renderText(json_encode(array('id' => $id)));
      }
    }
    return sfView::NONE;
  }

  public function executeAddVotedRecipeContest(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $this->forward404Unless($recipe_id = $request->getParameter('recipe_id'));
    $this->forward404Unless($recipe_title = urldecode($request->getParameter('recipe_title')));
    $this->forward404Unless($contestant_id = $request->getParameter('contestant_id'));
    $this->forward404Unless($contest_url = $request->getParameter('contest_url'));

    // if user is a Facebook user and has social sharing turned on
    if ($this->getUser()->hasFb() && $this->getUser()->isSocial() && $this->getUser()->getRegSourceAttribute('auth_token')) {
      if (!UserActionsTable::isEnteredContest($contestant_id, $this->getUser()->getId())) {
        $facebook_helper = new Facebook_helper($this->getGigya(), $this->getUser());
        $fb_object_id = $facebook_helper->post_action_recipe_contest('VotedFor', $contest_url);
        $fb_user_id = $this->getUser()->getSocial('loginProviderUID');
      } else {
        $fb_object_id = null;
        $fb_user_id = null;
      }
    } else {
      $fb_object_id = null;
      $fb_user_id = null;
    }
    $user_id = $this->getUser()->getId();
    // push save action to UserActions table
    $id = UserActionsTable::addVotedRecipeContest($recipe_id, $recipe_title, $contestant_id, $user_id, $fb_user_id, $fb_object_id);
    // as per ET#6800, need to check how many "views" of log is stored in session (must be 5 to force log open)
    $views = Utilities::userLogCompletedIncrement();
    // note: TODO - evaluate if user has social "on" in session, if yes, return the ID to ajax caller so that activityCompleted module is displayed
    $notify = ( $this->getUser()->hasFb() && $this->getUser()->isSocial() ) ? true : false;
    if ($notify && isset($id) && $views == 5) {
      return $this->renderText(json_encode(array('id' => $id)));
    }
    return sfView::NONE;
  }

  public function executeAddEnteredContest(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $this->forward404Unless($contestant_id = $request->getParameter('contestant_id'));
    $this->forward404Unless($contest_title = $request->getParameter('contest_title'));
    $contestant = Doctrine_Core::getTable('Contestant')->find($contestant_id);
    $contest = $contestant->getContest();
    $contest_url = UrlToolkit::getRoute('contests_detail', array('slug' => $contest->getSlug()));

    // if user is a Facebook user and has social sharing turned on
    if ($this->getUser()->hasFb() && $this->getUser()->isSocial() && $this->getUser()->getRegSourceAttribute('auth_token')) {
      if (!UserActionsTable::isEnteredContest($contestant_id, $this->getUser()->getId())) {
        $facebook_helper = new Facebook_helper($this->getGigya(), $this->getUser());
        $fb_object_id = $facebook_helper->post_action_recipe_contest('Enter', $contest_url);
        $fb_user_id = $this->getUser()->getSocial('loginProviderUID');
      } else {
        $fb_object_id = null;
        $fb_user_id = null;
      }
    } else {
      $fb_object_id = null;
      $fb_user_id = null;
    }
    $user_id = $this->getUser()->getId();
    // push save action to UserActions table
    $id = UserActionsTable::addActionEnteredContest($contestant_id, $contest_title, $user_id, $fb_user_id, $fb_object_id);
    // as per ET#6800, need to check how many "views" of log is stored in session (must be 5 to force log open)
    $views = Utilities::userLogCompletedIncrement();
    // note: TODO - evaluate if user has social "on" in session, if yes, return the ID to ajax caller so that activityCompleted module is displayed
    $notify = ( $this->getUser()->hasFb() && $this->getUser()->isSocial() ) ? true : false;
    if ($notify && isset($id) && $views == 5) {
      return $this->renderText(json_encode(array('id' => $id)));
    }
    return sfView::NONE;
  }

  public function executePaginateFriendRibbon(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $this->forward404Unless($page_no = $request->getParameter('page_no'));
    $this->forward404Unless($results_per_page = $request->getParameter('results_per_page'));
    $this->renderComponent('opengraph', 'friendRibbon', array('page_no' => $page_no, 'results_per_page' => $results_per_page));
    return sfView::NONE;
  }

  public function executePaginateUserRailActivity(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $this->forward404Unless($page_no = $request->getParameter('page_no'));
    $this->forward404Unless($results_per_page = $request->getParameter('results_per_page'));
    $this->renderComponent('opengraph', 'userRailActivity', array('page_no' => $page_no, 'results_per_page' => $results_per_page));
    return sfView::NONE;
  }

  public function executePaginateUserRailActivityLog(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $this->forward404Unless($page_no = $request->getParameter('page_no'));
    $this->forward404Unless($results_per_page = $request->getParameter('results_per_page'));
    $this->renderComponent('opengraph', 'userRailActivityLog', array('page_no' => $page_no, 'results_per_page' => $results_per_page));
    return sfView::NONE;
  }

  public function executeDeleteActivity(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $this->forward404Unless($id = $request->getParameter('id'));
    // note: I don't know if we are supposed to delete the activity from the Facebook timeline TBD
    $actionRow = Doctrine_Core::getTable('UserActions')->find($id);
    if (!is_null($actionRow->getFbObjectId()) && $this->getUser()->getRegSourceAttribute('auth_token')) {
      $facebook_helper = new Facebook_helper($this->getGigya(), $this->getUser());
      $facebook_helper->delete_post($actionRow->getFbObjectId());
    }

    $params = array('user_id' => $this->getUser()->getId(), 'id' => $id);
    UserActionsTable::deactivateActivity($params);
    return sfView::NONE;
  }

  public function executeOpenActivityCompleted(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $this->forward404Unless($id = $request->getParameter('id'));
    $this->renderComponent('opengraph', 'userRailActivityCompleted', array('id' => $id));
    return sfView::NONE;
  }

}