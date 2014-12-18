<?php



/*

Plugin Name: Gallery Slider

Plugin URI: http://cameronpreston.com/projects/plugins/gallery-slider-pro/

Author: Cameron Preston

Author URI: http://cameronpreston.com

Description: Gallery Slider is a slideshow that integrates with the WordPress image attachment feature, as well as a custom slide manager. Thumbnails and captions galore! Use this <code>[slideshow]</code> into its content with optional <code>post_id</code>, <code>exclude</code>, <code>auto</code>, and <code>caption</code> parameters.

Version: 0.1

*/



define('DS', DIRECTORY_SEPARATOR);



define( 'GS_VERSION', '1.1' );



if ( ! defined( 'GS_PLUGIN_BASENAME' ) )

	define( 'GS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );



if ( ! defined( 'GS_PLUGIN_NAME' ) )

	define( 'GS_PLUGIN_NAME', trim( dirname( GS_PLUGIN_BASENAME ), '/' ) );



if ( ! defined( 'GS_PLUGIN_DIR' ) )

	define( 'GS_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . GS_PLUGIN_NAME );



if ( ! defined( 'GS_PLUGIN_URL' ) )

	define( 'GS_PLUGIN_URL', WP_PLUGIN_URL . '/' . GS_PLUGIN_NAME );



if ( ! defined( 'GS_UPLOAD_URL' ) )

	define( 'GS_UPLOAD_URL', get_bloginfo('wpurl')."/wp-content/uploads/". GS_PLUGIN_NAME );





if (! file_exists( GS_PLUGIN_DIR . '/pro/')) {

	define( 'GS_PRO', false);

}

else {

	define( 'GS_PRO', true);

}





define( 'GS_CSS_SHOW', 'off' );



require_once GS_PLUGIN_DIR . '/gallery-slider-plugin.php';



class GSlider extends GSliderPlugin {



	function GSlider() {

		$url = explode("&", $_SERVER['REQUEST_URI']);

		$this -> url = $url[0];

		

		$this -> register_plugin('gallery-slider', __FILE__);

		

		//WordPress action hooks

		$this -> add_action('admin_menu');

		$this -> add_action('admin_head');

		$this -> add_action('admin_notices');

//		$this -> add_action('gs_enqueue_styles');

		

		//WordPress filter hooks

		$this -> add_filter('mce_buttons');

		$this -> add_filter('mce_external_plugins');

		

		add_shortcode('gslider', array($this, 'embed'));

	}

	

	function admin_menu() {

		add_menu_page(__('GallerySlider', $this -> plugin_name), __('GallerySlider', $this -> plugin_name), 'manage_options', "gslider", array($this, 'admin_settings'), GS_PLUGIN_URL . '/images/icon.png');

		$this -> menus['gslider'] = add_submenu_page("gslider", __('Configuration', $this -> plugin_name), __('Configuration', $this -> plugin_name), 'manage_options', "gslider", array($this, 'admin_settings'));

		$this -> menus['gslider-slides'] = add_submenu_page("gslider", __('Manage Slides', $this -> plugin_name), __('Manage Slides', $this -> plugin_name), 'manage_options', "gslider-slides", array($this, 'admin_slides'));

		add_action('admin_head-' . $this -> menus['gslider'], array($this, 'admin_head_gslider_settings'));

	}

	

	function admin_head() {

		$this -> render('head', false, true, 'admin');

	}

	

	function admin_head_gslider_settings() {		

		add_meta_box('submitdiv', __('Save Settings', $this -> plugin_name), array($this -> Metabox, "settings_submit"), $this -> menus['gslider'], 'side', 'core');

		add_meta_box('generaldiv', __('General Settings', $this -> plugin_name), array($this -> Metabox, "settings_general"), $this -> menus['gslider'], 'normal', 'core');

		add_meta_box('stylesdiv', __('Appearance &amp; Styles', $this -> plugin_name), array($this -> Metabox, "settings_styles"), $this -> menus['gslider'], 'normal', 'core');

		

		do_action('do_meta_boxes', $this -> menus['gslider'], 'normal');

		do_action('do_meta_boxes', $this -> menus['gslider'], 'side');

		

	}

	

	function admin_notices() {

		$this -> check_uploaddir();

	

		if (!empty($_GET[$this -> pre . 'message'])) {		

			$msg_type = (!empty($_GET[$this -> pre . 'updated'])) ? 'msg' : 'err';

			call_user_method('render_' . $msg_type, $this, $_GET[$this -> pre . 'message']);

		}

	}

	

	function mce_buttons($buttons) {

		array_push($buttons, "separator", "gslider");

		return $buttons;

	}

	

	function mce_external_plugins($plugins) {

		$plugins['gslider'] = GS_PLUGIN_URL . '/js/tinymce/editor_plugin.js';

		return $plugins;

	}



	function slideshow($output = true, $post_id = null, $exclude = null, $include = null) {		

//		$this -> add_action( 'wp_print_styles', 'gs_enqueue_styles' );



		global $wpdb;

		$post_id_orig = $post -> ID;



		if (!empty($post_id) && $post = get_post($post_id)) {

			if ($attachments = get_children("post_parent=" . $post -> ID . "&post_type=attachment&post_mime_type=image&orderby=menu_order ASC, ID ASC")) {

				$content = $this -> exclude_ids($attachments, $exclude, $include);

			}

		}

		else {

			

			$slides = $this -> Slide -> find_all(null, null, array('order', "ASC"));

/*			print "<script>alert($slides)</script>";*/

			$content = $this -> render('gslider', array('slides' => $slides, 'frompost' => false), false, 'default');

		}

		$post -> ID = $post_id_orig;

		if ($output) { echo $content; } else { return $content; }

	}



	function embed($atts = array(), $content = null) {

		//global variables

		global $wpdb;

		

		$defaults = array('post_id' => null, 'exclude' => null, 'include' => null, 'custom' => null, 'caption' => null, 'auto' => null, 'w' => null, 'h' => null, 'nolink' => null);

		extract(shortcode_atts($defaults, $atts));



		if ($this -> get_option('information')=='Y') { $this -> update_option('information_temp', 'Y'); }

		elseif ($this -> get_option('information')=='N') { $this -> update_option('information_temp', 'N'); }

		if ($this -> get_option('autoslide')=='Y') { $this -> update_option('autoslide_temp', 'Y'); }

		elseif ($this -> get_option('autoslide')=='N') { $this -> update_option('autoslide_temp', 'N'); }



		if (!empty($caption)) { 

			if (($this -> get_option('information')=='Y') && ($caption == 'off')) {

				$this -> update_option('information_temp', 'N');	

			}

			elseif (($this -> get_option('information')=='N') && ($caption == 'on')) {

				$this -> update_option('information_temp', 'Y');

			}

		}

		if (!empty($auto)) { 

			if (($this -> get_option('autoslide')=='Y') && ($auto == 'off')) {

				$this -> update_option('autoslide_temp', null);	

			}

			elseif (($this -> get_option('autoslide')=='N') && ($auto == 'on')) {

				$this -> update_option('autoslide_temp', 'Y');

			}

		}

		/******** PRO ONLY **************/

		if ( GS_PRO ) {

			require GS_PLUGIN_DIR . '/pro/custom_sizing.php';

		}

		//$this -> add_action(array($this, 'pro_custom_wh'));

		/******** END PRO ONLY **************/



		if (!empty($nocaption)) { $this -> update_option('information', 'N'); }

		if (!empty($nolink)) { $this -> update_option('link', 'N'); }

			else { $this -> update_option('link', 'Y'); }



		if (!empty($custom)) {

			$slides = $this -> Slide -> find_all(null, null, array('order', "ASC"));

			$content = $this -> render('gslider', array('slides' => $slides, 'frompost' => false), false, 'default');

		} else {

			global $post;

			$post_id_orig = $post -> ID;

			$pid = (empty($post_id)) ? $post -> ID : $post_id;

		

			if (!empty($pid) && $post = get_post($pid)) {

				if ($attachments = get_children("post_parent=" . $post -> ID . "&post_type=attachment&post_mime_type=image&orderby=menu_order ASC, ID ASC")) {

					$content = $this->exclude_ids($attachments, $exclude, $include);

				}

			}

			$post -> ID = $post_id_orig;

		}

		return $content;

	}



	public function exclude_ids($attachments, $exclude, $include) {

		if (!empty($exclude)) {

			$exclude = array_map('trim', explode(',', $exclude));

/*			echo("<script type='text/javascript'>alert('exclude! ".$exclude[0]."');</script>");*/



			foreach ($attachments as $id => $attachment) {

				if (in_array($id, $exclude)) {

					unset($attachments[$id]);

				}

			}

		}

		elseif (!empty($include)) {

			$include = array_map('trim', explode(',', $include));

/*			echo("<script type='text/javascript'>alert('include!".$include[0]."');</script>");*/

			foreach ($attachments as $id => $attachment) {

				if (in_array($id, $include)) {}

				else { unset($attachments[$id]); }

			}

		}

		$content = $this -> render('gslider', array('slides' => $attachments, 'frompost' => true), false, 'default');

		return $content;

	}	



	function admin_slides() {	

		switch ($_GET['method']) {

			case 'save'				:

				if (!empty($_POST)) {

					if ($this -> Slide -> save($_POST, true)) {

						$message = __('Slide has been saved', $this -> plugin_name);

						$this -> redirect($this -> url, "message", $message);

					} else {

						$this -> render('slides' . DS . 'save', false, true, 'admin');

					}

				} else {

					$this -> Db -> model = $this -> Slide -> model;

					$this -> Slide -> find(array('id' => $_GET['id']));

					$this -> render('slides' . DS . 'save', false, true, 'admin');

				}

				break;

			case 'mass'				:

				if (!empty($_POST['action'])) {

					if (!empty($_POST['Slide']['checklist'])) {						

						switch ($_POST['action']) {

							case 'delete'				:							

								foreach ($_POST['Slide']['checklist'] as $slide_id) {

									$this -> Slide -> delete($slide_id);

								}

								

								$message = __('Selected slides have been removed', $this -> plugin_name);

								$this -> redirect($this -> url, 'message', $message);

								break;

						}

					} else {

						$message = __('No slides were selected', $this -> plugin_name);

						$this -> redirect($this -> url, "error", $message);

					}

				} else {

					$message = __('No action was specified', $this -> plugin_name);

					$this -> redirect(GS_PLUGIN_URL, "error", $message);

				}

				break;

			case 'order'			:

				$slides = $this -> Slide -> find_all(null, null, array('order', "ASC"));

				$this -> render('slides' . DS . 'order', array('slides' => $slides), true, 'admin');

				break;

			default					:

				$data = $this -> paginate('Slide');				

				$this -> render('slides' . DS . 'index', array('slides' => $data[$this -> Slide -> model], 'paginate' => $data['Paginate']), true, 'admin');

				break;

		}

	}

	

	function admin_settings() {

		switch ($_GET['method']) {

			case 'reset'			:

				global $wpdb;

				$query = "DELETE FROM `" . $wpdb -> prefix . "options` WHERE `option_name` LIKE '" . $this -> pre . "%';";

				

				if ($wpdb -> query($query)) {

					$message = __('All configuration settings have been reset to their defaults', $this -> plugin_name);

					$msg_type = 'message';

					$this -> render_msg($message);	

				} else {

					$message = __('Configuration settings could not be reset', $this -> plugin_name);

					$msg_type = 'error';

					$this -> render_err($message);

				}

				

				$this -> redirect($this -> url, $msg_type, $message);

				break;

			default					:

				if (!empty($_POST)) {

					foreach ($_POST as $pkey => $pval) {					

						$this -> update_option($pkey, $pval);

					}

					

					$message = __('Configuration has been saved', $this -> plugin_name);

					$this -> render_msg($message);

				}	

				break;

		}

				

		$this -> render('settings', false, true, 'admin');

	}

	

}

//initialize a GSlider object

$GSlider = new GSlider();

?>