<?php

/**
 * adtags actions.
 *
 * @package    betterrecipes
 * @subpackage articles
 * @author     Toros Tarpinyan
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class adTagsActions extends sfActions
{

  /**
   * Executes refresh action
   *
   * @param sfRequest $request A request object
   */
  public function executeRefresh(sfWebRequest $request)
  {
    $tagname = $request->getParameter('tagname');
    if ($tagname == 'sponsor') {
      $sponsor = Doctrine_Core::getTable('Sponsor')->find($request->getParameter('spid'));
      return $this->renderPartial('global/adtags/' . $request->getParameter('tagname'), compact('sponsor'));
    } else {
      return $this->renderPartial('global/adtags/' . $request->getParameter('tagname'));
    }
  }

}