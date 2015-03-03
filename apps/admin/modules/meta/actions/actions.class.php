<?php

/**
 * meta actions.
 *
 * @package    betterrecipes
 * @subpackage meta
 * @author     Toros Tarpinyan <ttarpinyan@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class metaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->metas = Doctrine_Core::getTable('meta')->createQuery('a')->execute();
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($meta = Doctrine_Core::getTable('meta')->find(array($request->getParameter('id'))), sprintf('Object meta does not exist (%s).', $request->getParameter('id')));
    $this->form = new metaForm($meta);
    if ($request->isMethod(sfRequest::POST)) {
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid()) {
        $meta = $this->form->save();
      }
    }
    $this->bread_crumbs = array(
      'Meta' => UrlToolkit::getDomainUri() . '/admin/meta',
      $meta->getName() => UrlToolkit::getDomainUri() . '/admin/meta/detail/id/' . $meta->getId(),
      'Edit' => null
    );
  }

  public function executeDetail(sfWebRequest $request)
  {
    $this->forward404Unless($this->meta = Doctrine_Core::getTable('meta')->find(array($request->getParameter('id'))), sprintf('Object meta does not exist (%s).', $request->getParameter('id')));
    $this->bread_crumbs = array(
      'Meta' => UrlToolkit::getDomainUri() . '/admin/meta',
      $this->meta->getName() => null
    );
  }

  public function executeUpdateActive(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $meta_id = $this->getRequestParameter('meta_id');
    $status = $this->getRequestParameter('status');
    MetaTable::updateActive($meta_id, $status);
    return sfView::NONE;
  }

}
