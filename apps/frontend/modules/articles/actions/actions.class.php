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

  /**
   * Executes detail action
   *
   * @param sfRequest $request A request object
   */
  public function executeDetail(sfWebRequest $request)
  {
    if ($request->hasParameter('print')) {
      $this->forwardUnless($this->article = Doctrine_Core::getTable('article')->findOneBySlug($request->getParameter('slug')), 'recipes', 'print');
    } else {
      $this->forwardUnless($this->article = Doctrine_Core::getTable('article')->findOneBySlug($request->getParameter('slug')), 'recipes', 'detail');
    }
    $this->forward404If($request->getParameter('mode', '') != 'preview' && $this->article->getIsActive() == 0);
    $category = $this->article->getCategory();
    $host_parts = explode('.', $request->getHost());
    $this->forward404Unless($category->getSlug() == $host_parts[0]);
    // Increase the view count by one
    $this->article->setViews($this->article->getViews() + 1);
    $this->article->save();

    $this->rr_recipes = array('category_id' => $category->getId(), 'is_global' => 0);
    $this->bread_crumbs = array(
      'better recipes' => UrlToolkit::getDomainUri(),
      strtolower($category->getName()) => UrlToolkit::getUrl($category),
      strtolower($this->article->getName()) => null
    );
    //Title Tag & Meta Data
    $this->getResponse()->setTitle(Microformat::correct_caps($this->article->getTitleTag()));
    $this->getResponse()->addMeta('keywords', $this->article->getKeywords(), true);
    $this->getResponse()->addMeta('description', $this->article->getSummary(), true);
    /**
     * Omniture
     */
    $this->getOmniture()->setMany(array(
      'pageName' => 'Story:' . ucwords($category->getName()) . ':' . $this->article->getName(),
      'server' => 'www.betterrecipes.com',
      'channel' => 'Recipe',
      'prop1' => ucwords($category->getName()) . ':Article',
      'prop3' => ucwords($category->getName()) . ':' . $this->article->getName(),
      'prop7' => true, // // member page views - omniture_tbd
      'prop11' => $this->article->getSponsorId() ? $this->article->getSponsor()->getName() : '',
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $request->getUri(),
      'eVar9' => 'Story:' . ucwords($category->getName()) . ':' . $this->article->getName(),
      'eVar14' => 'Recipe',
      'eVar18' => $this->getUser()->isAuthenticated() ? $this->getUser()->getAttribute('regSource') : '',
      'eVar24' => $this->getUser()->isAuthenticated(),
      'eVar26' => '', // party ID - omniture_tbd
      'eVar32' => $this->getUser()->isAuthenticated() ? $this->getUser()->getProfileId() : '',
      'event8' => '', //after login - omniture_tbd
      'event9' => ''  //after logout - omniture_tbd
    ));
    // Set adtag header variables: adchild1id
    $this->getContext()->setAdChild1Id($this->article->getSlug());
  }

}
