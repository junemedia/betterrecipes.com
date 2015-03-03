<?php

/**
 * 
 */
class staticComponents extends sfComponents {
  
  /**
   * Banner displayed above registration form 
   * 
   * configure via %SF_CONFIG_DIR%/app.yml
   * 
   */
  public function executeTopper() {
    $regSources = sfConfig::get('app_RegServices_toppers');
    $this->regSource = $this->getUser()->getRegSourceAttribute('code');
    $this->topper_img = $this->regSource && array_key_exists($this->regSource, $regSources) ? sfConfig::get('app_RegServices_topper_dir').'/'.$regSources[$this->regSource] : null;
  }
}