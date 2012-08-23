<?php

class rewardsComponents extends sfComponents {
  
  public function executeBadges() {
    $this->render = $this->blog_id ? true : false;
    if (!$this->render) return;
    
    $this->class = $this->class ? $this->class : null;
    
    $badges = $this->getOnesite()->getRest()->getUserBadges($this->blog_id);
    $this->badge_count = $badges['total'];
    $this->badges = $this->badge_count ? $badges['items'] : array();
  }
}