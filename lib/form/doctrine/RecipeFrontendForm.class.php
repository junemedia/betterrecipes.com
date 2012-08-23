<?php

/**
 * Recipe form.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class RecipeFrontendForm extends RecipeForm
{

  public function configure()
  {
    parent::configure();
    unset($this['quick_recipe'], $this['is_active'], $this['slug'], $this['course'], $this['image']);
    $this->widgetSchema['introduction']->setLabel('Recipe Description');
    if ($this->isNew()) {
      $params = $this->getOption('params');
      if (!isset($params['main_category'])) $params['main_category'] = '';//fix for ET 5739
      $this->setWidget('main_category', new sfWidgetFormChoice(array('label' => 'Main Category', 'choices' => $this->getMainCategoryOptions()), array('onchange' => 'updateSubcategory(this.value)')));
      if ($params['main_category'] == '') {
        $this->setWidget('sub_category', new sfWidgetFormChoice(array('label' => 'Sub Category', 'choices' => array('' => 'Select sub category'))));
      } else {
        $this->setWidget('sub_category', new sfWidgetFormChoice(array('choices' => $this->getSubCategoryOptions($params['main_category']))));
      }
      //Contest Options
      (isset($params['contest'])) ? $default = $params['contest'] : $default = '';
      $this->setWidget('contests', new sfWidgetFormChoice(array('label' => 'Contest', 'choices' => $this->getContestOptions(), 'default' => $default)));
      
      // Photo subform
      (isset($params['photo'])) ? $photoParams = array('params' => $params['photo']) : $photoParams = array(); //fix for ET 5739
      $this->embedForm('photo', new RecipePhotoForm(null, $photoParams));
      $main_cat_pks = CategoryTable::getMainCategoryList(CategoryTable::$excluded_cats)->getPrimaryKeys();
      $this->setValidator('main_category', new sfValidatorChoice(array('choices' => $main_cat_pks, 'required' => true)));
      $sub_cat_pks = CategoryTable::getSubCategoryList($params['main_category'])->getPrimaryKeys();
      $this->setValidator('sub_category', new sfValidatorChoice(array('choices' => $sub_cat_pks, 'required' => true)));
      //Contest validation
      $contest_pks = ContestTable::getActiveContests()->execute()->getPrimaryKeys();
      $this->setValidator('contests', new sfValidatorChoice(array('choices' => $contest_pks, 'required' => false)));
    } else {
      $sub_category = $this->getObject()->getFirstCategory();
      $main_category = $sub_category->getParent();
    }
  }

  protected function getMainCategoryOptions()
  {
    $params['excluded_cats'] = CategoryTable::$excluded_cats;
    $categories = CategoryTable::getMainCategoryList($params);
    $options[''] = 'Select main category';
    foreach ($categories as $category) {
      $options[$category->getId()] = $category->getName();
    }
    return $options;
  }
  
  protected function getSubCategoryOptions($main_category_id)
  {
    $categories = CategoryTable::getSubCategoryList($main_category_id);
    foreach ($categories as $category) {
      $options[$category->getId()] = $category->getName();
    }
    return $options;
  }
  
  protected function getContestOptions(){
    $contests = ContestTable::getActiveContests()->execute();
    $options[''] = 'Select Contest';
    foreach($contests as $c){
      $options[$c->getId()] = $c->getName();
    }    
    return $options;
  }

  public function create()
  {
    $user_id = sfContext::getInstance()->getUser()->getAttribute('id');
    $this->getObject()->setUserId($user_id);
    $this->getObject()->setInitialCatId($this->getValue('sub_category'));
    $this->getObject()->setSource('nw');
    $this->getObject()->setCreatedAt(date('Y-m-d H:i:s'));
    $this->getObject()->setSlug(UrlToolkit::generateCategoryArticleRecipeFriendlySlug($this->getValue('name'), 'recipe'));
    $has_photo_entry = $this->embeddedForms['photo']->hasEntry($this->getValue('photo'));
    if (!$has_photo_entry) {
      unset($this->embeddedForms['photo']);
    }
    $recipe = parent::save();
    if ($has_photo_entry) {
      $this->embeddedForms['photo']->getObject()->create($recipe->getId());
    }
    // Associate recipe with a contest
    if ($this->getValue('contests') != ''){
      $contestant = new Contestant();
      $contestant->setRecipeId($recipe->getId());
      $contestant->setContestId($this->getValue('contests'));
      $numContestants = ContestantTable::getContestantsByContest($this->getValue('contests'))->execute();
      $contestant->setRank(count($numContestants)+1);
      $contestant->setUserId($user_id);
      $contestant->save();
    }
    // Create a recipe category
    $category_recipe = new CategoryRecipe();
    $category_recipe->setRecipeId($recipe->getId());
    $category_recipe->setCategoryId($this->getValue('sub_category'));
    $category_recipe->setSequence(CategoryRecipeTable::getNextSequenceNo($recipe->getId()));
    $category_recipe->save();
    return $recipe;
  }

}