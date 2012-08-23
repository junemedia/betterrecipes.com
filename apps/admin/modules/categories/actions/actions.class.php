<?php

/**
 * categories actions.
 *
 * @package    betterrecipes
 * @subpackage categories
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class categoriesActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->pager = new sfDoctrinePager('Category', '50');
    $this->pager->setQuery(CategoryTable::getRecipeCategories(0));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }

  public function executeSort(sfWebRequest $request)
  {
    $this->sortRecipes = $request->getParameter('category_ids');
    if ($request->isMethod('post') && $request->getParameter('sorted')) {
      $this->sortCategories($request->getParameter('category_ids'));
      $this->success = "Category Reordering Saved";
    }

    $this->pager = new sfDoctrinePager('Category', '50');
    $this->pager->setQuery(CategoryTable::getRecipeCategories(0));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }

  public function executeSortSubcategories(sfWebRequest $request)
  {
    $this->forward404Unless($category = Doctrine_Core::getTable('category')->find(array($request->getParameter('category_id')) || $request->isXmlHttpRequest()), sprintf('Object category does not exist (%s).', $request->getParameter('id')));
    $this->sortCategories($request->getParameter('subcategory_ids'));
    return $this->renderPartial('subcategories', array('category' => $category, 'sorted' => 1));
  }

  public function executeDetail(sfWebRequest $request)
  {
    $this->forward404Unless($this->category = Doctrine_Core::getTable('category')->find(array($request->getParameter('id'))), sprintf('Object category does not exist (%s).', $request->getParameter('id')));

    //Favorite Recipes Section
    $categoryParams = array('module' => 'recipe', 'category_id' => $this->category->getId(), 'is_global' => 0);
    $favoriteRecipesOverride = OverrideTable::getOverrideAdmin($categoryParams);
    if (count($favoriteRecipesOverride) > 0) {
      $this->favoriteRecipes = $favoriteRecipesOverride[0]; //Only one favorite recipes override for each category 
      //Total Recipes for Fav Recipes   
      $this->favoriteRecipesTotal = OverrideTable::getOverrideCount($this->favoriteRecipes->getId());
      //Override Recipe Items        
      $this->items = RecipeTable::getWeightedItems($this->favoriteRecipes);
    }

    //How To Stories
    $articleParams = array('module' => 'article', 'category_id' => $this->category->getId(), 'is_global' => 1);
    $favoriteArticlesOverride = OverrideTable::getOverrideAdmin($articleParams);
    if (count($favoriteArticlesOverride) > 0) {
      $this->favoriteArticles = $favoriteArticlesOverride[0]; //Only one favorite articles override for each category
      //Total Recipes for Fav Recipes   
      $this->favoriteArticlesTotal = OverrideTable::getOverrideCount($this->favoriteArticles->getId());
      //Override Recipe Items        
      $this->articles = ArticleTable::getWeightedItems($this->favoriteArticles);
    }

    //Breadcrumbs
    $this->bread_crumbs = array(
      'Recipe Categories' => UrlToolkit::getDomainUri() . '/admin/categories',
      ucwords($this->category->getName()) => null
    );
  }

  /*
    public function executeUpdateActive(sfWebRequest $request)
    {
    $this->forward404Unless($request->isXmlHttpRequest());
    $categoryId = $this->getRequestParameter('categoryId');
    $active = $this->getRequestParameter('active');
    if (isset($categoryId) && isset($active)) {
    CategoryTable::updateActive($categoryId, $active);
    }
    sfView::NONE;
    } */

  /*
    public function executeNew(sfWebRequest $request)
    {
    $this->form = new categoryForm();
    }

    public function executeCreate(sfWebRequest $request)
    {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new categoryForm();

    $this->processForm($request, $this->form, 'create');

    $this->setTemplate('new');
    }
   */

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($category = Doctrine_Core::getTable('category')->find(array($request->getParameter('id'))), sprintf('Object category does not exist (%s).', $request->getParameter('id')));
    $this->form = new categoryForm($category);

    //Category image

    $file = $this->form->getObject()->getImgSrc();
    //$file = sfConfig::get('sf_upload_dir').'/images/categories/200x200/'.$request->getParameter('id').'.jpg';
    //TESTING
    //$file = sfConfig::get('sf_web_dir').'/upload_testing/'.$request->getParameter('id').'.jpg';
    //if (file_exists($file))      
    //$this->form->setImage('/images/categories/200x200/'.$request->getParameter('id').'.jpg'); 
    //TESTING
    //$this->form->setImage('/upload_testing/'.$request->getParameter('id').'.jpg'); 
    //else 
    //$this->form->setImage('/images/categories/200x200/img-recdet-placeholder.jpg'); 

    $file = $category->getImgSrc();
    //TESTING
    //$file = sfConfig::get('sf_web_dir').'/upload_testing/'.$request->getParameter('id').'.jpg';

    if (file_exists($file))
      $this->form->setImage($file);
    //TESTING
    //$this->form->setImage('/upload_testing/'.$request->getParameter('id').'.jpg'); 
    else
      $this->form->setImage($file);

    //TESTING
    //$this->form->setImage('/upload_testing/recipe-img-placeholder.jpg'); 

    if ($this->form->getObject()->isMainCategory()) { //Parent Category Breadcrumbs
      $this->bread_crumbs = array(
        'Recipe Categories' => UrlToolkit::getDomainUri() . '/admin/categories',
        ucwords($this->form->getObject()->getName()) => null
      );
    } else { //Subcategory Breadcrumbs
      $this->bread_crumbs = array(
        'Recipe Categories' => UrlToolkit::getDomainUri() . '/admin/categories',
        ucwords($this->form->getObject()->getParent()->getName()) => UrlToolkit::getDomainUri() . '/admin/categories/detail/id/' . $this->form->getObject()->getParent()->getId(),
        ucwords($this->form->getObject()->getName()) => null
      );
    }
    //Favorite Recipes Section
    $categoryParams = array('module' => 'recipe', 'category_id' => $category->getId(), 'is_global' => 0);
    $favoriteRecipesOverride = OverrideTable::getOverrideAdmin($categoryParams);
    if (count($favoriteRecipesOverride) > 0) {
      $this->favRecipesForm = new OverrideForm($favoriteRecipesOverride[0]); //Only one favorite recipes override for each section
    } else {
      //First time - Create new override module for this category
      $favRecipeModule = new Override();
      $favRecipeModule->setModule('recipe');
      $favRecipeModule->setCategoryId($category->getId());
      $favRecipeModule->setIsGlobal(0);
      $favRecipeModule->setStartDate(date('Y-m-d H:i:s'));
      $favRecipeModule->setEndDate(date('Y-m-d H:i:s'));
      $favRecipeModule->setCreatedAt(date('Y-m-d H:i:s'));
      $favRecipeModule->setUpdatedAt(date('Y-m-d H:i:s'));
      $favRecipeModule->setUserId(sfContext::getInstance()->getUser()->getAttribute('id'));
      $favRecipeModule->save();

      $categoryParams = array('module' => 'recipe', 'category_id' => $category->getId(), 'is_global' => 0);
      $favoriteRecipesOverride = OverrideTable::getOverrideAdmin($categoryParams);
      $favRecipeModule = $favoriteRecipesOverride[0]; //Only one favorite recipes override for each section
      //Set a position count row for the override module (default count is 5)
      $positionCount = new PositionCount();
      $positionCount->setOverrideId($favRecipeModule->getId());
      $positionCount->setCount(5);
      $positionCount->save();

      $this->favRecipesForm = new OverrideForm($favRecipeModule);
    }

    //Only one favorite recipes override for each section 
    //Total Recipes for Fav Recipes   
    $this->favoriteRecipesTotal = OverrideTable::getOverrideCount($this->favRecipesForm->getObject()->getId());
    //Override Recipe Items        
    $this->weightedItems = RecipeTable::getWeightedItems($this->favRecipesForm->getObject());

    //How To Stories Section
    $articleParams = array('module' => 'article', 'category_id' => $category->getId(), 'is_global' => 1);
    $favoriteArticlesOverride = OverrideTable::getOverrideAdmin($articleParams);
    if (count($favoriteArticlesOverride) > 0) {
      $this->favArticlesForm = new OverrideForm($favoriteArticlesOverride[0]); //Only one favorite recipes override for each section
    } else {
      //First time - Create new override module for this category
      $favArticleModule = new Override();
      $favArticleModule->setModule('article');
      $favArticleModule->setCategoryId($category->getId());
      $favArticleModule->setIsGlobal(1);
      $favArticleModule->setStartDate(date('Y-m-d H:i:s'));
      $favArticleModule->setEndDate(date('Y-m-d H:i:s'));
      $favArticleModule->setCreatedAt(date('Y-m-d H:i:s'));
      $favArticleModule->setUpdatedAt(date('Y-m-d H:i:s'));
      $favArticleModule->setUserId(sfContext::getInstance()->getUser()->getAttribute('id'));
      $favArticleModule->save();

      $articleParams = array('module' => 'article', 'category_id' => $category->getId(), 'is_global' => 1);
      $favoriteArticlesOverride = OverrideTable::getOverrideAdmin($articleParams);
      $favArticleModule = $favoriteArticlesOverride[0]; //Only one favorite recipes override for each section
      //Set a position count row for the override module (default count is 5)
      $positionCount = new PositionCount();
      $positionCount->setOverrideId($favArticleModule->getId());
      $positionCount->setCount(5);
      $positionCount->save();

      $this->favArticlesForm = new OverrideForm($favArticleModule);
    }

    //Only one favorite recipes override for each section 
    //Total Recipes for Fav Recipes   
    $this->favoriteArticlesTotal = OverrideTable::getOverrideCount($this->favArticlesForm->getObject()->getId());
    //Override Recipe Items        
    $this->weightedArticles = ArticleTable::getWeightedItems($this->favArticlesForm->getObject());
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($category = Doctrine_Core::getTable('category')->find(array($request->getParameter('id'))), sprintf('Object category does not exist (%s).', $request->getParameter('id')));
    $this->form = new categoryForm($category);

    $this->processForm($request, $this->form, 'update');

    $this->setTemplate('edit');
  }

  public function executeAutocomplete(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    sfView::NONE;
    $text = $request->getParameter('textField');

    $results = Doctrine_Query::create()->select('id, name')->from('Recipe r')->where('r.name LIKE ?', "%" . $text . "%")->limit(10)->fetchArray();

    foreach ($results as $r) {
      $r['id'] = (int) $r['id'];
      $r['name'] = $r['name'];
      $autoArray[] = $r;
    }

    return $this->renderText(json_encode($autoArray));
  }

  public function executeAutocompleteArticles(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    sfView::NONE;
    $text = $request->getParameter('textField');

    $results = Doctrine_Query::create()->select('id, name')->from('Article a')->where('a.name LIKE ?', "%" . $text . "%")->limit(10)->fetchArray();

    foreach ($results as $r) {
      $r['id'] = (int) $r['id'];
      $r['name'] = $r['name'];
      $autoArray[] = $r;
    }

    return $this->renderText(json_encode($autoArray));
  }

  public function executeAddRecipe(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    sfView::NONE;
    if ($request->getParameter('itemId') != -1) {
      $duplicateItem = Doctrine_Core::getTable('Weight')->createQuery('w')
        ->where('w.override_id = ?', $request->getParameter('overrideId'))
        ->andWhere('w.item_id = ?', $request->getParameter('itemId'))
        ->execute();
      if (count($duplicateItem) > 0) {
        $error = "Recipe already exists in this section";
      } else {
        //Add Item to Weight Table
        $weightedItem = new Weight();
        $weightedItem->setOverrideId($request->getParameter('overrideId'));
        $weightedItem->setItemId($request->getParameter('itemId'));
        $weightedItem->setRank($request->getParameter('rank') + 1);
        $weightedItem->save();
        $error = "";
      }
    } else {
      $error = "Please choose a Recipe to Add";
    }

    //Get Updated Weighted Items
    $override = Doctrine_Core::getTable('Override')->find($request->getParameter('overrideId'));
    $weightedItems = RecipeTable::getWeightedItems($override);

    return $this->renderPartial('favoriteRecipes', array('weightedItems' => $weightedItems, 'overrideId' => $request->getParameter('overrideId'), 'error' => $error));
  }

  public function executeAddArticle(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    sfView::NONE;
    if ($request->getParameter('itemId') != -1) {
      $duplicateItem = Doctrine_Core::getTable('Weight')->createQuery('w')
        ->where('w.override_id = ?', $request->getParameter('overrideId'))
        ->andWhere('w.item_id = ?', $request->getParameter('itemId'))
        ->execute();
      if (count($duplicateItem) > 0) {
        $error = "Article already exists in this section";
      } else {
        //Add Item to Weight Table
        $weightedItem = new Weight();
        $weightedItem->setOverrideId($request->getParameter('overrideId'));
        $weightedItem->setItemId($request->getParameter('itemId'));
        $weightedItem->setRank($request->getParameter('rank') + 1);
        $weightedItem->save();
        $error = "";
      }
    } else {
      $error = "Please choose an Article to Add";
    }

    //Get Updated Weighted Items
    $override = Doctrine_Core::getTable('Override')->find($request->getParameter('overrideId'));
    $weightedArticles = ArticleTable::getWeightedItems($override);

    return $this->renderPartial('favoriteArticles', array('weightedArticles' => $weightedArticles, 'overrideId' => $request->getParameter('overrideId'), 'errorArticle' => $error));
  }

  public function executeDeleteFavRecipe(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    sfView::NONE;

    $recipeItem = Doctrine_Core::getTable('Weight')->createQuery('w')
      ->where('w.override_id = ?', $request->getParameter('overrideId'))
      ->andWhere('w.item_id = ?', $request->getParameter('itemId'))
      ->fetchOne();
    $recipeItem->delete();

    //Get Updated Weighted Items
    $override = Doctrine_Core::getTable('Override')->find($request->getParameter('overrideId'));
    $weightedItems = RecipeTable::getWeightedItems($override);

    return $this->renderPartial('favoriteRecipes', array('weightedItems' => $weightedItems, 'overrideId' => $request->getParameter('overrideId')));
  }

  public function executeDeleteFavArticle(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    sfView::NONE;

    $articleItem = Doctrine_Core::getTable('Weight')->createQuery('w')
      ->where('w.override_id = ?', $request->getParameter('overrideId'))
      ->andWhere('w.item_id = ?', $request->getParameter('itemId'))
      ->fetchOne();
    $articleItem->delete();

    //Get Updated Weighted Items
    $override = Doctrine_Core::getTable('Override')->find($request->getParameter('overrideId'));
    $weightedArticles = ArticleTable::getWeightedItems($override);

    return $this->renderPartial('favoriteArticles', array('weightedArticles' => $weightedArticles, 'overrideId' => $request->getParameter('overrideId')));
  }

  public function executeUpdateFavRecipes(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $override = Doctrine_Core::getTable('Override')->find($request->getParameter('id'));
    $form = new OverrideForm($override);

    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    $catId = $form->getObject()->getCategoryId();
    if ($form->isValid()) {
      //Save Override Form
      $override = $form->save();
      //Save New Rankings
      $this->sortItems($request->getParameter('item_ids'), $override->getId());

      //Save Recipes per Page
      $form->getObject()->getPositionCount()->getLast()->setCount($request->getParameter('totalRecipes'));
      $form->getObject()->getPositionCount()->getLast()->save();

      $this->redirect('categories/edit?id=' . $catId);
    } else {
      //Form not valid - set template with errors
      $this->forward404Unless($category = Doctrine_Core::getTable('category')->find(array($catId)), sprintf('Object category does not exist (%s).', $request->getParameter('id')));
      $this->form = new categoryForm($category);
      $file = $category->getImgSrc();
      $this->form->setImage($file);
      //Favorite Recipes
      $this->favRecipesForm = $form;
      $this->favoriteRecipesTotal = OverrideTable::getOverrideCount($this->favRecipesForm->getObject()->getId());  //Total Recipes for Fav Recipes           
      $this->weightedItems = RecipeTable::getWeightedItems($this->favRecipesForm->getObject()); //Override Recipe Items          
      //How To Stories
      $articleParams = array('module' => 'article', 'category_id' => $category->getId(), 'is_global' => 1);
      $favoriteArticlesOverride = OverrideTable::getOverrideAdmin($articleParams);
      $this->favArticlesForm = new OverrideForm($favoriteArticlesOverride[0]);
      $this->favoriteArticlesTotal = OverrideTable::getOverrideCount($this->favArticlesForm->getObject()->getId());  //Total Articles          
      $this->weightedArticles = ArticleTable::getWeightedItems($this->favArticlesForm->getObject()); //Override Articles

      $this->setTemplate('edit');
    }
  }

  public function executeUpdateFavArticles(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $override = Doctrine_Core::getTable('Override')->find($request->getParameter('id'));
    $form = new OverrideForm($override);

    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    $catId = $form->getObject()->getCategoryId();
    if ($form->isValid()) {
      //Save Override Form
      $override = $form->save();
      //Save New Rankings
      $this->sortItems($request->getParameter('article_ids'), $override->getId());

      //Save Recipes per Page
      $form->getObject()->getPositionCount()->getLast()->setCount($request->getParameter('totalArticles'));
      $form->getObject()->getPositionCount()->getLast()->save();

      $this->redirect('categories/edit?id=' . $catId);
    } else {
      //Form not valid - set template with errors
      $this->forward404Unless($category = Doctrine_Core::getTable('category')->find(array($catId)), sprintf('Object category does not exist (%s).', $request->getParameter('id')));
      $this->form = new categoryForm($category);
      $file = $category->getImgSrc();
      $this->form->setImage($file);
      //How To Stories
      $this->favArticlesForm = $form;
      $this->favoriteArticlesTotal = OverrideTable::getOverrideCount($this->favArticlesForm->getObject()->getId());  //Total Articles          
      $this->weightedArticles = ArticleTable::getWeightedItems($this->favArticlesForm->getObject()); //Override Articles               
      //Favorite Recipes
      $recipeParams = array('module' => 'recipe', 'category_id' => $category->getId(), 'is_global' => 0);
      $favoriteRecipesOverride = OverrideTable::getOverrideAdmin($recipeParams);
      $this->favRecipesForm = new OverrideForm($favoriteRecipesOverride[0]);
      $this->favoriteRecipesTotal = OverrideTable::getOverrideCount($this->favRecipesForm->getObject()->getId());  //Total Recipes for Fav Recipes           
      $this->weightedItems = RecipeTable::getWeightedItems($this->favRecipesForm->getObject()); //Override Recipe Items 

      $this->setTemplate('edit');
    }
  }

  /*
    public function executeDelete(sfWebRequest $request)
    {
    $request->checkCSRFProtection();

    $this->forward404Unless($category = Doctrine_Core::getTable('category')->find(array($request->getParameter('id'))), sprintf('Object category does not exist (%s).', $request->getParameter('id')));
    $category->delete();

    $this->redirect('categories/index');
    }
   */

  protected function processForm(sfWebRequest $request, sfForm $form, $action='update')
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

    if ($form->isValid()) {
      //Get the file upload for the image			
      $file = $this->form->getValue('image');
      if (isset($file)) {
        //Save the file to the directory
        $extension = $file->getExtension($file->getOriginalExtension());
        $file_path = sfConfig::get('sf_upload_dir') . '/category/200x200/';
        @mkdir($file_path, 0777, true);

        $file->save($file_path . $this->form->getValue('id') . $extension);
        //TESTING 
        //$file->save(sfConfig::get('sf_web_dir').'/upload_testing/'.$this->form->getValue('id').$extension); 
      }

      //if($action == 'update')
      $category = $form->save();
      //else
      //$category = $form->create();

      $this->redirect('categories/edit?id=' . $category->getId());
    }
  }

  private function sortCategories($categories=array())
  {
    if (count($categories) > 0):
      foreach ($categories as $key => $id) {
        $sortOrder = $key + 1;
        Doctrine_Core::getTable('Category')->find($id)->setSequence($sortOrder)->save();
        /* change save to update and add update method in phototable to update user_id and updated at fields */
      }
    endif;
  }

  private function sortItems($items=array(), $overrideId)
  {
    if (count($items) > 0):
      foreach ($items as $key => $id) {
        $sortOrder = $key + 1;
        $weightedItem = WeightTable::getWeightedItem($id, $overrideId);
        $weightedItem->setRank($sortOrder)->save();
      }
    endif;
  }

}
