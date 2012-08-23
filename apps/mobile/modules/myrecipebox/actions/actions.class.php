<?php

/**
 * myrecipebox actions.
 *
 * @package    betterrecipes
 * @subpackage myrecipebox
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class myrecipeboxActions extends sfActions
{

  public function preExecute()
  {
    //sfConfig::set('sf_web_debug', false);
  }

  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
  	// note: the mobile version of index page will display both personal & saved recipes (without any sorting capability, or ability to manage folders)
  	
    $user_id = $this->getUser()->getAttribute('id');
    $this->cook = Doctrine_Core::getTable('User')->find($user_id);
    //$params = $request->getParameterHolder()->getAll();
    
    // manually register required params
    $params['user_id'] = $this->cook->getId();
    $params['folder'] = 'saved';
    $params['results_per_page'] = 6;
    //$this->folder = Doctrine_Core::getTable('Collection')->find($params['folder']);
    
    $this->saved_recipes = RecipeTable::getUserRecipesPaginated($params);
    
    // reset the folder to pull personal recipes
    $params['folder'] = 'personal';
    $this->personal_recipes = RecipeTable::getUserRecipesPaginated($params);
    
    
    $this->personal_recipe_count = $this->cook->getRecipe()->count();
    $this->saved_recipe_count = $this->cook->getSaved()->count();
    //$this->folders = $this->cook->getCollection();
    
    //Omniture
    $this->getOmniture()->setMany(array(
      'pageName' => 'MixingBowl:User:RecipeBox',
      'server' => 'www.betterrecipes.com',
      'channel' => 'Mixing Bowl',
      'prop1' => 'MixingBowl:User',
      'prop2' => 'MixingBowl:User:RecipeBox',
      'prop7' => $this->getUser()->isAuthenticated(),
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $request->getUri(),
      'eVar9' => 'MixingBowl:User:RecipeBox',
      'eVar14' => 'Mixing Bowl',
      'eVar24' => $this->getUser()->isAuthenticated(),
    ));    
  }
  
  
  public function executePaginate_saved(sfWebRequest $request)
  {
  	$this->forward404Unless($request->isXmlHttpRequest());
  	$user_id = $this->getUser()->getAttribute('id');
    $this->cook = Doctrine_Core::getTable('User')->find($user_id);
    $params['page_no'] = $request->getParameter('page_no',1);
    // manually register required params
    $params['user_id'] = $this->cook->getId();
    $params['folder'] = 'saved';
    $params['results_per_page'] = 6;
    $saved_recipes = RecipeTable::getUserRecipesPaginated($params);
    $this->renderPartial('savedRecipeList', compact('saved_recipes'));
  	return sfView::NONE;
  }
  
  
  public function executePaginate_personal(sfWebRequest $request)
  {
  	$this->forward404Unless($request->isXmlHttpRequest());
  	$user_id = $this->getUser()->getAttribute('id');
    $this->cook = Doctrine_Core::getTable('User')->find($user_id);
    $params['page_no'] = $request->getParameter('page_no',1);
    // manually register required params
    $params['user_id'] = $this->cook->getId();
    $params['folder'] = 'personal';
    $params['results_per_page'] = 6;
    $personal_recipes = RecipeTable::getUserRecipesPaginated($params);
    $this->renderPartial('personalRecipeList', compact('personal_recipes'));
  	return sfView::NONE;
  }

  /**
   * Executes addFolder action
   *
   * @param sfRequest $request A request object
   */
  public function executeAddFolder(sfWebRequest $request)
  {
    $this->form = new collectionForm();
    if ($request->isMethod(sfRequest::POST)) {
      $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
      if ($this->form->isValid()) {
        $collection = $this->form->create();
      }
    }
  }

  /**
   * Executes editFolder action
   *
   * @param sfRequest $request A request object
   */
  public function executeEditFolder(sfWebRequest $request)
  {
    $this->forward404Unless($collection = Doctrine_Core::getTable('collection')->find(array($request->getParameter('folder'))), sprintf('Object collection does not exist (%s).', $request->getParameter('folder')));
    $this->forward404Unless($collection->getUserId() == $this->getUser()->getAttribute('id'), sprintf('Object folder does not exist (%s).', $request->getParameter('folder')));
    $this->form = new collectionForm($collection);
    if ($request->isMethod(sfRequest::POST)) {
      $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
      if ($this->form->isValid()) {
        $collection = $this->form->save();
        $this->folder_saved = true;
      }
    }
  }

  /**
   * Executes deleteFolder action
   *
   * @param sfRequest $request A request object
   */
  public function executeDeleteFolder(sfWebRequest $request)
  {
    if ($request->isMethod('post')) {
      $collection = Doctrine_Core::getTable('Collection')->find($request->getParameter('folder'));
      Doctrine_Core::getTable('CollectionRecipe')->createQuery('cr')->delete()->where('cr.collection_id = ?', $collection->getId())->execute();
      $collection->delete();
      $this->deleted = true;
    }
  }

  /**
   * Executes deleteSavedRecipe action
   *
   * @param sfRequest $request A request object
   */
  public function executeDeleteSavedRecipe(sfWebRequest $request)
  {
  	$this->getResponse()->setContentType('application/json');
    if ($request->isMethod('post')) {
      $saved = Doctrine_Core::getTable('Saved')->findOneByRecipeIdAndUserId($request->getParameter('recipe'), $this->getUser()->getAttribute('id'));
      $user = Doctrine_Core::getTable('User')->find($this->getUser()->getAttribute('id'));
      $folders_pks = $user->getCollection()->getPrimaryKeys();
      Doctrine_Core::getTable('CollectionRecipe')->createQuery('cr')->delete()->whereIn('cr.collection_id ', $folders_pks)->andWhere('cr.recipe_id = ?', $request->getParameter('recipe'))->execute();
      if ($saved) {
        $saved->delete();
      }
      $this->deleted = true;
      $this->saved_recipe_count = $user->getSaved()->count();
      $data['status'] = '1';
      $data['count'] = $this->saved_recipe_count;
    } else {
    	$data['status'] = '0';
      	$data['count'] = '';
    }
    return $this->renderText(json_encode($data));
    return sfView::NONE;
  }

  /**
   * Executes deleteCollectionRecipe action
   *
   * @param sfRequest $request A request object
   */
  public function executeDeleteCollectionRecipe(sfWebRequest $request)
  {
    if ($request->isMethod('post')) {
      $collection_recipe = Doctrine_Core::getTable('CollectionRecipe')->findOneByCollectionIdAndRecipeId($request->getParameter('folder'), $request->getParameter('recipe'));
      if ($collection_recipe) {
        $collection_recipe->delete();
      }
      $this->deleted = true;
    }
  }

  /**
   * Executes moveRecipe action
   *
   * @param sfRequest $request A request object
   */
  public function executeMoveRecipe(sfWebRequest $request)
  {
    if ($request->isMethod('post')) {
      $params = $request->getParameterHolder()->getAll();
      if ($params['from_folder'] != 'saved') {
        $source_collection_recipe = Doctrine_Core::getTable('CollectionRecipe')->findOneByCollectionIdAndRecipeId($params['from_folder'], $params['recipe']);
        if ($source_collection_recipe) {
          $source_collection_recipe->delete();
        }
      }
      $target_collection_recipe = Doctrine_Core::getTable('CollectionRecipe')->findOneByCollectionIdAndRecipeId($params['to_folder'], $params['recipe']);
      if (!$target_collection_recipe) {
        $target_collection_recipe = new CollectionRecipe();
        $target_collection_recipe->setCollectionId($params['to_folder']);
        $target_collection_recipe->setRecipeId($params['recipe']);
        $sequence_no = CollectionRecipeTable::getNextSequenceNo($params['to_folder']);
        $target_collection_recipe->setSequence($sequence_no);
        $target_collection_recipe->save();
      }
      $this->recipe_moved = true;
    } else {
      $user_id = $this->getUser()->getAttribute('id');
      $cook = Doctrine_Core::getTable('User')->find($user_id);
      $this->folders = $cook->getCollection();
    }
  }

}
