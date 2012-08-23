<?php

/**
 * Photo form.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class RecipePhotoForm extends PhotoForm
{

  public function configure()
  {
    parent::configure();
    unset($this['recipe_id']);

    $params = $this->getOption('params');
    if (!$this->hasEntry($params)) {
      $this->validatorSchema['name']->setOption('required', false);
      $this->validatorSchema['image']->setOption('required', false);
    }
  }

  public function hasEntry($values)
  {
    if (count($values) > 0) {
      foreach ($values as $field) {
        if (!empty($field)) {
          return true;
        }
      }
    }
    return false;
  }

}