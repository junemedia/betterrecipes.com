<?php

/**
 * SEO functions
 */
class SeoToolkit
{

  /**
   * Wrapper for getRoute
   * 
   * @param String $slug Page slug
   * @param Object  $response Response object
   * @return none 
   */
  public static function setMetaData($slug, $response)
  {
    $meta = MetaTable::getMetaBySlug($slug);
    $default_values = sfConfig::get('app_meta_' . $slug);
    if ($meta) {
      if ($meta->getIsActive() == 1 && !is_null($meta->getTitle()) && $meta->getTitle() != '' && trim($meta->getTitle()) != '') {
        $response->setTitle($meta->getTitle());
      } else {
        $response->setTitle($default_values['title']);
      }
      if (!is_null($meta->getDescription()) && $meta->getDescription() != '' && trim($meta->getDescription()) != '') {
        $response->addMeta('description', $meta->getDescription());
      } else {
        $response->addMeta('description', $default_values['description']);
      }
      if (!is_null($meta->getKeywords()) && $meta->getKeywords() != '' && trim($meta->getKeywords()) != '') {
        $response->addMeta('keywords', $meta->getKeywords());
      } else {
        $response->addMeta('keywords', $default_values['keywords']);
      }
    }
  }

}