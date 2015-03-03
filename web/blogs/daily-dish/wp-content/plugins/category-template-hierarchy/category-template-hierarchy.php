<?php
/*
Plugin Name: Category Template Hierarchy
Plugin URI: http://eddiemoya.com/
Description:  Adds parent-category.php & child-category.php to the template hierarchy with all the normal hierarchical behavior with conditional tags to match: is_child_category() and is_parent_category()
Version: 1.3.2.1
Author: Eddie Moya


Copyright (C) 2012 Eddie Moya (eddie.moya+wp@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

/**
 * @todo Add 'grandchild' templates, or some sort of #-nth-child-of-category-{slug}.php template, with accompanying conditional functions of course.
 */

class Category_Template_Hierarchy {
    
    /**
     * @author Eddie Moya
     * 
     * Start your engines.
     */
    function init(){
        add_filter('category_template', array( __CLASS__,'category_relationship'));
    }
    
    /**
     * @author Eddie Moya
     * 
     * Determines the correct relationship status of a category and redirects accordingly.
     */
    public function category_relationship() {
        if (is_category()) {
            $parent_category = null;
            $template_prefix = array();

            if (is_parent_category())
                $template_prefix[] = "parent";
                $parent_category = get_category(get_queried_object()->parent);

            if (is_child_category())
                $template_prefix[] = "child";

            return self::category_template_redirect($template_prefix, $parent_category);
        }
    }
    
    /**
     * @author Eddie Moya
     * 
     * Compiles the list of possible templates that are available for the current 
     * page being displayed, and sends that array off the get_query_template for
     * redirection.
     */
    private function category_template_redirect($template_prefix = array(), $parent_category = null) {
        
        $category = get_queried_object();
        
        $template = "category";
        
        if(in_array('child', $template_prefix)){
            $templates[] = "child-of-{$template}-{$parent_category->slug}.php";
        }
        $templates[] = "{$template}-{$category->slug}.php";

        if(in_array('child', $template_prefix)){
            $templates[] = "child-of-{$template}-{$category->parent}.php";
        }
        $templates[] = "{$template}-{$category->term_id}.php";
        
        $templates = array_merge($templates, self::add_template_set($template_prefix));
        
        $templates[] = "category.php";
        $templates[] = "archive.php";
        $templates[] = "index.php"; 
        
        return apply_filters('cth_category_template', locate_template( $templates ));
    }
    
    /**
     * @author Eddie Moya
     */
    private function add_template_set($template_prefixes, $template_suffix = null, $template_base = "category"){
        
        $templates = array();
        foreach((array)$template_prefixes as $template_prefix){
         
            unset($template_parts);
            
            if($template_prefix) $template_parts[] = $template_prefix;
            $template_parts[] = $template_base;
            if($template_suffix) $template_parts[] = $template_suffix;
                
            $template_name = implode("-", $template_parts);
            
            $templates[] = $template_name . ".php";
        }
        
        return $templates;
    }
    
    /**
     * @author Eddie Moya
     */
    function prefix_suffix($pf, $suffix){
        foreach($pf as $prefix){
            $ret[] = $prefix . $suffix;
        }
        return $ret;
    }
}
Category_Template_Hierarchy::init();


/**
 * @author Eddie Moya
 * 
 * This conditional tag checks if the page being displayed is for a category that has children (e.g. is a parent category).
 * 
 * @param object $category [optional] Category object. Default: Current Category
 * @return bool Returns true if category is a parent, otherwise returns false.
 */
function is_parent_category($category = null){
    
    $category = (is_numeric($category)) ? get_the_category_by_ID($category)	: $category;
    $category = (is_string($category))  ? get_category_by_slug($category)   : $category;
    $category = (is_null($category))    ? get_queried_object()          	: $category;
    
    $children = get_categories("parent={$category->term_id}&hide_empty=0");
    return empty($children) ? false : true;
}

