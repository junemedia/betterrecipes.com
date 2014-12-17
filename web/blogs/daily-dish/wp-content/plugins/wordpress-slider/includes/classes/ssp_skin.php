<?php

class SSP_SKIN {

	static $active_skin;
	static $slider_id;
	static $slider_shortcode_atts;
	static $slider_settings;

	function setup_slider( $slider_id, $settings ) {

		self::set_active_skin( get_post_meta( $slider_id, 'skin', true ) );

		self::$slider_id = $slider_id;

		self::$slider_shortcode_atts = $settings;

		self::$slider_settings = muneeb_ssp_slider_options( $slider_id );

	}


	function get_skin_path() {

		$skin = self::get_active_skin();

		$default_skin  = 'ssp_skins' . DIRECTORY_SEPARATOR . 'default' .
			DIRECTORY_SEPARATOR;

		$default_skin_html  = 'ssp_skins' . DIRECTORY_SEPARATOR . 'default_html' .
			DIRECTORY_SEPARATOR;

		if ( $skin == 'default' || ! self::validate_skin() )
			return muneeb_ssp_view_path( $default_skin, false );

		if ( $skin == 'default_html' )
			return muneeb_ssp_view_path( $default_skin_html, false );

		return $skin;

	}

	function validate_skin( $skin = NULL ) {

		if ( ! $skin )
			$skin = self::get_active_skin();

		if ( self::is_default_skin( $skin ) )
			return TRUE;

		if ( ! file_exists( $skin . 'slider.php' ) )
			return FALSE;

		return TRUE;

	}

	public static function get_active_skin() {

		return self::$active_skin;

	}

	function set_active_skin( $skin_path ) {

		if ( self::is_default_skin( $skin_path ) ) {

			self::$active_skin = $skin_path;

			return;

		}

		if ( mb_substr( $skin_path, -1 ) !== DIRECTORY_SEPARATOR )
			$skin_path .= DIRECTORY_SEPARATOR;

		self::$active_skin = $skin_path;

	}

	public static function render_slider() {

		$slider_id = self::$slider_id;

		$slides = muneeb_ssp_get_slides( $slider_id );

		$shortcode_atts = self::$slider_shortcode_atts;

		$slider_settings = self::$slider_settings;

		/**
		 * When ID attribute is missing from slider shortcode or slider does
		 * not exist use default slider options to prevent javascript errors in some skins
		 * */
		if ( ! $slider_settings || ! $slider_id ) {

			$slider_settings = SSP_SLIDER_POST_TYPE::default_options();

			$slider_id = mt_rand() % 10000;

		}

		/**
		 * If the shortcode "slider_src" attribute is "gallery" get all
		 * the images attached to that post
		 * If the slider shortcode or gallery shortcode has "ids" attribute then
		 * get attachments or gallery images from those "ids"
		 * The "ids" attribute should only contain comma separated integer values
		 * */
		if ( $shortcode_atts['slides_src'] == 'gallery' )
			if ( ! $shortcode_atts['ids'] )
				$slides = muneeb_ssp_get_gallery_images( $shortcode_atts['post_id'] );
			else
				$slides = muneeb_ssp_get_gallery_images( $shortcode_atts['post_id'], explode( ',', $shortcode_atts['ids'] ) );

			$slides = apply_filters( 'ssp_slides', $slides, $slider_id,
				$shortcode_atts );

		if ( ! $slides || empty( $slides ) )
			$slides = array();

		$skins = apply_filters( 'ssp_skins_array', array() );

		if ( isset( $shortcode_atts['skin'] ) ):

			foreach ( $skins as $skin ) {

				if ( $skin['name'] == $shortcode_atts['skin'] )
					self::set_active_skin( $skin['path'] );

			}

		endif;

		include self::get_skin_path() . 'slider.php';

	}

	function is_default_skin( $skin ) {

		$default_skins = array( 'default', 'default_html' );

		if ( in_array( $skin , $default_skins ) )
			return TRUE;

		return FALSE;

	}
	
}

?>