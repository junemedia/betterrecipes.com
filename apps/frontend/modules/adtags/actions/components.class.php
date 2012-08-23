<?php

/**
 * adtags components.
 *
 * @package    betterrecipes
 * @subpackage adtags
 * @author     Toros Tarpinyan
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class adtagsComponents extends sfComponents
{

  /**
   * Executes Header Code action
   *
   * @param sfRequest $request A request object
   */
  public function executeHeader_code(sfWebRequest $request)
  {
    $ad_header_code['adid'] = md5($request->getUri());
    $ad_header_code['adchannelid'] = $this->getContext()->getOmniture()->get('channel');
    $ad_header_code['adparentid'] = UrlToolkit::getSubDomain($request);
    $ad_header_code['adchild1id'] = $this->getContext()->getAdChild1Id();
    $this->ad_header_code = $ad_header_code;
  }

  /**
   * Executes KelloggsRr action
   *
   * @param sfRequest $request A request object
   */
  public function executeKelloggs_rr(sfWebRequest $request)
  {
    $params = $request->getParameterHolder()->getAll();
    switch ($params['module']) {
      case 'mixingbowl':
      case 'groups':
      case 'cooks':
      case 'polls':
      case 'discussions':
      case 'photos':
      case 'videos':
      case 'rewards':
      case 'journals':
        $this->version = 1;
        break;
      case 'home':
        $this->version = 2;
        break;
      case 'recipes':
        switch ($params['action']) {
          case 'index':
            $this->version = 2;
            break;
          case 'subcategory':
            if (isset($params['slug'])) {
              $this->version = 3;
            } else {
              $this->version = 4;
            }
            break;
        }
        break;
      default:
        $this->version = 0;
    }
  }

}