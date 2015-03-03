<?php

class Arraypager extends sfPager {

	protected $resultsTotal = null;
	protected $resultsArray = null;
	
	
	public function __construct($class = null, $maxPerPage = 10) {
    	parent::__construct($class, $maxPerPage);
  	}
  	
  	public function init() {
    	$this->setNbResults($this->resultsTotal);
    	if (($this->getPage() == 0 || $this->getMaxPerPage() == 0)) {
	    	$this->setLastPage(0);
    	} else {
        	$this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));
    	}
  	}
  	
  	public function setResultTotal($total) {
    	$this->resultsTotal = $total;
  	}
 
  	public function getResultTotal() {
  		return $this->resultsTotal;
  	}
  	
  	
  	/* note, these other functions can be used if you wish to pass in an entire array object 
  	and have the total results be calculated via array count, but it is very inefficient
  	*/
  	public function setResultArray($array) {
    	$this->resultsArray = $array;
  	}
 
	public function getResultArray() {
	    return $this->resultsArray;
	}
	 
	public function retrieveObject($offset) {
	    return $this->resultsArray[$offset];
	}
	 
	public function getResults() {
	    return array_slice($this->resultsArray, ($this->getPage() - 1) * $this->getMaxPerPage(), $this->maxPerPage);
	}
  	
  	
  	/*
  	=====================================================
  	 ArrayPager - by Rusty Cage
  	=====================================================
  	 Purpose: use sfPager class to page through an array of results
  	=====================================================
  	 usage:
  	 
  	 $this->pager = new Arraypager(null, 15);
  	 $this->pager->setResultTotal(100);
  	 $this->pager->setPage($this->getRequestParameter('page',1));
  	 $this->pager->init();
  	 
  	 for additional documentation on using standard sfPager 
  	 paging methods, visit:
  	 http://svn.symfony-project.com/tags/RELEASE_0_4_2/doc/book/content/pager.txt
  	=====================================================
  	*/
	
}