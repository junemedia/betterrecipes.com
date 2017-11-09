<?php

/**
 * static actions.
 *
 * @package    betterrecipes
 * @subpackage static
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class staticActions extends sfActions
{

  public function executePrivacyPolicy(sfWebRequest $request)
  {
    
  }

  public function executeAddressBook(sfWebRequest $request)
  {

  }

  public function executeSocial(sfWebRequest $request)
  {
    
  }

  public function executeTerms(sfWebRequest $request)
  {
    
  }

  public function executeHelp(sfWebRequest $request)
  {
    
  }

  public function executeOfficialRules(sfWebRequest $request)
  {
    $date = $request->getParameter('date', 0);
    $rule_dates = array('0822', '1017', '1109', '1128', '0220', '0322', '0406', '0423', '0325');
    $this->forward404Unless(in_array($date, $rule_dates));
    $this->setTemplate('or' . $date);
  }

  public function executeTestinvite(sfWebRequest $request)
  {
    
  }

}
