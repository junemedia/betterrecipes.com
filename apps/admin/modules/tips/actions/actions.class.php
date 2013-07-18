<?php

/**
 * tips actions.
 *
 * @package    betterrecipes
 * @subpackage tips
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tipsActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    
    $this->tipTitle = $request->getParameter('tipTitle');
    $this->sort = $request->getParameter('sort');
    $this->sortDir = $request->getParameter('sortDir');
    $params = array('tipTitle' => $request->getParameter('tipTitle'),
                    'sort'     => $request->getParameter('sort'),
                    'sortDir'  => $request->getParameter('sortDir'));
    $this->pager = new sfDoctrinePager('Tip', '25');
    $this->pager->setQuery(TipTable::getFilteredTips($params));
    $this->pager->setPage($request->getParameter('page'), 1);
    $this->pager->init();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new TipForm();
    
    $this->bread_crumbs = array(
      'Tips' => UrlToolkit::getDomainUri() . '/admin/tips', 
      'Create' => null
    );
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));


    $this->form = new TipForm();
    $form = $this->form;
    $form->bind($request->getParameter($form->getName()));
    //print_r($form->getErrorSchema()->getErrors());

     if ($form->isValid())
     {
      $tip = $form->create();

      $this->redirect('tips/edit?id='.$tip->getId());
     }

    $this->setTemplate('new');
  }
  
  public function executeUpdateActive(sfWebRequest $request){
    
    $this->forward404Unless($request->isXmlHttpRequest());
    $articleId = $this->getRequestParameter('articleId');
    $active = $this->getRequestParameter('active');

    if (isset($articleId) && isset($active)) {
      ArticleTable::updateActive($articleId, $active);
    }
    sfView::NONE;    
  }

  public function executeDetail(sfWebRequest $request)
  {
    $this->forward404Unless($recipe = Doctrine_Core::getTable('Article')->find(array($request->getParameter('id'))), sprintf('Object article does not exist (%s).', $request->getParameter('id')));
    $this->article = Doctrine_Core::getTable('Article')->find($request->getParameter('id'));

    $this->bread_crumbs = array(
      'Articles' => UrlToolkit::getDomainUri() . '/admin/articles', 
      ucwords($this->article->getName()) => null
    );
  }
  
  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($article = Doctrine_Core::getTable('Article')->find(array($request->getParameter('id'))), sprintf('Object article does not exist (%s).', $request->getParameter('id')));
    $this->form = new ArticleForm($article);
    $this->sponsors = SponsorTable::getActiveSponsors();
    
    $this->bread_crumbs = array(
      'Articles' => UrlToolkit::getDomainUri() . '/admin/articles', 
      ucwords($this->form->getObject()->getName()) => null
    );
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($article = Doctrine_Core::getTable('Article')->find(array($request->getParameter('id'))), sprintf('Object article does not exist (%s).', $request->getParameter('id')));
    $this->form = new ArticleForm($article);
    $this->sponsors = SponsorTable::getActiveSponsors();

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($article = Doctrine_Core::getTable('Article')->find(array($request->getParameter('id'))), sprintf('Object article does not exist (%s).', $request->getParameter('id')));
    $article->delete();

    $this->redirect('articles/index');
  }
}
