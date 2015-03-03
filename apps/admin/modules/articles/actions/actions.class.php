<?php

/**
 * articles actions.
 *
 * @package    betterrecipes
 * @subpackage articles
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class articlesActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    
    $this->articleName = $request->getParameter('articleName');
    $this->sort = $request->getParameter('sort');
    $this->sortDir = $request->getParameter('sortDir');
    $params = array('articleName' => $request->getParameter('articleName'),
                    'sort'     => $request->getParameter('sort'),
                    'sortDir'  => $request->getParameter('sortDir'));
    $this->pager = new sfDoctrinePager('Article', '25');
    $this->pager->setQuery(ArticleTable::getFilteredArticles($params));
    $this->pager->setPage($request->getParameter('page'), 1);    
    $this->pager->init();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new ArticleForm();
    
    $this->bread_crumbs = array(
      'Articles' => UrlToolkit::getDomainUri() . '/admin/articles', 
      'Create' => null
    );
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new ArticleForm();
    $form = $this->form;
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {      
      $article = $form->create();

      $this->redirect('articles/edit?id='.$article->getId());
    }

    $this->setTemplate('new');
  }
  
  public function executeAddSponsor(sfWebRequest $request){
    $this->forward404Unless($request->isXmlHttpRequest());
    $articleId = $request->getParameter('itemId');
    $sponsors = SponsorTable::getActiveSponsors();
    
    return $this->renderPartial('sponsor', array('sponsors' => $sponsors, 'articleId' => $articleId));
  }
  
  public function executeUpdateSponsor(sfWebRequest $request){
    $this->forward404Unless($request->isXmlHttpRequest());
    
    if ( !$articleId = $this->getRequestParameter('itemId')) {
      return $this->renderText(json_encode('Please choose an Article'));
    } else if ( (!$sponsorId = $this->getRequestParameter('sponsorId')) && ($this->getRequestParameter('sponsorId') != 0)) {
      return $this->renderText(json_encode('Please choose a sponsor'));
    } 
    ArticleTable::updateSponsor($articleId, $sponsorId);
    
    $updatedArticle = Doctrine_Core::getTable('Article')
                        ->createQuery('a')
                        ->where('a.id = ?', $articleId)
                        ->fetchOne();    
    sfView::NONE;
    $sponsorName = $updatedArticle->getSponsor()->getName();
    if (isset($sponsorName)) 
      return $this->renderText($sponsorName);
    else 
      return $this->renderText("None");
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

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

    if ($form->isValid())
    {
      
      $file = $this->form->getValue('image'); 

      if (isset($file)) {
        //Save the file to the directory
        $extension = $file->getExtension($file->getOriginalExtension());
        //IMPLEMENT FILE PATH
        $file_path = sfConfig::get('sf_upload_dir') . '/category/200x200/';
        $file->save($file_path . $this->form->getValue('id') . $extension); 
      }
      
      $article = $form->save();       

      $this->redirect('articles/edit?id='.$article->getId());
    }
  }
}
