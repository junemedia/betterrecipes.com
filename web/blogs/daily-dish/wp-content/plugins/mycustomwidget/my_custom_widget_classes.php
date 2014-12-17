<?php
/*
Author: Janek Niefeldt
Author URI: http://www.janek-niefeldt.de/
Description: Configuration of My Custom Widgets Plugin.
*/
include_once('my_custom_widget_functions.php');
include_once('my_custom_widget_meta.php');
?><?php
class MCW_Trending_Food extends WP_Widget
{
	function MCW_Trending_Food(){
		$widget_ops = array('classname' => 'MCW_Trending_Food', 'description' => 'CustomWidget generated with MCW &raquo;' );
		$control_ops = array('width' => 345);
		$this->WP_Widget('MCW_Trending_Food', 'MCW: Trending_Food', $widget_ops, $control_ops);
	}
	function widget($args, $instance){
		$args['name'] = 'Trending_Food';
		MCW_eval_code($args);
	}
	function update($new_instance, $old_instance){
	  $new_instance['title'] = MCW_get_widget_info('Trending_Food', 'title');
		return $new_instance;
	}
	function form($instance){
    MCW_get_official_form('Trending_Food');	  
  }
}
	function MCW_Trending_FoodInit() {
	  register_widget('MCW_Trending_Food');
	}
	add_action('widgets_init', 'MCW_Trending_FoodInit');
?><?php
class MCW_cage_test extends WP_Widget
{
	function MCW_cage_test(){
		$widget_ops = array('classname' => 'MCW_cage_test', 'description' => 'CustomWidget generated with MCW &raquo;' );
		$control_ops = array('width' => 345);
		$this->WP_Widget('MCW_cage_test', 'MCW: cage_test', $widget_ops, $control_ops);
	}
	function widget($args, $instance){
		$args['name'] = 'cage_test';
		MCW_eval_code($args);
	}
	function update($new_instance, $old_instance){
	  $new_instance['title'] = MCW_get_widget_info('cage_test', 'title');
		return $new_instance;
	}
	function form($instance){
    MCW_get_official_form('cage_test');	  
  }
}
	function MCW_cage_testInit() {
	  register_widget('MCW_cage_test');
	}
	add_action('widgets_init', 'MCW_cage_testInit');
?>