<?php

/**
 * Recipe form.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class RecipeForm extends BaseRecipeForm
{

  public function configure()
  {
    parent::configure();
    unset($this['user_id'], $this['created_at'], $this['updated_at'], $this['source'], $this['legacy_id'], $this['rating'], $this['main_ingredient'], $this['course'], $this['views'], $this['onesite_id'], $this['recommendations'], $this['description'], $this['updated_by_id'], $this['initial_cat_id']);

    $this->setWidget('sponsor_id', new sfWidgetFormInputHidden());
    
    $this->widgetSchema->setLabels(array(
      'name' => 'Recipe Name',
      'origin' => 'Source',
      'preptime' => 'Prep time',
      'cooktime' => 'Cook time',
      'totaltime' => 'Total time',
      'instructions' => 'Directions',
      'title_tag' => 'Title Tag',
      'summary' => 'Meta Description',
      'ingredients' => 'Ingredients',
      'keywords' => 'Keywords'
    ));

    $this->validatorSchema['introduction']->setOption('required', true);
    $this->validatorSchema['ingredients']->setOption('required', true);
    $this->validatorSchema['instructions']->setOption('required', true);
    $this->validatorSchema['keywords']->setOption('required', true);
    $this->validatorSchema['servings']->setOption('required', true);
  }

}