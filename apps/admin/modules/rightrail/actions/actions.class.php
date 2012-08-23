<?php

/**
 * rightrail actions.
 *
 * @package    betterrecipes
 * @subpackage rightrail
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class rightrailActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $recipeParams = array('module' => 'recipe', 'is_global' => 1);
    $this->recipeOverrides = OverrideTable::getOverrideAdmin($recipeParams);
    
    $this->recipeOverrideInfo = array('totalRecipes' => array(), 'weightedItems' => array());
    foreach($this->recipeOverrides as $i => $r){
      //Total Recipes for each Override Recipe Module      
      $this->recipeOverrideInfo['totalRecipes'][] = OverrideTable::getOverrideCount($r->getId());    
      //Override Recipe Items        
      $items = RecipeTable::getWeightedItems($r);
      $this->recipeOverrideInfo['weightedItems'][] = $items;
    } 
   
  }  

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new OverrideForm();
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($override = Doctrine_Core::getTable('Override')->find(array($request->getParameter('id'))), sprintf('Object override does not exist (%s).', $request->getParameter('id')));
    $this->form = new OverrideForm($override);
    //Number of Total Recipes
    $this->totalRecipes = OverrideTable::getOverrideCount($override->getId());
    //Weighted Items
    $this->weightedItems = RecipeTable::getWeightedItems($override);
    
  }  

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    
    $this->form = new OverrideForm();
    $this->processForm($request, $this->form, 'create');

    $this->setTemplate('new');
  }
  
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $request->checkCSRFProtection();
    $this->forward404Unless($override = Doctrine_Core::getTable('Override')->find(array($request->getParameter('id'))), sprintf('Object override does not exist (%s).', $request->getParameter('id')));
    
    $this->form = new OverrideForm($override);
    
    if ($request->getParameter('save')){         
      $this->processForm($request, $this->form, 'update');
    } else if ($request->getParameter('rightrailDelete')) {
      $this->executeDelete($request);
    } 

    $this->setTemplate('edit');
  }
  
  public function executeDelete(sfWebRequest $request)
  {    
    $request->checkCSRFProtection();

    $this->forward404Unless($override = Doctrine_Core::getTable('Override')->find(array($request->getParameter('id'))), sprintf('Object override does not exist (%s).', $request->getParameter('id')));
    $override->delete();
    //Remove associated Position Counts
    $positionCount = Doctrine_Core::getTable('PositionCount')->findByOverrideId($request->getParameter('id'));
    foreach($positionCount as $p):
      $p->delete();
    endforeach;
    //Remove Associated Weighted Items
    $items = Doctrine_Core::getTable('Weight')->findByOverrideId($request->getParameter('id'));
    foreach($items as $i):
      $i->delete();
    endforeach;
    
    sfView::NONE;
    $this->redirect('rightrail/index');
  }
  
  public function executeAutocomplete(sfWebRequest $request){
  	$this->forward404Unless($request->isXmlHttpRequest());
    sfView::NONE;
    $text =  $request->getParameter('textField');
    
    $results = Doctrine_Query::create()->select('id, name')->from('Recipe r')->where('r.name LIKE ?', "%".$text."%")->limit(10)->fetchArray();

    foreach ($results as $r){      
      $r['id']=(int)$r['id'];
      $r['name']=$r['name'];
      $autoArray[] = $r;
    }

    return $this->renderText(json_encode($autoArray));
  }
  
  public function executeAddRecipe(sfWebRequest $request){
    $this->forward404Unless($request->isXmlHttpRequest());
    sfView::NONE;
    if ($request->getParameter('itemId') != -1){
      $duplicateItem = Doctrine_Core::getTable('Weight')->createQuery('w')
                                      ->where('w.override_id = ?', $request->getParameter('overrideId'))
                                      ->andWhere('w.item_id = ?', $request->getParameter('itemId'))
                                      ->execute();
      if (count($duplicateItem) > 0){
        $error = "Recipe already exists in this section";
      } else {
        //Add Item to Weight Table
        $weightedItem = new Weight();
        $weightedItem->setOverrideId($request->getParameter('overrideId'));
        $weightedItem->setItemId($request->getParameter('itemId'));
        $weightedItem->setRank($request->getParameter('rank')+1);
        $weightedItem->save();   
        $error = "";
      }
    } else {
      $error = "Please choose a Recipe to Add";
    }
    
    //Get Updated Weighted Items
    $override = Doctrine_Core::getTable('Override')->find($request->getParameter('overrideId'));
    $weightedItems = RecipeTable::getWeightedItems($override);
      
    return $this->renderPartial('recipes', array('weightedItems' => $weightedItems, 'error' => $error));
    
  }
  
  public function executeDeleteRecipe(sfWebRequest $request){
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
      
    return $this->renderPartial('recipes', array('weightedItems' => $weightedItems));
  }
  
  protected function processForm(sfWebRequest $request, sfForm $form, $submitType = 'update')
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {    
      //Will only currently CREATE overrides for recipes modules
      if ($submitType == 'create') {
        $override = $form->create();
      }
      else {
        //Save Override Form
         $override = $form->save();
        //Save New Rankings
        $this->sortItems($request->getParameter('item_ids'), $override->getId());        
      }   
      //Save Recipes per Page
      if (count($form->getObject()->getPositionCount()) > 0){
        $form->getObject()->getPositionCount()->getLast()->setCount($request->getParameter('totalRecipes'));
        $form->getObject()->getPositionCount()->getLast()->save();
      } else { 
        $newPositionCount = new PositionCount();         
        $newPositionCount->setOverrideId($override->getId());
        $newPositionCount->setCount($request->getParameter('totalRecipes'));
        $newPositionCount->save();
      }
      
      $this->redirect('rightrail/edit?id='.$override->getId());
    }
  }   
  
  protected function getRightRailRecipes($module)
  {
    $is_global = 1;
    switch ($module){
      case "recipe":
        return RecipeTable::getList(compact('is_global'));
      default:
        return RecipeTable::getList(compact('is_global'));
    }    
  }
  
  private function sortItems($items=array(), $overrideId){
    if(count($items)>0):
      foreach($items as $key=>$id){
        $sortOrder = $key + 1;  
        $weightedItem = WeightTable::getWeightedItem($id, $overrideId);
        $weightedItem->setRank($sortOrder)->save();
      }      
    endif;
  }
  
}
