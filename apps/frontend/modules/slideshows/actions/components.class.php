<?php

/**
 * slideshow components.
 *
 * @package    betterrecipes
 * @subpackage slideshow
 * @author     Howe Wang
 */
class slideshowsComponents extends sfComponents
{
    /**
   * Executes Our_best_block action
   *
   * @param sfRequest $request A request object
   */
  public function executeOur_best_block()
  {
    $params = $this->ob_slideshows;
    if (!isset($params['is_global'])) {
      $params['is_global'] = 1;
    }
    $this->ob_slideshows = SlideshowTable::getOurBestRecipesCollections($params);
	$this->ob_slideshow = $this->ob_slideshows[mt_rand(0,4)];
  }

}