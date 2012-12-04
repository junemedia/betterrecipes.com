<?php

/**
 * CategoryTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CategoryTable extends Doctrine_Table
{
  // Don't display Better Recipes, Mixing Bowl Recipes, Miscellaneous Recipes
  public static $excluded_cats = array(28, 281);

  /**
   * Returns an instance of this class.
   *
   * @return object CategoryTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('Category');
  }

  public static function getSelectedList($params=array())
  {
    $params['module'] = 'category';
    $weight_count = 0;
    $category_coll = array();
    $override = OverrideTable::getOverride($params);
    if ($override) {
      // Determine the available positions for the given area
      $position_counts = $override->getPositionCount();
      if (count($position_counts) > 0) {
        $item_count = intval($position_counts->getLast()->getCount());
      } else {
        $item_count = PositionCount::getDefault($params);
      }
      // Override the sorting
      $weighted_categories = $override->getWeightedItems(ucfirst($params['module']));
      $weight_count = count(@$weighted_categories['item_ids']);
      $unweight_count = $item_count - $weight_count;
      if (isset($weighted_categories['item_coll'])) {
        $category_coll = $weighted_categories['item_coll'];
      }
      if ($unweight_count > 0) {
        $q = Doctrine_Core::getTable(ucfirst($params['module']))->createQuery('c')->Where('c.is_active = ?', 1);
        if (isset($params['category_id'])) {
          $q->andWhere('c.parent_id = ?', $params['category_id']);
        }
        if ($params['is_global'] == 1) {
          $q->andWhere('c.parent_id is null');
          $q->andWhereNotIn('c.id', self::$excluded_cats);
        }
        if ($weight_count > 0) {
          $q->whereNotIn('c.id', $weighted_categories['item_ids']);
        }
        $unweighted_categories = $q->orderBy('c.sequence ASC')->limit($unweight_count)->execute();
        foreach ($unweighted_categories as $unweighted_category) {
          $category_coll[] = $unweighted_category;
        }
      }
      return $category_coll;
    } else {
      $item_count = PositionCount::getDefault($params);
    }
    $q = Doctrine_Core::getTable('Category')->createQuery('c')->where('c.is_active = ?', 1);
    if (isset($params['category_id'])) {
      $q->andWhere('c.parent_id = ?', $params['category_id']);
    }
    if ($params['is_global'] == 1) {
      $q->andWhere('c.parent_id is null');
      $q->andWhereNotIn('c.id', self::$excluded_cats);
    }
    $unweighted_categories = $q->orderBy('c.sequence ASC')->limit($item_count)->execute();
    foreach ($unweighted_categories as $unweighted_category) {
      $category_coll[] = $unweighted_category;
    }
    return $category_coll;
  }

  public static function getCategoryBySlug($slug)
  {
    $q = Doctrine_Core::getTable('Category')->createQuery('c')->where('c.slug = ?', $slug);
    return $q->fetchOne();
  }

  public static function getCategoryIdByOnesiteId($id)
  {
    $q = Doctrine_Core::getTable('Category')->createQuery('c')->where('c.onesite_id = ?', $id);
    $obj = $q->fetchOne();
    if ($obj) {
      return $obj['id'];
    }
  }

  public static function isMainCategory($id)
  {
    $category = Doctrine_Core::getTable('Category')->find($id);
    return is_null($category->getParentId()) ? true : false;
  }

  public static function getMainCategoryList($params=null)
  {
    $q = Doctrine_Core::getTable('Category')->createQuery('c')->where('c.is_active = ?', 1)->andWhere('c.parent_id IS NULL');
    if (isset($params['excluded_cats'])) {
      $q->andWhereNotIn('c.id', $params['excluded_cats']);
    }
    return $q->orderBy('c.name')->execute();
  }

  public static function getParentCategoriesAndIds()
  {
    $categories = array();

    $parentCategories = Doctrine_Core::getTable('Category')->createQuery('c')->select('c.id, c.name')->where('c.parent_id IS NULL')->fetchArray();

    foreach ($parentCategories as $c)
      $categories[$c['id']] = $c['name'];

    return $categories;
  }

  public static function getSubCategoryList($parent_id, $params=array())
  {
    $q = Doctrine_Core::getTable('Category')->createQuery('c')->where('c.is_active = ?', 1)->andWhere('c.parent_id = ?', $parent_id);
    if (isset($params['excluded_cats'])) {
      $q->andWhereNotIn('c.id', $params['excluded_cats']);
    }
    return $q->orderBy('c.name')->execute();
  }

  public static function getSubCategories()
  {
    return Doctrine_Core::getTable('Category')->createQuery('c')->where('c.is_active = ?', 1)->andWhere('c.parent_id IS NOT NULL')->orderBy('c.name')->execute();
  }

  public static function getRecipeCategories($parent_id)
  {
    if ($parent_id == 0)
      return $q = Doctrine_Core::getTable('Category')->createQuery('c')->where('c.parent_id IS NULL')->orderBy('c.sequence ASC');
    else if ($parent_id == 1)
      return $q = Doctrine_Core::getTable('Category')->createQuery('c')->where('c.parent_id IS NOT NULL')->orderBy('c.sequence ASC');
    else
      return $q = Doctrine_Core::getTable('Category')->createQuery('c');
  }

  public static function updateActive($catId, $active)
  {
    if (isset($catId) && isset($active)) {
      $q = Doctrine_Query::create()
        ->update('Category c')
        ->set('c.is_active', '?', $active)
        ->where('c.id = ?', $catId)
        ->execute();
      return $q;
    }
  }

  public static function getWeightedItems($override)
  {
    //Returns an Array of the Override Items
    $weightedItemsArray = $override->getWeightedItems('Category');
    if (count($weightedItemsArray) > 0)
      return $weightedItemsArray['item_coll'];
    else
      return;
  }

}