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
    switch($tagname) {
	    case 'sponsor' :
	    	$sponsor = Doctrine_Core::getTable('Sponsor')->find($request->getParameter('spid'));
			return $this->renderPartial('global/adtags/' . $request->getParameter('tagname'), compact('sponsor'));
	    break;
	    case 'vsw' :
	    	return $this->renderPartial('global/right_rail/' . $request->getParameter('tagname'), array('refresh' => true));
	    break;
	    default :
	    	return $this->renderPartial('global/adtags/' . $request->getParameter('tagname'));
    }
  }

}