/**
 * @author Eddie Moya
 * 
 * This conditional tag checks if the page being displayed is for a category that has a parent (e.g. is a child category).
 * 
 * @param object $category [optional] Category object. Default Current Category
 * @return bool Returns true if category has a parent, otherwise returns false.
 * @todo It would be nice to condense this down and make it more like the is_category function in WP_Query
 */
function is_child_category($category = null){
    
    $category = (is_numeric($category)) ? get_the_category_by_ID($category)	: $category;
    $category = (is_string($category))  ? get_category_by_slug($category) 	: $category;
    $category = (is_null($category))    ? get_queried_object()          	: $category;

    return ($category->parent != 0) ? true : false;
}

/**
 * @author Eddie Moya
 * 
 * This conditional tag checks if the page being displayed is of a category that
 * has parent (e.g. is a child category).
 * 
 * @uses cat_is_ancestor_of()
 * 
 * @param object|string|integer $category [required] Category of the would-be child.
 * @param object|string|integer $child_category [optional]. Category of the would-be parent. Default Current Category
 * @param bool $direct_descendant [optional] If set to true, this function will check if the parent is a direct parent of the given child. If false it will check it the child is a descentant of any distance.
 * 
 * @return bool If the $direct_descendant flag set to true, function returns true if the child is a direct descendant of the parent, if child is no direct it will return false. If $direct_descendant is set to false it will return the same results as cat_is_ancestor_of().
 * @todo It would be nice to condense this down and make it more like the is_category function in WP_Query
 */
function is_parent_of_category($child_category, $parent_category = null, $direct_descendant = true){
    
    $child_category = (is_numeric($child_category)) 	?   get_the_category_by_ID($child_category) : $child_category;
    $child_category = (is_string($child_category))  	?   get_category_by_slug($child_category)   : $child_category;

    $parent_category = (is_numeric($parent_category))	? get_the_category_by_ID($parent_category) 	: $parent_category;
    $parent_category = (is_string($parent_category))  	? get_category_by_slug($parent_category)   	: $parent_category;
    $parent_category = (is_null($parent_category))    	? get_queried_object()                     	: $parent_category;

    if(!isset($child_category->parent) || !isset($parent_category->term_id) )
        return false;
    
    return ($direct_descendant) ? ($child_category->parent == $parent_category->term_id ) : cat_is_ancestor_of($parent_category, $child_category);

}

/**
 * @author Eddie Moya
 * 
 * This conditional tag checks if the page being displayed is of a category that
 * has parent (e.g. is a child category).
 * 
 * @uses cat_is_ancestor_of()
 * 
 * @param object|string|integer $category [required] Category of the would-be parent.
 * @param object|string|integer $child_category [optional]. Category of the would-be child. Default Current Category
 * @param bool $direct_descendant [optional] If set to true, this function will check if the child is a direct child of the given parent. If false it will check it the parent is an ancestor of any distance.
 * 
 * @return bool If the $direct_descendant flag set to true, function returns true if the child is a direct descendant of the parent, if child is no direct it will return false. If $direct_descendant is set to false it will return the same results as cat_is_ancestor_of().
 * @todo It would be nice to condense this down and make it more like the is_category function in WP_Query
 */
function is_child_of_category($parent_category, $child_category = null, $direct_descendant = true){
    
    $parent_category = (is_numeric($parent_category)) 	? get_the_category_by_ID($parent_category)	: $parent_category;
    $parent_category = (is_string($parent_category)) 	? get_category_by_slug($parent_category) 	: $parent_category;

    $child_category = (is_numeric($child_category)) 	? get_the_category_by_ID($child_category) 	: $child_category;
    $child_category = (is_string($child_category)) 		? get_category_by_slug($child_category) 	: $child_category;
    $child_category = (is_null($child_category)) 		? get_queried_object() 						: $child_category;

    if(!isset($child_category->parent) || !isset($parent_category->term_id) )
        return false;
    
    return ($direct_descendant) ? ($child_category->parent == $parent_category->term_id ) : cat_is_ancestor_of($parent_category, $child_category);
}


