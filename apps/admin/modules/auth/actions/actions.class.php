<?php

/**
 * auth actions.
 *
 * @package    betterrecipes
 * @subpackage auth
 * @author     Bastian Kuberek <bkuberek@resolute.com>
 */
class authActions extends sfActions {

  /**
   * Executes signin action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeSignin(sfWebRequest $request) {
    if ($this->getUser()->isAuthenticated()) {
      $this->redirect('homepage');
    }
    $this->form = new SigninForm();
    if ($request->isMethod(sfRequest::POST)) {
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid()) {
        $values = $this->form->getValues();
        $this->getUser()->signin($values['user_data']);
          // set lis cookie for nginx usage, is admin user?
		  		$is_admin = ($values['user_data']['is_admin'] == 1 || $values['user_data']['is_super_admin'] == 1) ? 2 : 1;
		  		$this->getResponse()->setCookie('lis', $is_admin, 0, '/', UrlToolkit::getDomain());
        $this->redirect(($referrer = $request->getParameter('referrer')) ? $referrer : '@homepage');
      }
    }
  }
  
  /**
   * Executes signout action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeSignout(sfWebRequest $request) {
    $this->getUser()->signout();
    // destroy the lis nginx cookie
  	$this->getResponse()->setCookie('lis', '', time() - 3600, '/', UrlToolkit::getDomain());
    $this->redirect('homepage');
  }
  
  /**
   * Executes signin action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeSecure(sfWebRequest $request) {
    $this->getResponse()->setStatusCode(401);
  }
	
	/**
   * Executes password action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeForgotPassword(sfWebRequest $request) {
    
    $this->form = new ForgetPasswordForm();
    
    if ($request->isMethod(sfRequest::POST)) {
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid()) {
      	$response = $this->form->sendPassword();
      	if ($response) {
      		$this->redirect('signin');
      	}
      }
    }
    
    $this->setTemplate('forgotpassword');
  }

}
