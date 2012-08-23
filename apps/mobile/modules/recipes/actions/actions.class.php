<?php

/**
 * recipes actions.
 *
 * @package    betterrecipes
 * @subpackage recipes
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class recipesActions extends sfActions
{
  protected $reroutes = array(
    'breakfast|low-fatbreakfastrecipes' => 'lowfat|low-fatbreakfastrecipes',
    'breakfast|diabeticbreakfastrecipes' => 'diabetic|diabeticbreakfastrecipes',
    'chicken|top-10' => 'chicken|top-ten',
    'christmas|dessert-recipes' => 'christmas|christmas-dessert-recipes',
    'dessert|cakes' => 'cake|easycakerecipes',
    'soup|chickensouprecipes' => 'chicken|chickensouprecipes',
    'mexican|mexicanchickenrecipes' => 'chicken|mexicanchickenrecipes',
    'cookie|holidaycookierecipes' => 'christmas|christmascookierecipes',
    'dessert|cookies' => 'cookie|dropcookierecipes',
    'halloween|halloweenbrews' => 'halloween|spookydrinkrecipes',
    'beef|beefsauces&gravyrecipes' => 'beef|beefsauces-gravyrecipes',
    'beef|beefsoups&stewrecipes' => 'beef|beefsoups-stewrecipes',
    'chicken|chickenglazes&rubs' => 'chicken|chickenglazes-rubs',
    'crockpot|crock-potdessert&snackrecipes' => 'crockpot|crock-potdessert-snackrecipes',
    'crockpot|crock-potsoup&stewrecipes' => 'crockpot|crock-potsoup-stewrecipes',
    'dessert|custard&pudding' => 'dessert|custard-pudding',
    'dessert|icecream&sorbets' => 'dessert|icecream-sorbets',
    'dessert|pies&pastries' => 'dessert|pies-pastries',
    "easter|easterkids'recipes" => 'easter|easterkids-recipes',
    'grilling|grilledburgers&brats' => 'grilling|grilledburgers-brats',
    'grilling|grilledchicken&turkeyrecipes' => 'grilling|grilledchicken-turkeyrecipes',
    'lowcarb|lowcarbbeef,porkandlamb' => 'lowcarb|lowcarbbeef-porkandlamb',
    'mexican|mexicanappetizer&drinkrecipes' => 'mexican|mexicanappetizer-drinkrecipes',
    'mexican|mexicanrice,beans&eggs' => 'mexican|mexicanrice-beans-eggs',
    'soup|chowders,bisques,andgumbos' => 'soup|chowdersbisquesandgumbos'
  );

  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $host_parts = explode('.', $request->getHost());
    $this->forward404Unless((UrlToolkit::getDomain() == $request->getHost() || $host_parts[0] == 'www'));
    $this->categories = $this->getCategories();
    $params = array('is_global' => 1, 'is_mobile' => 1);
    $this->recipes = RecipeTable::getList($params);
    //$this->recipe_wonder = $this->getOnesite()->getRest()->recipeLandingWonder();
    // meta
    $this->setSeoParams('category');

    /**
     * Omniture
     */
    $this->getOmniture()->setMany(array(
      'pageName' => 'Category:Recipe',
      'server' => 'www.betterrecipes.com',
      'channel' => 'Recipe',
      'prop7' => $this->getUser()->isAuthenticated(),
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $request->getUri(),
      'eVar9' => 'Category:Recipe',
      'eVar14' => 'Recipe',
      'eVar24' => $this->getUser()->isAuthenticated(),
    ));
  }

  /**
   * Executes photos action
   *
   * @param sfRequest $request A request object
   */
  public function executePhotos(sfWebRequest $request)
  {
    $this->photos = PhotoTable::getRecipePhotos($request->getParameter('recipe_id'));
  }

  /**
   * Executes newphoto action
   *
   * @param sfRequest $request A request object
   */
  public function executeNewphoto(sfWebRequest $request)
  {
    sfConfig::set('sf_web_debug', false);
    $this->form = new photoForm();
    $recipe_id = $request->getParameter('recipe_id');
    $this->form->getWidget('recipe_id')->setAttribute('value', $recipe_id);
    if ($request->isMethod(sfRequest::POST)) {
      $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
      if ($this->form->isValid()) {
        $photo = $this->form->create();
        $this->saved = true;
      }
    }
  }

  /**
   * Executes mixingbowl action
   *
   * @param sfRequest $request A request object
   */
  public function executeMixingbowl(sfWebRequest $request)
  {
    $legacy_id = $request->getParameter('m', 0);
    $this->forward404Unless($recipe = Doctrine_Core::getTable('Recipe')->findOneBySourceAndLegacyIdAndIsActive('mb', $legacy_id, 1));
    // Set a daily log for MB redirects
    if ($log = Doctrine_Core::getTable('MbForwardLog')->find(array($request->getUri(), date('Y-m-d')))) {
      $log->setCounter($log->getCounter() + 1);
      $log->save();
    } else {
      $log = new MbForwardLog();
      $log->setUrl($request->getUri());
      $log->setDate(date('Y-m-d'));
      $log->setCounter(1);
      $log->save();
    }
    $this->redirect(UrlToolkit::getUrl($recipe));
  }

  /**
   * Executes category action
   *
   * @param sfRequest $request A request object
   */
  public function executeCategory(sfWebRequest $request)
  {
    $host_parts = explode('.', $request->getHost());
    $this->forward404Unless($this->category = Doctrine_Core::getTable('Category')->findOneBySlug($host_parts[0]));
    $this->getResponse()->setTitle($this->category->getName());
    $this->recipes = $this->getCatlevelRecipes($this->category->getId());
    $this->stories = $this->getStories($this->category->getId());
    $this->slideshows = $this->getSlideshows($this->category->getId());
    $this->getResponse()->setTitle(ucwords($this->category->getName() . ' | Recipes | Better Recipes'));
    // meta
    $this->setSeoParams($this->category);

    /**
     * Omniture
     */
    $this->getOmniture()->setMany(array(
      'pageName' => 'Recipe:' . ucwords($this->category->getName()),
      'server' => 'www.betterrecipes.com',
      'channel' => 'Recipe',
      'prop1' => 'Recipe:' . ucwords($this->category->getName()),
      'prop7' => $this->getUser()->isAuthenticated(),
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $request->getUri(),
      'eVar9' => 'Recipe:' . ucwords($this->category->getName()),
      'eVar14' => 'Recipe',
      'eVar24' => $this->getUser()->isAuthenticated(),
    ));
  }

  /**
   * Executes subCategory action
   *
   * @param sfRequest $request A request object
   */
  public function executeSubcategory(sfWebRequest $request)
  {
    $host_parts = explode('.', $request->getHost());
    $this->forward404Unless(count($host_parts) > 1);
    $path_parts = explode('.', ltrim($request->getPathInfo(), '/'));
    if (isset($this->reroutes[$host_parts[0] . '|' . $path_parts[0]])) {
      $newroute_parts = explode('|', $this->reroutes[$host_parts[0] . '|' . $path_parts[0]]);
      $this->redirect(UrlToolkit::getProtocol() . $newroute_parts[0] . '.' . UrlToolkit::getDomain() . '/' . $newroute_parts[1] . '.html');
    }
    $category = Doctrine_Core::getTable('Category')->findOneBySlug($host_parts[0]);
    if ($category) {
      $subcategory = Doctrine_Core::getTable('Category')->findOneBySlugAndParentIdAndIsActive($path_parts[0], $category->getId(), 1);
      if ($subcategory) {
        $this->category = $subcategory;
      } else {
        $request->setParameter('category_id', $category->getId());
        $request->setParameter('slug', $path_parts[0]);
        $this->forward('articles', 'detail');
      }
    }
    $this->forward404Unless($this->category);
    $this->recipes = $this->getCatlevelRecipes($this->category->getId());
    $this->recent_recipes = RecipeTable::getRecentRecipesPaginated($subcategory->getId(), 1, 10);

    // fetch daily dish items by tag if subcategory contains a valid daily dish tag
    /* if ( !is_null($subcategory->getDailyDishTag()) ) {
      $d = new DailydishWp();
      $dish = $d->getFeed($subcategory->getDailyDishTag(), 1, 10, 'tag');
      if (sizeof($dish)>0) {
      $this->dish_tag = $subcategory->getDailyDishTag();
      $this->dish_items = $dish['items'];
      $this->dish_perPage = 10;
      $this->dish_total = $dish['total'];

      $this->dish_pager = new Arraypager(null, 10);
      $this->dish_pager->setResultTotal($this->dish_total);
      $this->dish_pager->setPage(1);
      $this->dish_pager->init();

      } else {
      $this->dish_tag = '';
      $this->dish_items = array();
      $this->dish_pager = '';
      }
      } else {
      $this->dish_tag = '';
      $this->dish_items = array();
      $this->dish_pager = '';
      } */

    $this->getResponse()->setTitle(ucwords($subcategory->getName()) . ' | ' . ucwords($category->getName()) . ' | Recipes | Better Recipes');

    // meta
    $this->setSeoParams($this->category);

    /**
     * Omniture
     */
    $this->getOmniture()->setMany(array(
      'pageName' => 'Recipe:' . ucwords($category->getName()) . ':' . ucwords($subcategory->getName()),
      'server' => 'www.betterrecipes.com',
      'channel' => 'Recipe',
      'prop1' => 'Recipe:' . ucwords($category->getName()),
      'prop2' => 'Recipe:' . ucwords($category->getName()) . ':' . ucwords($subcategory->getName()),
      'prop7' => $this->getUser()->isAuthenticated(),
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $request->getUri(),
      'eVar9' => 'Recipe:' . ucwords($category->getName()) . ':' . ucwords($subcategory->getName()),
      'eVar14' => 'Recipe',
      'eVar24' => $this->getUser()->isAuthenticated(),
    ));
  }

  /**
   * Executes detail action
   *
   * @param sfRequest $request A request object
   */
  public function executeDetail(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated()) {
      $this->user_id = $this->getUser()->getOnesiteId();
    } else {
      $this->user_id = null;
    }
    $this->forward404Unless($category_recipe = CategoryRecipeTable::getCategoryRecipe($request->getParameter('category_id'), $request->getParameter('slug')));
    $this->recipe = $category_recipe->getRecipe();
    // Increase the view count by one
    $this->recipe->setViews($this->recipe->getViews() + 1);
    $this->recipe->save();
    //Get contest recipe is entered in
    $this->currentContest = $this->recipe->getCurrentContest();
    if ($this->currentContest) {
      //Set PREV button for prev ranked contestant
      $this->recipePrev = $this->currentContest->getPreviousContestantRecipe();
      //Set NEXT button for next ranked contestant
      $this->recipeNext = $this->currentContest->getNextContestantRecipe();
      //Show vote button is user has not voted yet (based on uid)
      $uid = $request->getCookie('uid');
      $contestant = Doctrine::getTable('Contestant')->createQuery('c')->where('c.recipe_id = ?', $this->recipe->getId())->fetchOne();
      $this->showVoteButton = VoteTable::uidCheck($contestant->getId(), $uid);
    }
    ($this->getUser()->getFlash('sharebar_popup') == 'true') ? $this->showPopup = true : $this->showPopup = false;
    $this->msg = $this->getUser()->getFlash('msg');

    $subcategory = $category_recipe->getCategory();
    $category = $subcategory->getParent();
    if ($this->getUser()->isAuthenticated()) {
      $this->user_rating = RateTable::getUserRating($this->recipe->getId(), $this->getUser()->getAttribute('id'));
      $this->is_saved = SavedTable::isSaved($this->recipe->getId(), $this->getUser()->getAttribute('id'));
    } else {
      $recipe_ratings = $this->getUser()->getAttribute('recipe_ratings');
      $this->user_rating = isset($recipe_ratings[$this->recipe->getId()]) ? $recipe_ratings[$this->recipe->getId()] : null;
    }
    $this->categories = $this->getCategories();

    $this->getResponse()->setTitle(Microformat::correct_caps($this->recipe->getName()));
    $this->getResponse()->addMeta('keywords', $this->recipe->getKeywords(), true);
    $this->getResponse()->addMeta('description', $this->recipe->getIntroduction(), true);

    $content_id = $this->recipe->getId();
    $this->content_id = $content_id;
    // check if a discussion object exists for this recipe entry (needed for comment creation and fetching)
    $this->discussionObject = DiscussionTable::getDiscussion(compact('content_id'));
    if ($this->discussionObject) {
      $reset_cache = $this->getUser()->getAttribute('clear_comment_cache', false);
      // fetch comments
      $c = $this->getOnesite()->getRest()->getComments($request->getParameter('page', 1), 9, $this->discussionObject['discussion_id'], 'date_created', 'DESC', $reset_cache);

      $this->comments = isset($c['items']) ? $c['items'] : false;
      $this->comments_perPage = isset($c['perPage']) ? $c['perPage'] : false;
      $this->comments_total = isset($c['total']) ? $c['total'] : false;

      $this->comments_pager = new Arraypager(null, 9);
      $this->comments_pager->setResultTotal($this->comments_total);
      $this->comments_pager->setPage($request->getParameter('page', 1));
      $this->comments_pager->init();

      if ($reset_cache) {
        $this->getUser()->setAttribute('clear_comment_cache', false);
      }
    } else {
      $this->comments = array();
      $this->comments_pager = '';
    }

    // meta
    $this->setSeoParams($this->recipe);

    if ($this->getUser()->getAttribute('upload_recipe_omni', false)) {
      //New Recipe creation omniture
      $omniParams = $this->getUser()->getAttribute('upload_recipe_omni', false);
      $this->getOmniture()->setMany(array(
        'pageName' => 'Recipe:AddRecipe:New',
        'server' => 'www.betterrecipes.com',
        'channel' => 'Recipe',
        'prop1' => 'Recipe:AddRecipe',
        'prop7' => $omniParams['prop7'],
        'prop18' => 'betterrecipes',
        'prop19' => 'Food',
        'prop20' => $omniParams['prop20'],
        'eVar9' => 'Recipe:AddRecipe:New',
        'eVar14' => 'Recipe',
        'eVar24' => $omniParams['prop7']
      ));
      $this->getUser()->setFlash('notice', 'Your recipe has been successfully uploaded.');
      $this->getUser()->setFlash('onUpload', 'recipe');
      $this->getUser()->setAttribute('upload_recipe_omni', false);

      //Detail Page Omniture
      $pageName = 'Recipe:view:' . $this->recipe->getSlug();
      $prop1 = 'Recipe:' . ucwords($category->getName());
      $prop2 = 'Recipe:' . ucwords($category->getName()) . ':' . ucwords($subcategory->getName());
      $this->getUser()->isAuthenticated() ? $prop7 = true : $prop7 = false;
      $this->recipe->getSponsorId() ? $prop11 = $this->recipe->getSponsor()->getName() : $prop11 = '';
      $prop20 = $request->getUri();
      $this->omniParams = array('pageName' => $pageName, 'prop1' => $prop1, 'prop2' => $prop2, 'prop7' => $prop7, 'prop11' => $prop11, 'prop20' => $prop20);
    } else {
      // Omniture
      $this->getOmniture()->setMany(array(
        'pageName' => 'Recipe:view:' . $this->recipe->getSlug() . ($this->recipe->hasPhoto() ? ':photo' : ''),
        'server' => 'www.betterrecipes.com',
        'channel' => 'Recipe',
        'prop1' => 'Recipe:' . ucwords($category->getName()),
        'prop2' => 'Recipe:' . ucwords($category->getName()) . ':' . ucwords($subcategory->getName()),
        'prop7' => $this->getUser()->isAuthenticated(),
        'prop9' => 'brrecipe:' . $this->recipe->getId(),
        'prop11' => $this->recipe->getSponsorId() ? $this->recipe->getSponsor()->getName() : '',
        'prop18' => 'betterrecipes',
        'prop19' => 'Food',
        'prop20' => $request->getUri(),
        'eVar9' => 'Recipe:view:' . $this->recipe->getSlug(),
        'eVar14' => 'Recipe',
        'eVar24' => $this->getUser()->isAuthenticated(),
        'prop39' => $this->recipe->getUser()->getIsPremium() == 1 ? $this->recipe->getUser()->getDisplayName() : ''
      ));
      $this->getOmniture()->setAutoload(false);
    }
  }

  public function executeNew(sfWebRequest $request)
  {
    // meta
    $response = $this->getResponse();
    $response->setTitle('Add A Recipe | Online Recipes | Share Recipes | Online Cookbook | Better Recipes');
    $response->addMeta('description', 'Use this page to add and share your favorite recipes to our comprehensive online cookbook filled with online recipes and cooking tips for any meal.');
    $response->addMeta('keywords', 'online recipes, online cookbook, cooking tips, share recipes, recipes');

    $parameters = $request->getParameter('recipe');
    if ($request->getParameter('contest'))
      $parameters['contest'] = $request->getParameter('contest');
    $this->groups = $this->getOnesite()->getRest()->getUserGroups($this->getUser()->getOnesiteId(), 1, 5000, 'member,moderator,owner');
    $this->form = new RecipeFrontendForm(null, array('params' => $parameters));
    if ($request->isMethod(sfRequest::POST)) {
      $this->processForm($request, $this->form, $this->groups['items'], true);
    }

    //Omniture
    $this->getOmniture()->setMany(array(
      'pageName' => 'Recipe:AddRecipe:New',
      'server' => 'www.betterrecipes.com',
      'channel' => 'Recipe',
      'prop1' => 'Recipe:AddRecipe',
      'prop7' => $this->getUser()->isAuthenticated(),
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $request->getUri(),
      'eVar9' => 'Recipe:AddRecipe:New',
      'eVar14' => 'Recipe',
      'eVar24' => $this->getUser()->isAuthenticated(),
    ));

    $this->setTemplate('form');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($recipe = Doctrine_Core::getTable('Recipe')->find($request->getParameter('id')), sprintf('Object recipe does not exist (%s).', $request->getParameter('id')));
    $this->forward404Unless($recipe->getUserId() == $this->getUser()->getAttribute('id'), sprintf('Object recipe does not exist (%s).', $request->getParameter('id')));

    $this->groups = $this->getOnesite()->getRest()->getUserGroups($this->getUser()->getOnesiteId(), 1, 5000, 'member,moderator,owner');
    $this->form = new RecipeFrontendForm($recipe);
    if ($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT)) {
      $this->processForm($request, $this->form, $this->groups['items']);
    }
    $this->setTemplate('form');
  }

  public function executeUpdateSubcategory(sfWebRequest $request)
  {
    $options = CategoryTable::getSubCategoryList($request->getParameter('catid'))->toArray();
    if (empty($options)) {
      $options[] = array('id' => '', 'name' => 'Select sub category');
    }
    return $this->renderPartial('subcategory_options', compact('options'));
  }

  public function executeUpdateRecentRecipes(sfWebRequest $request)
  {
    $recent_recipes = RecipeTable::getRecentRecipesPaginated($request->getParameter('catid'), $request->getParameter('pageno'), 10);
    return $this->renderPartial('recent_recipes', array('recent_recipes' => $recent_recipes));
  }

  public function executeRate(sfWebRequest $request)
  {
    $user = $this->getUser();
    $recipe = RecipeTable::rate($request->getParameter('id'), $user, $request->getParameter('rating'));
    $rating = $recipe->getRating();
    if ($user->isAuthenticated()) {
      $user_rating = RateTable::getUserRating($recipe->getId(), $user->getAttribute('id'));
    } else {
      $recipe_ratings = $user->getAttribute('recipe_ratings', array());
      $user_rating = $recipe_ratings[$recipe->getId()];
    }
    return $this->renderPartial('rating', compact('rating', 'user_rating'));
  }

  public function executeAddtosaved(sfWebRequest $request)
  {
    $user_id = $this->getUser()->getAttribute('id');
    SavedTable::add($request->getParameter('id'), $user_id);
    return $this->renderPartial('save_recipe', array('is_saved' => true));
  }

  public function executeContestVote(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest() && $recipe = Doctrine_Core::getTable('Recipe')->find($request->getParameter('recipeId')));
    $contestant = Doctrine::getTable('Contestant')->createQuery('c')->where('c.recipe_id = ?', $recipe->getId())->fetchOne();
    //UID Cookie
    $uid = $request->getCookie('uid');
    //Captcha
    include_once('ip.inc.php');
    $ip_address = determine_ip();
    $uidCheck = VoteTable::uidCheck($contestant->getId(), $uid);
    if ($uidCheck) {
      //Check the Captcha - all users
      require_once(sfConfig::get('sf_lib_dir') . "/vendor/AdCopy/adcopylib.php");   //include the AdCopy library
      $adcopyResponse = solvemedia_check_answer(sfConfig::get('app_adcopy_verification_key'), $ip_address, $request->getParameter('adcopy_challenge'), $request->getParameter('adcopy_response'), sfConfig::get('app_adcopy_hash_key'));
      //Update contestant
      $contestant->setVoteCount($contestant->getVoteCount() + 1);
      $contestant->save();
      //Update vote table
      $vote = new Vote();
      $vote->setContestantId($contestant->getId());
      $vote->setIpAddress(sprintf("%u", ip2long($ip_address)));
      if (isset($user_id)) {
        $vote->setUserId($user_id);
      }
      $vote->setUid($uid);
      $vote->setCreatedAt(date('Y-m-d H:i:s'));
      $vote->save();
    }
    return sfView::NONE;
  }

   public function executeUpdateVoteStatus(sfWebRequest $request)
  {
    //Show vote button is user has not voted yet (based on uid)
    $this->forward404Unless($request->isXmlHttpRequest());
    $contestant = Doctrine::getTable('Contestant')->createQuery('c')->where('c.recipe_id = ?', $request->getParameter('recipe_id'))->fetchOne();
    if (!$contestant) {
      $is_voted = false;
    } else {
      $is_voted = VoteTable::uidCheck($contestant->getId(), $request->getCookie('uid')) ? false : true;
    }
    return $this->renderText(json_encode(compact('is_voted')));
  } 
  
  protected function getCatlevelRecipes($category_id)
  {
    $is_global = 0;
    $is_mobile = 1;
    return RecipeTable::getList(compact('is_global', 'category_id', 'is_mobile'));
  }

  protected function getStories($category_id)
  {
    $is_global = 1;
    $is_mobile = 1;
    return ArticleTable::getList(compact('is_global', 'category_id', 'is_mobile'));
  }

  protected function getSlideshows($category_id)
  {
    $is_global = 1;
    $is_mobile = 1;
    return SlideshowTable::getList(compact('is_global', 'category_id', 'is_mobile'));
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $user_groups, $is_new = false)
  {
    $form_values = $request->getParameter($form->getName());
    $form->bind($form_values, $request->getFiles($form->getName()));
    if ($form->isValid()) {
      if ($is_new) {

        // award the user 100 points for uploading a recipe
        $this->getOnesite()->getRest()->awardPoints($this->getUser()->getOnesiteId(), 100);

        //Omniture
        $this->getUser()->isAuthenticated() ? $prop7 = true : $prop7 = false;
        $prop20 = $request->getUri();
        $omnitureParams = array('prop7' => $prop7, 'prop20' => $prop20);
        $this->getUser()->setAttribute('upload_recipe_omni', $omnitureParams);

        $recipe = $form->create();
        $contest_id = $request->getParameter('contest', 0);
        if ($contest_id > 0 && $form->getValue('contests') > 0) {
          $this->redirect(UrlToolkit::getUrl('@contests_enter_contest?id=' . $contest_id . '&recipe_id=' . $recipe->getId() . '&new_recipe=1'));
        }
      } else {
        $recipe = $form->save();
      }
      GroupRecipeTable::updateRecipeGroups($user_groups, $request->getParameter('group_ids', array()), $recipe->getId());
//    $this->redirect('recipes/edit?id=' . $recipe->getId())
//    Client wants to send the user directly to recipe page
      $this->redirect(UrlToolkit::getUrl($recipe));
    }
  }

  protected function getCategories()
  {
    $is_global = 1;
    return CategoryTable::getSelectedList(compact('is_global'));
  }

  protected function setSeoParams($item)
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers('Text');
    $item_name = strtolower(is_object($item) ? get_class($item) : $item);
    $response = $this->getResponse();
    $default_values = sfConfig::get('app_meta_' . $item_name);
    if (is_object($item) && $item->getTitleTag() && $item->getTitleTag() != '') {
      $response->setTitle($item->getTitleTag());
    } elseif (is_object($item) && $item->getName() && $item->getName() != '') {
      if ($item instanceof Category) {
        if ($item->isMainCategory()) {
          $title = ucwords($item->getName() . ' | Recipes | Better Recipes');
        } else {
          $title = ucwords($item->getName() . ' | ' . $item->getParent()->getName() . ' | Recipes | Better Recipes');
        }
      } else {
        $title = Microformat::correct_caps($item->getName() . ' | Better Recipes');
      }
      $response->setTitle($title);
    } else {
      $response->setTitle($default_values['title']);
    }
    if (is_object($item) && $item->getSummary() && $item->getSummary() != '') {
      $response->addMeta('description', $item->getSummary());
    } elseif (is_object($item) && $item->getDescription() && $item->getDescription() != '') {
      $response->addMeta('description', truncate_text($item->getDescription(), 160, '', true));
    } else {
      $response->addMeta('description', $default_values['description']);
    }
    if (is_object($item) && $item->getKeywords() && $item->getKeywords() != '') {
      $response->addMeta('keywords', $item->getKeywords());
    } else {
      $response->addMeta('keywords', $default_values['keywords']);
    }
  }

}