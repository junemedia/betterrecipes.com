<?php

/**
 * This filter checks Onesite session is valid
 */
class SessionFilter extends sfFilter {

  public function execute($filterChain) {
    $user = $this->getContext()->getUser()->checkSession();
    // continue chain
    $filterChain->execute();
  }

}