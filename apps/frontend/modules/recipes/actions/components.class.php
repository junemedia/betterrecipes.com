<?php

/**
 * recipes components.
 *
 * @package    betterrecipes
 * @subpackage recipes
 * @author     Toros Tarpinyan
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class recipesComponents extends sfComponents
{

  /**
   * Executes Footer_Categories action
   *
   * @param sfRequest $request A request object
   */
  public function executeFooter_categories()
  {
    // Don't display Better Recipes, Mixing Bowl Recipes, Miscellaneous Recipes
    $params['excluded_cats'] = CategoryTable::$excluded_cats;
    $category_list = CategoryTable::getMainCategoryList($params)->getData();
    $this->footer_categories = array_chunk($category_list, ceil(count($category_list) / 4));
  }

  /**
   * Executes rr_recipes action
   *
   * @param sfRequest $request A request object
   */
  public function executeRr_recipes($params)
  {
    $params = $this->rr_recipes;
    if (!isset($params['is_global'])) {
      $params['is_global'] = 1;
    }
    $this->rr_recipes = RecipeTable::getList($params);
  }

  /**
   * Executes Catlevel_recipes_slideshows action
   *
   * @param sfRequest $request A request object
   */
  public function executeCatlevel_recipes_slideshows()
  {
    $this->recipes = RecipeTable::getList(array('category_id' => $this->category_id, 'is_global' => 0));
    if ($this->is_main_cat) {
      $this->stories = ArticleTable::getList(array('category_id' => $this->category_id, 'is_global' => 1));
      $this->slideshows = SlideshowTable::getList(array('category_id' => $this->category_id, 'is_global' => 1));
    }
  }
  
  public function executeCatlevel_slideshows()
  {
    //$this->recipes = RecipeTable::getList(array('category_id' => $this->category_id, 'is_global' => 0));
    //if ($this->is_main_cat) {
     // $this->stories = ArticleTable::getList(array('category_id' => $this->category_id, 'is_global' => 1));
      //$this->slideshows = SlideshowTable::getList(array('category_id' => $this->category_id, 'is_global' => 1));
    //}

    // disabling for now--BREAKS A TON OF CATEGORY PAGES
    return;

    //Slideshows
    $slideshowParams = array('module' => 'slideshow', 'category_id' => $this->category_id, 'is_global' => 1);
    $favoriteSlideshowsOverride = OverrideTable::getOverrideAdmin($slideshowParams);
    if (count($favoriteSlideshowsOverride) > 0) {
      $this->favoriteSlideshows = $favoriteSlideshowsOverride[0]; //Only one favorite slideshow override for each category
      $this->favoriteSlideshowsTotal = OverrideTable::getOverrideCount($this->favoriteSlideshows->getId());
      $this->slideshows = SlideshowTable::getWeightedItems($this->favoriteSlideshows);
    }

  }

  /**
   * Executes Catlevel_recipes_slideshows action
   *
   * @param sfRequest $request A request object
   */
  public function executeCatlevel_category_block()
  {
  }
  
    /**
   * Executes Our_best_block action
   *
   * @param sfRequest $request A request object
   */
  public function executeOur_best_block()
  {
    $params = $this->ob_recipes;
    if (!isset($params['is_global'])) {
      $params['is_global'] = 1;
    }
    $this->ob_recipes = RecipeTable::getOurBestRecipes($params);
	$this->ob_recipe = $this->ob_recipes[mt_rand(0,4)];
	$this->ob_category = RecipeTable::getRecipeCategory($this->ob_recipe->getId());
	$this->ob_title = $this->ob_category->getName();
	if(substr(strtolower(trim($this->ob_title)),-7) != 'recipes')
	{
		$this->ob_title = trim($this->ob_title)." Recipes";
	}
  }

}