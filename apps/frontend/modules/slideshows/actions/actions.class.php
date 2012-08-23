<?php

/**
 * slideshows actions.
 *
 * @package    betterrecipes
 * @subpackage slideshows
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class slideshowsActions extends sfActions
{
  protected $reroutes = array(
    'recipes|football-party-recipes' => 'appetizer|easy-tailgating-recipes',
    'recipes|dazzling-party-appetizers' => 'appetizer|easy-party-appetizers',
    'recipes|muffin-recipes' => 'bread|muffin-recipes',
    'recipes|banana-bread-recipes' => 'bread|easy-banana-bread-recipes',
    'recipes|brunch-recipes' => 'breakfast|easy-brunch-recipes',
    'recipes|chicken-recipes' => 'chicken|easy-chicken-recipes',
    'recipes|favorite-christmas-recipes' => 'christmas|easy-christmas-recipes',
    'recipes|favorite-cookie-recipes' => 'cookie|easy-cookie-recipes',
    'recipes|favorite-crock-pot-recipes' => 'crockpot|our-favorite-crock-pot-recipes',
    'recipes|chocolate-recipes' => 'dessert|easy-chocolate-recipes',
    'recipes|our-favorite-pie-recipes' => 'dessert|easy-pie-recipes',
    'recipes|fast-and-delicious-sandwich-recipes' => 'easy|sandwich-recipes',
    'recipes|summer-recipes' => 'easy|easy-summer-recipes',
    'recipes|best-recipes-for-the-grill' => 'grilling|easy-grilling-recipes',
    'recipes|burgers' => 'grilling|easy-burger-recipes',
    'recipes|favorite-healthy-recipes' => 'healthy|favorite-healthy-recipes',
    'recipes|lemon-recipes' => 'lowfat|easy-lemon-recipes',
    'recipes|easy-pasta-recipes' => 'italian|easy-pasta-recipes',
    'recipes|fresh-and-fabulous-salad-recipes' => 'salad|easy-salad-recipes',
    'recipes|seafood-recipes' => 'seafood|easy-seafood-recipes',
    'recipes|hot-and-spicy-chili-recipes' => 'soup|hot-and-spicy-chili-recipes',
    'recipes|favorite-easy-soup-recipes' => 'soup|easy-soup-recipes',
    'recipes|easy-thanksgiving-recipes' => 'thanksgiving|easy-thanksgiving-recipes',
    'recipes|easy-vegetable-recipes' => 'vegetarian|easy-vegetarian-recipes'
  );

  /**
   * Executes detail action
   *
   * @param sfRequest $request A request object
   */
  public function executeDetail(sfWebRequest $request)
  {
    $host_parts = explode('.', $request->getHost());
    $path_parts = explode('.', ltrim($request->getPathInfo(), '/gallery'));
    if (isset($this->reroutes[$host_parts[0] . '|' . $path_parts[0]])) {
      $newroute_parts = explode('|', $this->reroutes[$host_parts[0] . '|' . $path_parts[0]]);
      $this->redirect(UrlToolkit::getProtocol() . $newroute_parts[0] . '.' . UrlToolkit::getDomain() . '/slideshows/' . $newroute_parts[1]);
    }
    $this->forward404Unless($this->slideshow = Doctrine_Core::getTable('slideshow')->findOneBySlug($request->getParameter('slug')), sprintf('Object slideshow does not exist (%s).', $request->getParameter('slug')));
    $this->forward404If(($request->getParameter('mode', '') == 'preview' && intval($request->getCookie('lis') < 2)) || ($request->getParameter('mode', '') != 'preview' && $this->slideshow->getIsActive() == 0));
    $this->showall = strpos($request->getReferer(), $request->getParameter('slug') . '/all') !== false ? false : true;
    $this->category = $this->slideshow->getCategory();
    $this->slides = $this->slideshow->getSortedSlides();
    $host_parts = explode('.', $request->getHost());
    $this->forward404Unless($this->category->getSlug() == $host_parts[0]);
    // Increase the view count by one
    $this->slideshow->setViews($this->slideshow->getViews() + 1);
    $this->slideshow->save();

    $this->recipes = RecipeTable::getList(array('is_global' => 0, 'category_id' => $this->category->getId()));
    $this->slideshows = SlideshowTable::getList(array('is_global' => 1, 'category_id' => $this->category->getId()));
    $this->rr_recipes = array('category_id' => $this->category->getId(), 'is_global' => 1);
    $this->bread_crumbs = array(
      'better recipes' => UrlToolkit::getDomainUri(),
      strtolower($this->category->getName()) => UrlToolkit::getUrl($this->category),
      strtolower($this->slideshow->getName()) => null
    );
    //Title Tag & Meta Data
    $this->getResponse()->setTitle(Microformat::correct_caps($this->slideshow->getTitleTag()));
    $this->getResponse()->addMeta('keywords', $this->slideshow->getKeywords(), true);
    $this->getResponse()->addMeta('description', $this->slideshow->getSummary(), true);

    /**
     * Omniture
     */
    $this->omniture_page_name = 'Slideshow:' . $this->slideshow->getName() . ':' . $this->slides[0]->getImgParentObj()->getName() . ':Slide1';
    $this->omniture = $this->getOmniture();
    $this->omniture->setAutoload(false);
    $this->omniture->setMany(array(
      'server' => 'www.betterrecipes.com',
      'channel' => 'Recipe',
      'prop1' => 'Recipe:' . ucwords($this->category->getName()),
      'prop6' => 'Slideshow:' . $this->slideshow->getName(),
      'prop7' => true, // // member page views - omniture_tbd
      'prop9' => 'brrecipe:' . $this->slides[0]->getImgParentObj()->getId(),
      'prop11' => $this->slideshow->getSponsorId() ? $this->slideshow->getSponsor()->getName() : '',
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $request->getUri(),
      'eVar14' => 'Recipe',
      'eVar18' => $this->getUser()->isAuthenticated() ? $this->getUser()->getAttribute('regSource') : '',
      'eVar24' => $this->getUser()->isAuthenticated(),
      'eVar26' => '', // party ID - omniture_tbd
      'eVar32' => $this->getUser()->isAuthenticated() ? $this->getUser()->getProfileId() : '',
      'event8' => '', //after login - omniture_tbd
      'event9' => ''  //after logout - omniture_tbd
    ));
  }

  /**
   * Executes print action
   *
   * @param sfRequest $request A request object
   */
  public function executePrint(sfWebRequest $request)
  {
    $this->forward404Unless($this->slideshow = Doctrine_Core::getTable('slideshow')->findOneBySlugAndIsActive($request->getParameter('slug'), 1), sprintf('Object slideshow does not exist (%s).', $request->getParameter('slug')));
    $category = $this->slideshow->getCategory();
    /**
     * Omniture
     */
    $this->getOmniture()->setMany(array(
      'pageName' => 'Slideshow:Print:' . $this->slideshow->getName(),
      'server' => 'www.betterrecipes.com',
      'channel' => 'Recipe',
      'prop1' => 'Recipe:' . ucwords($category->getName()),
      'prop6' => 'Slideshow:' . $this->slideshow->getName(),
      'prop7' => true, // // member page views - omniture_tbd
//    'prop9' => 'brrecipe:mem1857100053',
      'prop11' => $this->slideshow->getSponsorId() ? $this->slideshow->getSponsor()->getName() : '',
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $request->getUri(),
      'eVar9' => 'Slideshow:Print:' . $this->slideshow->getName(),
      'eVar14' => 'Recipe',
      'eVar18' => $this->getUser()->isAuthenticated() ? $this->getUser()->getAttribute('regSource') : '',
      'eVar24' => $this->getUser()->isAuthenticated(),
      'eVar26' => '', // party ID - omniture_tbd
      'eVar32' => $this->getUser()->isAuthenticated() ? $this->getUser()->getProfileId() : '',
      'event8' => '', //after login - omniture_tbd
      'event9' => ''  //after logout - omniture_tbd
    ));
  }

  /**
   * Executes thumbs action
   *
   * @param sfRequest $request A request object
   */
  public function executeThumbs(sfWebRequest $request)
  {
    $this->forward404Unless($slideshow = Doctrine_Core::getTable('slideshow')->findOneBySlug($request->getParameter('slug')), sprintf('Object slideshow does not exist (%s).', $request->getParameter('slug')));
    $page = $request->getParameter('page', '') != '' ? '#' . $request->getParameter('page', '') : '';
    $this->redirect(UrlToolkit::getRoute($slideshow) . $page);
  }

}
