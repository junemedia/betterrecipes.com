<?php

class cooksComponents extends sfComponents
{

  public function executeBadges()
  {
    $this->render = $this->blog_id ? true : false;
    if (!$this->render)
      return;

    $this->class = $this->class ? $this->class : null;

    $badges = $this->getOnesite()->getRest()->getUserBadges($this->blog_id);
    $this->badge_count = $badges['total'];
    $this->badges = $this->badge_count ? $badges['items'] : array();
  }

  /**
   * Executes rr_cooks action
   *
   * @param sfRequest $request A request object
   */
  public function executeRr_cooks()
  {
    $this->rr_cooks = $this->getOnesite()->getRest()->getTopUsers(1, 5);
  }

}