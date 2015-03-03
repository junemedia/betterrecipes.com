<?php
/* 
Plugin Name: Mobile Theme Switcher
Plugin URI: http://www.jeremyarntz.com
Description: Plugin that allows you to set separate themes for the iPad, iPhone/iPod Touch, and Android Browsers
Author: Jeremy Arntz 
Version: 0.6
Author URI: http://www.jeremyarntz.com
*/

/*  Copyright 2010  Jeremy Arntz  (email : jeremy@jeremyarntz.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ($_SERVER['DEVICE'] > 0){ 
	add_filter('stylesheet', 'getMobileTemplate');
	add_filter('template', 'getMobileTemplate');
}

function getMobileTemplate(){
	$mobileTheme =  get_option('mobile_theme');
    $themeList = get_themes();
	foreach ($themeList as $theme) {
	  if ($theme['Name'] == $mobileTheme) {
	      return $theme['Stylesheet'];
	  }
	}	
}

include('mts_options.php');
?>