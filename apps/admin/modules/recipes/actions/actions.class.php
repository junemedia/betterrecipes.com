<?php

/**
 * recipes actions.
 *
 * @package    betterrecipes
 * @subpackage recipes
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class recipesActions extends sfActions {

    public function executeIndex(sfWebRequest $request)
    {
        $this->categories = CategoryTable::getMainCategoryList();
        $this->sub_categories = CategoryTable::getSubCategoryList($request->getParameter('main_categories'));
        $this->mainCat = $request->getParameter('main_categories');
        $this->subCat = $request->getParameter('sub_categories');
        $this->username = $request->getParameter('username');
        $this->keywords = $request->getParameter('keywords');
        $this->sort = $request->getParameter('sort');
        $this->sortDir = $request->getParameter('sortDir');
        $params = array('subcatid' => $request->getParameter('sub_categories'),
            'username' => $request->getParameter('username'),
            'keywords' => $request->getParameter('keywords'),
            'sort' => $request->getParameter('sort'),
            'sortDir' => $request->getParameter('sortDir'));
        $this->pager = new sfDoctrinePager('Recipe', '25');
        $this->pager->setQuery(RecipeTable::getFilteredRecipes($params));
        $this->pager->setPage($request->getParameter('page', 1));
        $this->pager->init();
    }

    public function executeAddSponsor(sfWebRequest $request)
    {
        $this->forward404Unless($request->isXmlHttpRequest());
        $recipeId = $request->getParameter('itemId');
        $sponsors = SponsorTable::getActiveSponsors();

        return $this->renderPartial('sponsor', array('sponsors' => $sponsors, 'recipeId' => $recipeId));
    }

    public function executeUpdateSponsor(sfWebRequest $request)
    {
        $this->forward404Unless($request->isXmlHttpRequest());

        if (!$recipeId = $this->getRequestParameter('itemId'))
        {
            return $this->renderText(json_encode('Please choose a recipe'));
        } else if ((!$sponsorId = $this->getRequestParameter('sponsorId')) && ($this->getRequestParameter('sponsorId') != 0))
        {
            return $this->renderText(json_encode('Please choose a sponsor'));
        }

        RecipeTable::updateSponsor($recipeId, $sponsorId);

        $updatedRecipe = Doctrine_Core::getTable('Recipe')
                ->createQuery('r')
                ->where('r.id = ?', $recipeId)
                ->fetchOne();
        sfView::NONE;
        $sponsorName = $updatedRecipe->getSponsor()->getName();
        if (isset($sponsorName))
            return $this->renderText($updatedRecipe->getSponsor()->getName());
        else
            return $this->renderText("None");
    }

    public function executeUpdateActive(sfWebRequest $request)
    {

        $this->forward404Unless($request->isXmlHttpRequest());
        $recipeId = $this->getRequestParameter('recipeId');
        $active = $this->getRequestParameter('active');
        if (isset($recipeId) && isset($active))
        {
            RecipeTable::updateActive($recipeId, $active);
        }
        if (!is_null($contestant = Doctrine_Core::getTable('Contestant')->findOneByRecipeId($recipeId)))
        {
            $contestant->updateActive($active);//only currently updates if it is being deactivated - remove if condition inside method to change
            $contestant->getContest()->updatedUnofficialWinner();
        }
        return sfView::NONE;
    }

    /*
      public function executeUpdateContests(sfWebRequest $request){
      $this->forward404Unless($request->isXmlHttpRequest());
      $request->getParameter('id');

      sfView::NONE;
      } */

    public function executeDetail(sfWebRequest $request)
    {
        $this->forward404Unless($recipe = Doctrine_Core::getTable('Recipe')->find(array($request->getParameter('id'))), sprintf('Object recipe does not exist (%s).', $request->getParameter('id')));
        $this->recipe = Doctrine_Core::getTable('Recipe')->find($request->getParameter('id'));
        $this->contests = ContestTable::getActiveContests();
        $this->sponsors = SponsorTable::getActiveSponsors();

        $this->bread_crumbs = array(
            'Recipes' => UrlToolkit::getDomainUri() . '/admin/recipes',
            ucwords($this->recipe->getName()) => null
        );
    }

    public function executeEdit(sfWebRequest $request)
    {
        $this->forward404Unless($recipe = Doctrine_Core::getTable('Recipe')->find(array($request->getParameter('id'))), sprintf('Object recipe does not exist (%s).', $request->getParameter('id')));
        $this->form = new RecipeAdminForm($recipe);
        $this->sponsors = SponsorTable::getActiveSponsors();
        $this->maincategories = CategoryTable::getMainCategoryList(array('excluded_cats' => CategoryTable::$excluded_cats));
        $this->bread_crumbs = array(
            'Recipes' => UrlToolkit::getDomainUri() . '/admin/recipes',
            ucwords($this->form->getObject()->getName()) => null
        );
        if ($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT))
        {
            $this->processForm($request, $this->form, 'update');
        }
    }

    public function executeUpdateSubcategory(sfWebRequest $request)
    {
        $subCat = $request->getParameter('sub_categories');
        if ($request->hasParameter('recipe_id'))
        {
            $recipe = Doctrine_Core::getTable('Recipe')->find(array($request->getParameter('recipe_id')));
            $criteria['excluded_cats'] = $recipe->getSubcategories('object')->getPrimaryKeys();
        } else
        {
            $criteria = array();
        }
        $subcategories = CategoryTable::getSubCategoryList($request->getParameter('catid'), $criteria);
        return $this->renderPartial('subcategory', compact('subcategories', 'subCat'));
    }

    public function executeUpdateParentCategories(sfWebRequest $request)
    {
        $this->forward404Unless($request->isXmlHttpRequest());
        $recipeId = $request->getParameter('recipeId');

        $q = Doctrine_Core::getTable('Category')->createQuery('c')
                ->leftjoin('c.CategoryRecipe cr')
                ->leftjoin('cr.Recipe r')
                ->where('r.id = ?', $recipeId)
                ->andWhere('c.parent_id IS NOT NULL');
        $category = $q->fetchArray();
        $updatedCategories = array();
        for ($i = 0; $i < count($category); $i++)
        {
            $q = Doctrine_Core::getTable('Category')->createQuery('c')->select('c.name')->where('c.id = ?', $category[$i]['parent_id']);
            $updatedCategories[$i] = $q->fetchOne();
        }

        $categoriesText = "";
        foreach ($updatedCategories as $i => $c):
            $categoriesText .= $c['name'];
            if ($i < (count($updatedCategories) - 1))
                $categoriesText .= ", ";
        endforeach;

        return $this->renderText($categoriesText);
    }

    public function executeUpdateRecipe(sfWebRequest $request)
    {
        $this->forward404Unless(
                $request->isXmlHttpRequest() &&
                $request->hasParameter('subcat_id') &&
                $request->hasParameter('recipe_id') &&
                $recipe = Doctrine_Core::getTable('Recipe')->find(array($request->getParameter('recipe_id')))
        );

        $category_recipe = Doctrine_Core::getTable('CategoryRecipe')->findByCategoryIdAndRecipeId($request->getParameter('subcat_id'), $request->getParameter('recipe_id'));
        if (count($category_recipe) == 0)
        {
            $category_recipe = new CategoryRecipe();
            $category_recipe->setRecipeId($request->getParameter('recipe_id'));
            $category_recipe->setCategoryId($request->getParameter('subcat_id'));
            $category_recipe->setSequence(count($recipe->getRecipeCategories()) + 1);
            $category_recipe->save();
            $category_recipe->getRecipe()->update();
        }
        return $this->renderPartial('categories', array('recipe' => $recipe, 'edit' => 1));
    }

    public function executeRemoveCategory(sfWebRequest $request)
    {
        $this->forward404Unless($request->isXmlHttpRequest());
        $this->forward404Unless($recipe_category = Doctrine_Core::getTable('CategoryRecipe')->find(array($request->getParameter('id'))), sprintf('Object category recipe does not exist (%s).', $request->getParameter('id')));
        $recipe = $recipe_category->getRecipe();
        $recipe_category->delete();
        $recipe->update();
        return $this->renderPartial('categories', array('recipe' => $recipe, 'edit' => 1));
    }

    /*
      public function executeCreate(sfWebRequest $request)
      {
      $this->forward404Unless($request->isMethod(sfRequest::POST));

      $this->form = new RecipeForm();

      $this->processForm($request, $this->form, 'create');

      $this->setTemplate('new');
      }
     */

    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();

        $this->forward404Unless($recipe = Doctrine_Core::getTable('Recipe')->find(array($request->getParameter('id'))), sprintf('Object recipe does not exist (%s).', $request->getParameter('id')));
        $recipe->delete();

        $this->redirect('recipes/index');
    }

    protected function processForm(sfWebRequest $request, sfForm $form, $action='update')
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid())
        {
            if ($action == 'update')
                $recipe = $form->save();
            $this->redirect('recipes/edit?id=' . $recipe->getId());
        }
    }

}
