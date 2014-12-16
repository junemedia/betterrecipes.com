<?php

/**
 * Recipe form.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class RecipeAdminForm extends RecipeForm
{

  public function configure()
  {
    parent::configure();

    unset($this['quick_recipe'], $this['rating'], $this['rating_count'], $this['main_ingredient'], $this['course'], $this['views'], $this['recommendations'], $this['user_id'], $this['onesite_id'], $this['created_at'], $this['updated_at'], $this['source'], $this['legacy_id']);

    //$this->setWidget('slug', new sfWidgetFormInputHidden());

    $this->widgetSchema->setLabels(array(
      'name' => 'Recipe Name',
      'ingredients' => 'Ingredients',
      'servings' => 'Servings',
      'origin' => 'Source',
      'preptime' => 'Prep time',
      'cooktime' => 'Cook time',
      'totaltime' => 'Total time',
      'summary' => 'Meta Description',
      'title_tag' => 'Title Tag',
      'keywords' => 'Keywords'
    ));

    $this->validatorSchema['keywords'] = new sfValidatorString(array('max_length' => 255, 'required' => false));
  }

  public function save($con = null)
  {
    $this->getObject()->setUpdatedAt(date('Y-m-d H:i:s'));
    $this->getObject()->setUpdatedById(intval(sfContext::getInstance()->getUser()->getAttribute('id')));
    if ($this->values['slug'] != $this->getObject()->getSlug()) {
      $this->values['slug'] = UrlToolkit::generateCategoryArticleRecipeFriendlySlug($this->getValue('slug'), 'recipe', $this->getValue('id'));
    }
    $form_obj = parent::save($con);
    return $form_obj;
  }

}

?>