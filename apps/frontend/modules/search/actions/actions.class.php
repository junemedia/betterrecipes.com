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

  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
//    $this->baynote = new Baynote_rest();
    // retrieve categories
    $params['excluded_cats'] = array(281, 282, 216, 217, 28, 215);
    $this->categories = CategoryTable::getMainCategoryList($params);

    $perPage = 20;
    if ($this->term = $request->getParameter('term')) {
      $page = $request->getParameter('page', 1);
      $PageType = ($request->getParameter('PageType')) ? $request->getParameter('PageType') : null;
      $Rating = ($request->getParameter('Rating')) ? $request->getParameter('Rating') : null;
      $CategoryName = ($request->getParameter('CategoryName')) ? $request->getParameter('CategoryName') : null;
      $this->totalCats = $CategoryName;
      $this->with = ($request->getParameter('with')) ? $request->getParameter('with') : null;
      $this->without = ($request->getParameter('without')) ? $request->getParameter('without') : null;
      $this->recipe_owner = ($request->getParameter('recipeOwner')) ? $request->getParameter('recipeOwner') : null;

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

      if ($this->recipe_owner) {
        $this->recipe_owner_list = $this->explode_trim($this->recipe_owner);
        $recipeOwner = $this->recipe_owner_list;
      } else {
        $this->recipe_owner_list = array();
        $recipeOwner = array();
      }

      if ($CategoryName) {
        $this->cat_list = $this->explode_trim($CategoryName);
      } else {
        $this->cat_list = array();
      }

      // establish formula for handing Baynote's starting doc number instead passing in the current page like most intelligent people would handle it
      $startingDoc = (($page * $perPage) - ($perPage - 1))-1;
      
		$curl = curl_init();
		$q = $this->term."%22";
		if (count($withoutParam) > 0)
			foreach ($withoutParam as $wo)
				$q .= "%20-text:%22".$wo."%22";

		if (count($withParam) > 0)
			foreach ($withParam as $ww)
				$q .= "%20+text:%22".$ww."%22";
		
		if ($q)
		{
			$q = str_replace("+","%20",$q);
			$q = str_replace(" ","%20",$q);
		}	
                $url = 'http://162.209.125.67:8080/solr/collection1/select?q=text%3A%22'.$q.'&sort=Rating+desc,Title+asc&wt=xml&indent=true&rows='.$perPage."&start=".$startingDoc."&fq=PageType:".$PageType;		
		//$url = 'http://23.251.155.98:8080/solr/collection1/select?q=text%3A%22'.$q.'&sort=Rating+desc,Title+asc&wt=xml&indent=true&rows='.$perPage."&start=".$startingDoc."&fq=PageType:".$PageType;
//		$url = 'http://192.168.59.103:8080/solr/collection1/select?q=text%3A%22'.$q.'&sort=Rating+desc,Title+asc&wt=xml&indent=true&rows='.$perPage."&start=".$startingDoc."&fq=PageType:".$PageType;
		if ($Rating)
			$url .= "&Rating:[".$Rating."%20TO%20*]";
		if ($CategoryName)
			$url .= "&fq=CategoryName:".str_replace(" ","+",$CategoryName);


		if ($this->recipe_owner)
			$url .= "&fq=AuthorName%3A".str_replace(" ","+",$this->recipe_owner);

		//echo $url;
		//http://192.168.59.103:8080/solr/collection1/select?q=text%3Achicken&sort=Rating+desc,Title+asc&wt=xml&indent=true&fq=PageType:blogs&start=10&rows=20
		//http://192.168.59.103:8080/solr/collection1/select?q=text%3Achicken&sort=Rating+desc,Title+asc&wt=xml&indent=true&fq=PageType:Recipe&start=10&rows=20
		//http://192.168.59.103:8080/solr/collection1/select?q=text%3Achicken&sort=Rating+desc,Title+asc&wt=xml&indent=true&fq=PageType:Recipe&Rating:[4%20TO%20*]&start=10&rows=20
		//http://192.168.59.103:8080/solr/collection1/select?q=text%3Achicken%20-text:rice%20&sort=Rating+desc,Title+asc&wt=xml&indent=true&fq=PageType:Recipe&Rating:[4%20TO%20*]&start=10&rows=20
		//http://192.168.59.103:8080/solr/collection1/select?q=text%3Achicken%20+text:rice%20&sort=Rating+desc,Title+asc&wt=xml&indent=true&fq=PageType:Recipe&Rating:[4%20TO%20*]&start=10&rows=20
		//http://192.168.59.103:8080/solr/collection1/select?q=text%3A%22chicken%22+AuthorName%3A+%22Dani1%22&wt=json&indent=true&start=10&rows=20
		//http://192.168.59.103:8080/solr/collection1/select?q=text%3Achicken&fq=AuthorName%3AA123456&fq=PageType%3ARecipe&wt=json&indent=true

		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url,
			CURLOPT_USERAGENT => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1309.0 Safari/537.17'
		));
		// Send the request & save response to $resp
		$resp = curl_exec($curl);
