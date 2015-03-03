<?php

/**
 * recipephotos actions.
 *
 * @package    betterrecipes
 * @subpackage recipephotos
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class recipephotosActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->sortRecipes = $request->getParameter('recipephotos_ids');
    if ($request->isMethod('post')) {
      $this->sortRecipePhotos($request->getParameter('recipephotos_ids'));
    }

    $this->recipe = Doctrine_Core::getTable('Recipe')->find($request->getParameter('recipe_id'));
    $recipeId = $this->recipe->getId();

    $this->photo = Doctrine_Core::getTable('Photo')->createQuery('p')->where('p.recipe_id = ?', $recipeId)->orderBy('p.sequence ASC')->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PhotoForm();
    $this->recipeId = $request->getParameter('recipe_id');
    $this->form->getWidget('recipe_id')->setAttribute('value', $this->recipeId);
    if ($request->isMethod(sfRequest::POST)) {
      $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
      if ($this->form->isValid()) {
        $photo = $this->form->create();
        $this->saved = true;
        $photo->getRecipe()->update();
        $this->redirect('recipephotos/index?recipe_id=' . $this->recipeId);
      }
    }
  }

  /*
    public function executeEdit(sfWebRequest $request)
    {
    $this->recipeId = $request->getParameter('recipe_id');
    $this->form->getWidget('recipe_id')->setAttribute('value', $this->recipeId);
    $this->forward404Unless($photo = Doctrine_Core::getTable('Photo')->find(array($request->getParameter('id'))), sprintf('Object photo does not exist (%s).', $request->getParameter('id')));
    $this->form = new PhotoForm($photo);
    $this->recipeId = $request->getParameter('recipe_id');
    }

    public function executeUpdate(sfWebRequest $request)
    {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($photo = Doctrine_Core::getTable('Photo')->find(array($request->getParameter('id'))), sprintf('Object photo does not exist (%s).', $request->getParameter('id')));
    $this->form = new PhotoForm($photo);
    $this->recipeId = $request->getParameter('recipe_id');
    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
    }
   * 
    protected function processForm(sfWebRequest $request, sfForm $form)
    {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
    $photo = $form->save();

    $this->redirect('recipephotos/edit?id='.$photo->getId());
    }
    }
   */

  public function executeDelete(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();
    $this->forward404Unless($photo = Doctrine_Core::getTable('Photo')->find(array($request->getParameter('id'))), sprintf('Object photo does not exist (%s).', $request->getParameter('id')));
    $photo->getRecipe()->update();
    $photo->delete();
    // add code
    $this->redirect('recipephotos/index?recipe_id=' . $request->getParameter('recipe_id'));
  }

  private function sortRecipePhotos($photos=array())
  {
    if (count($photos) > 0) {
      foreach ($photos as $key => $id) {
        $sortOrder = $key + 1;
        $recipePhoto = Doctrine_Core::getTable('Photo')->find($id)->setSequence($sortOrder);
        $recipePhoto->save();
        // Update the recipe info once you reach the last photo (update_by and updated at)        
        if (count($photos) == $sortOrder) {
          $recipePhoto->getRecipe()->update();
        }
        /* change save to update and add update method in phototable to update user_id and updated at fields */
      }
    }
  }

}

