<?php
/*
Plugin Name: Search Regex
Plugin URI: http://urbangiraffe.com/plugins/search-regex
Description: Adds search &amp; replace functionality across posts, pages, comments, and meta-data, with full regular expression support
Author: John Godley
Version: 1.4.11
Author URI: http://urbangiraffe.com/
*/

include (dirname (__FILE__).'/plugin.php');

class SearchRegex extends SearchRegex_Plugin
{
	function SearchRegex ()
	{
		if (is_admin ())
		{
			include (dirname (__FILE__).'/models/search.php');
			include (dirname (__FILE__).'/models/result.php');

			$this->register_plugin ('search-regex', __FILE__);
			$this->add_filter ('admin_menu');
			
			if (strstr ($_SERVER['REQUEST_URI'], 'search-regex.php'))
			{
				wp_enqueue_script ('prototype');
				wp_enqueue_script ('scriptaculous');
				$this->add_filter ('admin_head');
			}
		}
	}
	
	function admin_screen ()
	{	
		$searches = Search::get_searches ();
		
		$search_pattern = $replace_pattern = '';
		if (isset ($_POST['search_pattern']))
			$search_pattern  = stripslashes( $_POST['search_pattern'] );
		if (isset ($_POST['replace_pattern']))
			$replace_pattern = stripslashes( $_POST['replace_pattern'] );

		$search_pattern  = str_replace ("\'", "'", $search_pattern);
		$replace_pattern = str_replace ("\'", "'", $replace_pattern);
		$orderby         = isset( $_POST['orderby'] ) ? stripslashes( $_POST['orderby'] ) : '';
		$limit           = isset( $_POST['limit'] ) ? intval( $_POST['limit'] ) : 0;
		$offset          = 0;
		
		$source = isset( $_POST['source'] ) ? stripslashes( $_POST['source'] ) : '';
		
		if (Search::valid_search ($source) && (isset ($_POST['search']) || isset ($_POST['replace']) || isset ($_POST['replace_and_save'])))
		{
			$klass = stripslashes( $_POST['source'] );
			$searcher = new $klass;
			if (isset ($_POST['regex']))
				$searcher->set_regex_options ($_POST['dotall'], $_POST['case'], $_POST['multi']);
			
			// Make sure no one sneaks in with a replace
			if (!current_user_can ('administrator') && !current_user_can ('search_regex_write'))
			{
				unset ($_POST['replace']);
				unset ($_POST['replace_and_save']);
				$_POST['search'] = 'search';
			}
			
			$results = array();
			if (isset ($_POST['search']))
				$results = $searcher->search_for_pattern (stripslashes( $_POST['search_pattern'] ), $limit, $offset, $orderby);
			else if (isset ($_POST['replace']))
				$results = $searcher->search_and_replace (stripslashes( $_POST['search_pattern'] ), stripslashes( $_POST['replace_pattern'] ), $limit, $offset, $orderby);
			else if (isset ($_POST['replace_and_save']))
				$results = $searcher->search_and_replace (stripslashes( $_POST['search_pattern'] ), stripslashes( $_POST['replace_pattern'] ), $limit, $offset, $orderby, true);
			
			if (!is_array ($results))
				$this->render_error ($results);
			else if (isset ($_POST['replace_and_save']))
				$this->render_message (sprintf ('%d occurrence(s) replaced', count ($results)));

			$this->render_admin ('search', array ('search' => $search_pattern, 'replace' => $replace_pattern, 'searches' => $searches));

			if (is_array ($results) && !isset ($_POST['replace_and_save']))
				$this->render_admin ('results', array ('search' => $searcher, 'results' => $results));
		}
		else
			$this->render_admin ('search', array ('search' => $search_pattern, 'replace' => $replace_pattern, 'searches' => $searches));
	}
	
	function admin_menu ()
	{
		if (current_user_can ('administrator'))
    	add_management_page (__ ("Search Regex", 'search-regex'), __ ("Search Regex", 'search-regex'), 'administrator', basename (__FILE__), array (&$this, 'admin_screen'));
		else if (current_user_can ('search_regex_read'))
    	add_management_page (__ ("Search Regex", 'search-regex'), __ ("Search Regex", 'search-regex'), 'search_regex_read', basename (__FILE__), array (&$this, 'admin_screen'));
	}
	
	function admin_head ()
	{
		$this->render_admin ('head');
	}
}

$search_regex = new SearchRegex;
?>