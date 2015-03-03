<?php

/**
 * wonders actions.
 *
 * @package    betterrecipes
 * @subpackage wonders
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class wondersActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->filter_type = ( $request->getParameter('filter_type') ) ? $request->getParameter('filter_type') : 'general';
    if ( $this->filter_type == 'general' ) {
	    $this->pager = new sfDoctrinePager('Wonders', '10');
	    $this->pager->setQuery(WondersTable::getWonders());
	} else {
		$this->pager = new sfDoctrinePager('Wonders', '10');
	    $this->pager->setQuery(CategoryWondersTable::getWonders());
	}
    $this->pager->setPage($request->getParameter('page'), 1);
    $this->pager->init();
  }
  
  
  public function executeNew(sfWebRequest $request)
  {
  	
  	$this->form = new WondersForm();
    
    $this->bread_crumbs = array(
      'Wonders' => UrlToolkit::getDomainUri() . '/admin/wonders', 
      'Create General' => null
    );
  }
  
  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($wonder = Doctrine_Core::getTable('Wonders')->find(array($request->getParameter('id'))), sprintf('Object wonder does not exist (%s).', $request->getParameter('id')));
    $this->bread_crumbs = array(
      'Wonders' => UrlToolkit::getDomainUri() . '/admin/wonders', 
      'Edit General' => null
    );
    $this->form = new WondersForm($wonder);    
  }  
  
  
  public function executeCreate(sfWebRequest $request)
  {
 	$this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->form = new WondersForm();
    $this->processForm($request, $this->form, 'create');
    $this->setTemplate('new');
  }
  
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::PUT));
    $request->checkCSRFProtection();
    $this->forward404Unless($wonder = Doctrine_Core::getTable('Wonders')->find(array($request->getParameter('id'))), sprintf('Object wonder does not exist (%s).', $request->getParameter('id')));
    $this->form = new WondersForm($wonder);
	$this->processForm($request, $this->form);
    $this->setTemplate('edit');
  }
  
  
  public function executeCategory_new(sfWebRequest $request)
  {
  	
  	$this->form = new CategoryWondersForm();
    
    $this->bread_crumbs = array(
      'Wonders' => UrlToolkit::getDomainUri() . '/admin/wonders', 
      'Create Category Wonder' => null
    );
  }
  
  public function executeCategory_edit(sfWebRequest $request)
  {
    $this->forward404Unless($wonder = Doctrine_Core::getTable('CategoryWonders')->find(array($request->getParameter('id'))), sprintf('Object wonder does not exist (%s).', $request->getParameter('id')));
    $this->bread_crumbs = array(
      'Wonders' => UrlToolkit::getDomainUri() . '/admin/wonders', 
      'Edit Category' => null
    );
    $this->form = new CategoryWondersForm($wonder);    
  }  
  
  public function executeCreate_category(sfWebRequest $request)
  {
 	$this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->form = new CategoryWondersForm();
    $this->processForm($request, $this->form, 'create');
    $this->setTemplate('category_new');
  }
  
  public function executeUpdate_category(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::PUT));
    $request->checkCSRFProtection();
    $this->forward404Unless($wonder = Doctrine_Core::getTable('CategoryWonders')->find(array($request->getParameter('id'))), sprintf('Object wonder does not exist (%s).', $request->getParameter('id')));
    $this->form = new CategoryWondersForm($wonder);
	$this->processForm($request, $this->form);
    $this->setTemplate('category_edit');
  }

  
  
  public function executeUpdateSubcategory(sfWebRequest $request)
  {
    $options = CategoryTable::getSubCategoryList($request->getParameter('catid'))->toArray();
    if (empty($options)) {
      $options[] = array('id' => '', 'name' => 'Select sub category');
    }
    return $this->renderPartial('subcategory_options', compact('options'));
  }
  
  protected function processForm(sfWebRequest $request, sfForm $form, $submitType = 'update')
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

    if ($form->isValid())
    {
      if ($submitType == 'create') {
      	$form->create();
      } else {
      	$form->update();
      }
      $this->redirect('wonders/index');
    }
  }

  
}