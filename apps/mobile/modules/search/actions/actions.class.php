<?php

/**
 * search actions.
 *
 * @package    betterrecipes
 * @subpackage search
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class searchActions extends sfActions
{

  public function preExecute()
  {
    //$this->rest = $this->getOnesite()->getRest();
    if ($this->getUser()->isAuthenticated()) {
      $this->user_id = $this->getUser()->getOnesiteId();
    } else {
      $this->user_id = null;
    }
    $this->baynote = new Baynote_rest();
  }

  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    /* $q = urlencode('citizencagetest');
      $page = 1;
      $perPage = 40;
      $filter = 'PageType';
      $filterVal = 'member';
      $s = $this->baynote->search($q, $page, $perPage, $filter, $filterVal); */

    // retrieve categories
    $params['excluded_cats'] = array(281, 282, 216, 217, 28, 215);
    $this->categories = CategoryTable::getMainCategoryList($params);

    $perPage = 20;

    if ($this->term = $request->getParameter('term')) {
      $page = $request->getParameter('page', 1);
      $PageType = ($request->getParameter('PageType')) ? $request->getParameter('PageType') : null;
      $Rating = ($request->getParameter('Rating')) ? $request->getParameter('Rating') : null;
      $CategoryName = ($request->getParameter('CategoryName')) ? $request->getParameter('CategoryName') : null;
      $this->with = ($request->getParameter('with')) ? $request->getParameter('with') : null;
      $this->without = ($request->getParameter('without')) ? $request->getParameter('without') : null;
      $recipeOwner = ($request->getParameter('recipeOwner')) ? $request->getParameter('recipeOwner') : array();
      $attrList = ($request->getParameter('attrList')) ? $request->getParameter('attrList') : null;
      $attrSort = ($request->getParameter('attrSort')) ? $request->getParameter('attrSort') : null;
      $SubcategoryName = ($request->getParameter('SubcategoryName')) ? $request->getParameter('SubcategoryName') : array();

      if ($this->with) {
        $this->with_list = $this->explode_trim($this->with);
        $withParam = $this->with_list;
      } else {
        $this->with_list = array();
        $withParam = array();
      }

      if ($this->without) {
        $this->without_list = $this->explode_trim($this->without);
        $withoutParam = $this->without_list;
      } else {
        $this->without_list = array();
        $withoutParam = array();
      }

      if ($CategoryName) {
        $this->cat_list = $this->explode_trim($CategoryName);
      } else {
        $this->cat_list = array();
      }
      
      
      if (! is_null($CategoryName) ) {
      	// retrieve the category ID to pass into the subcategory doctrine method (retrieve list of subcategories)
      	$cat = Doctrine_Core::getTable('Category')->findOneByName($CategoryName);
      	$this->subcategories = CategoryTable::getSubCategoryList($cat->getId());
      } else {
      	$this->subcategories = array();
      }

      // establish formula for handing Baynote's starting doc number instead passing in the current page like most intelligent people would handle it
      $startingDoc = (($page * $perPage) - ($perPage - 1));

      $s = $this->baynote->search($this->term, $startingDoc, $perPage, $PageType, $Rating, $CategoryName, $withParam, $withoutParam, $recipeOwner, $attrList, $SubcategoryName, $attrSort);
      //print_r($s);
      if (sizeof($s) > 0) {
        $this->results = $s['items'];
        $this->results_total = $s['total'];
        $this->results_pager = new Arraypager(null, $perPage);
        $this->results_pager->setResultTotal($this->results_total);
        $this->results_pager->setPage($request->getParameter('page', 1));
        $this->results_pager->init();
        $this->type = $s['type'];
      } else {
        $this->results = array();
        $this->results_total = '';
        $this->results_pager = '';
        $this->type = '';
      }
    } else {
      $this->results = array();
      $this->results_total = '';
      $this->results_pager = '';
      $this->term = '';
      $this->type = '';
      $this->with = null;
      $this->without = null;
      $this->with_list = array();
      $this->without_list = array();
      $this->cat_list = array();
    }
    
    /**
     * Omniture
     */
    $this->getOmniture()->setMany(array(
      'pageName' => 'Search:Results:' . $page,
      'server' => 'www.betterrecipes.com',
      'channel' => 'Search',
      'prop5' => 'Site Search',
      'prop7' => $this->getUser()->isAuthenticated(),
      'prop10' => 'Site Search:' . $this->term,
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $this->getRequest()->getUri(),
      'eVar5' => 'Site Search:' . $this->term,
      'eVar9' => 'Search:Results:' . $page,
      'eVar14' => 'Search',
      'eVar24' => $this->getUser()->isAuthenticated(),
    ));


  }
  
  public function executePaginate_search(sfWebRequest $request)
  {
  	$this->forward404Unless($request->isXmlHttpRequest());
  	
  	// retrieve categories
    $params['excluded_cats'] = array(281, 282, 216, 217, 28, 215);
    $this->categories = CategoryTable::getMainCategoryList($params);

    $perPage = 20;
    
    $term = $request->getParameter('term');
    $page = $request->getParameter('page', 1);
    $pagetype = ($request->getParameter('pagetype')) ? $request->getParameter('pagetype') : null;
    $rating = ($request->getParameter('rating')) ? $request->getParameter('rating') : null;
    $category = ($request->getParameter('category')) ? $request->getParameter('category') : null;
    $subcategory = ($request->getParameter('subcategory')) ? $request->getParameter('subcategory') : null;
    $with = ($request->getParameter('_with')) ? $request->getParameter('_with') : null;
    $without = ($request->getParameter('without')) ? $request->getParameter('without') : null;
    $recipeOwner = ($request->getParameter('recipeOwner')) ? $request->getParameter('recipeOwner') : array();
    $attrlist = ($request->getParameter('attrList')) ? $request->getParameter('attrList') : null;
    $attrsort = ($request->getParameter('attrSort')) ? $request->getParameter('attrSort') : null;
    
      if ($with) {
	    $this->with_list = $this->explode_trim($with);
	    $withParam = $this->with_list;
	  } else {
	    $this->with_list = array();
	    $withParam = array();
	  }
	
	  if ($without) {
	    $this->without_list = $this->explode_trim($without);
	    $withoutParam = $this->without_list;
	  } else {
	    $this->without_list = array();
	    $withoutParam = array();
	  }
    
    // establish formula for handing Baynote's starting doc number instead passing in the current page like most intelligent people would handle it
    $startingDoc = (($page * $perPage) - ($perPage - 1));

	$s = $this->baynote->search($term, $startingDoc, $perPage, $pagetype, $rating, $category, $withParam, $withoutParam, $recipeOwner, $attrlist, $subcategory, $attrsort);
	
	  if (sizeof($s) > 0) {
	    $results = $s['items'];
	    $results_total = $s['total'];
	    $results_pager = new Arraypager(null, $perPage);
	    $results_pager->setResultTotal($results_total);
	    $results_pager->setPage($page);
	    $results_pager->init();
	    $type = $s['type'];
	  } else {
	    $results = array();
	    $results_total = '';
	    $results_pager = '';
	    $type = '';
	  }

    
  	$this->renderPartial('result_list', compact('results', 'results_pager', 'term', 'pagetype', 'rating', 'category', 'subcategory', 'with', 'without', 'type', 'attrlist', 'attrsort'));
    return sfView::NONE;
  	
  }

  protected function explode_trim($str, $delimiter = ',')
  {
    $a = array();
    if (is_string($delimiter)) {
      $str = trim(preg_replace('|\\s*(?:' . preg_quote($delimiter) . ')\\s*|', $delimiter, $str));
      //return explode($delimiter, $str);
      $parts = explode($delimiter, $str);
      foreach ($parts as $v) {
        if ($v != '') {
          array_push($a, $v);
        }
      }
      return $a;
    }
    return $str;
  }

}
