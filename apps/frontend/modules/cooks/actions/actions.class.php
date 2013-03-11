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
    if ($this->getUser()->isAuthenticated()) {
      $this->user = $this->getUser();
    } else {
      $this->user_data = null;
    }
  }

  /**
   * Executes profile action
   *
   * @param sfRequest $request A request object
   */
  public function executeProfile(sfWebRequest $request)
  {
    // no need to handle is_active and 404 here because it is handled at the route

    $display_name = $request->getParameter('display_name');
    $this->my_profile = ($this->getUser()->isAuthenticated() && $this->getUser()->getIsActive() && $this->getUser()->getDisplayName() === $display_name) ? true : false;

    $this->user = UserTable::getUserByDisplayName($display_name);
    $this->forward404Unless($this->user);
//  $this->user->setRegServicesData();
    $response = $this->getResponse();
    $response->setTitle($display_name . ' | Cooks | Better Recipes');

    //Title Tag & Meta Data
    $this->getResponse()->setTitle(Microformat::correct_caps($display_name . '| Cooks | Better Recipes'));

    $reset_cache = $this->getUser()->getAttribute('clear_friend_cache', false);
    if ($reset_cache) {
      $this->getUser()->setAttribute('clear_friend_cache', false);
    }

    $this->bread_crumbs = array(
      'better recipes' => UrlToolkit::getDomainUri(),
      $display_name => null
    );


    /**
     * Omniture
     */
    $this->getOmniture()->setMany(array(
      'pageName' => sprintf('MixingBowl:User:%s:%s', $this->my_profile ? 'Private' : 'Public', $this->user_data['display_name']),
      'server' => 'www.betterrecipes.com',
      'channel' => 'Mixing Bowl',
      'prop1' => 'MixingBowl:User',
      'prop2' => 'MixingBowl:User:' . ($this->my_profile ? 'Private' : 'Public'),
      'prop7' => $this->getUser()->isAuthenticated(),
      'prop11' => '', // partner name - sponsored profile - omniture_tbd
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $this->getRequest()->getUri(),
      'eVar9' => sprintf('MixingBowl:User:%s:%s', $this->my_profile ? 'Private' : 'Public', $this->user_data['display_name']),
      'eVar14' => 'Mixing Bowl',
      'eVar24' => $this->getUser()->isAuthenticated() ? true : false,
    ));
    // Set adtag header variables: adchild1id
//    $this->getContext()->setAdChild1Id($this->subdir);
  }

  /**
   *
   * @param sfWebRequest $request 
   */
  public function executeEditProfile(sfWebRequest $request)
  {
    $display_name = $request->getParameter('display_name');
    $user = $this->getUser();
    $this->my_profile = ($user->isAuthenticated() && $user->getIsActive() && $user->getDisplayName() === $display_name) ? true : false;
    $this->user = UserTable::getUserByDisplayName($display_name);
    $this->redirectUnless($this->my_profile, UrlToolkit::getUrl('User', compact('display_name')));
    $user_data = $user->getUserData();

    $user_data['user_id'] = $user_data['id'];
    $this->userForm = new UserProfileForm($user_data);
    if ($request->isMethod(sfRequest::POST)) {
      $this->userForm->bind($request->getParameter($this->userForm->getName()), $request->getFiles($this->userForm->getName()));
      if ($this->userForm->isValid()) {
        $this->userForm->save();
        $this->getUser()->setFlash('notice', 'Your profile was saved (it may take up to 10 minutes to update the avatar)');
        //   $this->redirect('cook_profile_edit', compact('display_name'));
      }
    }

    /**
     * Omniture
     */
    $this->getOmniture()->setMany(array(
      'pageName' => sprintf('MixingBowl:User:%s:%s', 'EditSettings', $display_name),
      'server' => 'www.betterrecipes.com',
      'channel' => 'Mixing Bowl',
      'prop1' => 'MixingBowl:User',
      'prop2' => 'MixingBowl:User:' . 'EditSettings',
      'prop7' => $this->getUser()->isAuthenticated(),
      'prop11' => '', // partner name - sponsored profile - omniture_tbd
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $this->getRequest()->getUri(),
      'eVar9' => sprintf('MixingBowl:User:%s:%s', 'EditSettings', $display_name),
      'eVar14' => 'Mixing Bowl',
      'eVar18' => $this->getUser()->isAuthenticated() ? $this->getUser()->getRegSource() : '',
      'eVar24' => $this->getUser()->isAuthenticated() ? true : false,
      'eVar26' => '', // party ID - omniture_tbd
      'eVar32' => $this->getUser()->isAuthenticated() ? $this->getUser()->getProfileId() : ''
    ));

    // Set adtag header variables: adchild1id
    $this->getContext()->setAdChild1Id($display_name);
  }

  /**
   *
   * @param sfWebRequest $request 
   */
  public function executeToggleSocial(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $sf_user = $this->getUser();
    $user = Doctrine_Core::getTable('User')->findOneById($sf_user->getId());
    $user->setFbShare($request->getParameter('switch'));
    $user->save();
    $user_data = $sf_user->getUserData();
    $user_data['fb_share'] = $request->getParameter('switch');
    $sf_user->setAttribute('user_data', $user_data);
    header('Content-type: application/json');
    $this->renderText(json_encode(array('result' => true)));
    return sfView::NONE;
  }

  public function executeRemoveFacebook(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $sf_user = $this->getUser();
    $user = Doctrine_Core::getTable('User')->findOneById($sf_user->getId());
    $user->setFbShare(0);
    $user->save();
    $user_data = $sf_user->getUserData();
    $user_data['fb_share'] = 0;
    $sf_user->setAttribute('user_data', $user_data);
    $sf_user->removeRegSourceAttribute('auth_token_expire');
    $sf_user->removeRegSourceAttribute('auth_token');
    $sf_user->removeRegSourceAttribute('gigya_UID');
    header('Content-type: application/json');
    $this->renderText(json_encode(array('result' => true)));
    return sfView::NONE;
  }

  public function executeSearch(sfWebRequest $request)
  {
//    $this->forward404Unless($request->isXmlHttpRequest());
    sfConfig::set('sf_web_debug', false);

    $limit = $request->getParameter('limit', 500);
    $term = $request->getParameter('q');
    $params = $request->getParameter('params');

    $q = UserTable::getInstance()->createQuery('user')
      ->addWhere('user.display_name LIKE ?', $term . '%')
      ->orderBy('user.display_name ASC')
      ->limit($limit);

    $users = $q->execute(array(), Doctrine_Core::HYDRATE_ARRAY);

    $this->renderText(json_encode(array('results' => $users)));

    return sfView::NONE;
  }

  public function executeRecipes(sfWebRequest $request)
  {
    $display_name = $request->getParameter('display_name');
    $this->user = UserTable::getUserByDisplayName($display_name);
    $this->forward404Unless($this->user);
    $this->my_profile = ($this->getUser()->isAuthenticated() && $this->getUser()->getId() === $this->user->getId()) ? true : false;

    $this->recipes = new sfDoctrinePager('Recipe', '5');
    $this->recipes->setQuery(RecipeTable::getUserRecipes($this->user->getId()));
    $this->recipes->setPage($request->getParameter('page', 1));
    $this->recipes->init();

    $this->bread_crumbs = array(
      'better recipes' => UrlToolkit::getDomainUri(),
      $display_name => UrlToolkit::getDomainUri() . '/cooks/' . $display_name,
      'recipes' => null
    );

    // Set adtag header variables: adchild1id
    $this->getContext()->setAdChild1Id($this->profile['subdir']);
  }

  public function executeSavedRecipes(sfWebRequest $request)
  {
    $display_name = $request->getParameter('display_name');
    $this->user = UserTable::getUserByDisplayName($display_name);
    $this->forward404Unless($this->user);
    $this->my_profile = ($this->getUser()->isAuthenticated() && $this->getUser()->getId() === $this->user->getId()) ? true : false;

    //$this->savedRecipes = $this->user->getSaved();
    $pageNo = $request->getParameter('page', 1);
    $recipeParams = array('user_id' => $this->user->getId(), 'folder' => 'saved', 'page_no' => $pageNo, 'results_per_page' => 5);
    $this->recipes = RecipeTable::getUserRecipesPaginated($recipeParams);
    $this->bread_crumbs = array(
      'better recipes' => UrlToolkit::getDomainUri(),
      $display_name => UrlToolkit::getDomainUri() . '/cooks/' . $display_name,
      'saved recipes' => null
    );
    // Set adtag header variables: adchild1id
    $this->getContext()->setAdChild1Id($display_name);
  }

}
