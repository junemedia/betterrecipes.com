<?php
/*
Plugin Name: Paulund Pinterest Add Pin Buttons
Plugin URI: http://www.paulund.co.uk
Description: This plugin will automatically add pin buttons to all the images in your content
Author: Paul Underwood
Author URI: http://www.paulund.co.uk
Version: 1
*/

/**
* If not in the admin area then run the pinterest pin button
*/
if(!is_admin()){
	new Paulund_Pinterest_Pin_Button();
}

/**
* Paulund pinterest pin button plugin, will automatically add pins to buttons
*/
class Paulund_Pinterest_Pin_Button
{
	/**
	 * The constructor class for the pinterest pin button plugin
	 */
	function __construct()
	{
		// Add the style sheet to the pin button
		wp_enqueue_style('Paulund_Pinterest_Pin_Button', plugins_url( '/paulund-pinterest-add-pin-buttons/style.css' ) ); 

		// Register the pinterest Javascript script
		wp_register_script("pinterest-js-script", "http://assets.pinterest.com/js/pinit.js", array(), '1.0.0', true);
		wp_enqueue_script("pinterest-js-script");

		// Add the pin button inside the content filter
		add_filter('the_content', array(&$this, 'Add_Pin_Button') );
	}

	/**
	 * Adds the pin button to each image inside the content
	 */
	public function Add_Pin_Button($content){
		global $post;

		// Get the post urls
		$posturl = urlencode(get_permalink());

		// Define a pattern to find all images inside the content
		$pattern = '/<a(.*?)><img(.*?)src="(.*?).(bmp|gif|jpeg|jpg|png)" (.*?) width="(.*?)" height="(.*?)" \/><\/a>/i';
	  	
	  	// Replace the images with the following div and pin button
		$button_div = '
		<div class="paulund-pinterest-container">
			<div class="paulund-pinterest-button" style="width:$6px;height:$7px;">
			<a href="http://pinterest.com/pin/create/button/?url=
			'.$posturl.'
			&media=$3.$4
			&description='.urlencode(get_the_title()).'" class="pin-it-button" count-layout="none">Pin It</a>
			<a$1>
			    <img$2src="$3.$4" $5 width="$6" height="$7" />
			</a>
			</div>
		</div>';

		// Replace the images with a containing div with a pin button on the image
		$content = preg_replace( $pattern, $button_div, $content );

		return $content;
	}
}

?>