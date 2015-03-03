<?php

/*
Plugin Name: RSS Count Comments
Plugin URI: http://blog.ickata.net/rss-count-comments/
Description: Simple plugin that shows the number of comments in the RSS after Posts' Titles (similar to TextPattern)
Author: Hristo Chakarov
Version: 1.0
Author URI: http://blog.ickata.net/
License: GPL
*/

/*

    Copyright 2009 HRISTO CHAKAROV  (email : mail@ickata.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	
*/

function rss_count_comments(){
	global $wpdb,$post;
	$args = func_get_args();
	$comments = get_comments_number();
	echo $args[0];
	if ($comments>0) echo ' [',$comments,']';
}

add_action('the_title_rss','rss_count_comments');

?>