//echo $resp;

		if(!curl_exec($curl)){
			die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
		}
		// Close request to clear up some resources
		curl_close($curl);

      
//      $s = $this->baynote->search($this->term, $startingDoc, $perPage, $PageType, $Rating, $CategoryName, $withParam, $withoutParam, $recipeOwner);
//echo $resp;
		$xml_object = simplexml_load_string( $resp );
//		echo $xml_object->result["numFound"].":".$s['total']."<BR>\n";
//		echo $xml_object->result[0]->doc[0]->str[0]."<BR>\n";
		$solr_results = array();

/*		
		$XMLResults = $xml_object->xpath('/response/result/doc');
		foreach($XMLResults as $rr) {
//			print_r($rr);
			$AuthorAttribute = $rr->xpath('//str[@name="Description"]');
			// Make sure there's an author attribute
			if($AuthorAttribute) {
//				echo "found:".$AuthorAttribute[0]."\n";			
//			   	echo "\n----\n";
			  // because we have a list of elements even if there's one result
//			  $attributes = $AuthorAttribute[0]->attributes();
//			  $Author = $attributes['value'];
			//print_r($AuthorAttribute[0]);
//			  echo $Author;
			}
			else {
			  // No Author
//			  echo "none\n";
			}
		}
//*/

		foreach($xml_object->result[0]->doc as $doc) 
		{		
			$solr_doc = array();
            $solr_doc['subdir'] = "";
			$solr_doc['image'] = "";
			$solr_doc['description'] = "";
			$solr_doc['title'] = "";
			$solr_doc['rating'] = "";
			$solr_doc['date'] = "";
			$solr_doc['id'] = "";
            
			foreach($doc->str as $str)
			{
				switch($str->attributes())
				{
					case "Description":
						$solr_doc['description'] = $str;
						break;
					case "Title":
						$solr_doc['title'] = $str;
						break;
					case "Rating":
						$solr_doc['rating'] = $str;
			            $solr_doc['baynote_bnrank'] = $str;
						break;
					case "PubDate":
						$solr_doc['date'] = $str;
						break;
					case "Image":
						$solr_doc['image'] = $str;
						break;
					case "id":
						$solr_doc['url'] = $str;
						break;
				}
//				echo $str."\n";
			}
            $solr_doc['baynote_irrank'] = 0;
            $solr_doc['display_name'] = "";
			$solr_results[] = $solr_doc;			
//			print_r($doc);
		}
//		echo "\n----\n";
//		echo sizeof($solr_results);
		//print_r($xml_object);
//		echo $this->term.":".$startingDoc.":".$perPage.":".$PageType.":".$Rating.":".$s['type'];
//		print_r($CategoryName);
//		print_r($withParam);
//		print_r($withoutParam);
//		print_r($recipeOwner);

//	    print_r($s['items']);

//*

//      if (sizeof($s) > 0) {
      if (sizeof($solr_results) > 0) {
        $this->results = $solr_results;//$s['items'];
        $this->results_total = $xml_object->result["numFound"];//$s['total'];
        $this->results_pager = new Arraypager(null, $perPage);
        $this->results_pager->setResultTotal($this->results_total);
        $this->results_pager->setPage($request->getParameter('page', 1));
        $this->results_pager->init();
        $this->type = $PageType;//$s['type'];

/*
        $this->results = $s['items'];
        $this->results_total = $s['total'];
        $this->results_pager = new Arraypager(null, $perPage);
        $this->results_pager->setResultTotal($this->results_total);
        $this->results_pager->setPage($request->getParameter('page', 1));
        $this->results_pager->init();
        $this->type = $s['type'];
//*/
      } else {
        $this->results = array();
        $this->results_total = '';
        $this->results_pager = '';
        $this->type = '';
      }
//*/
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
      $this->recipe_owner = array();
      $this->recipe_owner_list = array();
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
