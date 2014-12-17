<?php

function muneeb_load_ssp() {

	muneeb_load_ssp_classes();
	muneeb_load_default_slider_skin();

}

function muneeb_load_ssp_classes() {

	muneeb_ssp_include( 'classes/ssp_slider_post_type.php' );
	muneeb_ssp_include( 'classes/ssp_settings.php' );
	muneeb_ssp_include( 'classes/ssp_skin.php' );
	muneeb_ssp_include( 'classes/ssp_frontend_slider.php' );

	new SSP_SLIDER_POST_TYPE( TRUE );
	new SSP_SETTINGS( TRUE );
	new SSP_FRONTEND_SLIDER( TRUE );

}

function muneeb_load_default_slider_skin() {

	$default_skin  = 'ssp_skins' . DIRECTORY_SEPARATOR . 'default' .
		DIRECTORY_SEPARATOR . 'functions.php';

	include muneeb_ssp_view_path( $default_skin, FALSE );

	muneeb_ssp_default_slider_skin_hooks();

}

function muneeb_ssp_loaded() { do_action( 'ssp_loaded' ); }

function muneeb_ssp_include( $file_name, $require = true ) {

	if ( ! $require )
		require SLIDER_PLUGIN_INCLUDE_DIRECTORY . $file_name;

	include SLIDER_PLUGIN_INCLUDE_DIRECTORY . $file_name;

}

function muneeb_ssp_view_path( $view_name, $is_php = true ) {

	if ( strpos( $view_name, '.php' ) === FALSE && $is_php )
		return SLIDER_PLUGIN_VIEW_DIRECTORY . $view_name . '.php';

	return SLIDER_PLUGIN_VIEW_DIRECTORY . $view_name;

}

function muneeb_ssp_get_slides( $slider_id ) {

	$slides = get_post_meta( $slider_id, 'slides', true );

	return apply_filters( 'ssp_get_slider_slides' , $slides, $slider_id );

}

function muneeb_ssp_slider_options( $slider_id ) {

	$options = get_post_meta( $slider_id, 'options', true );

	return apply_filters( 'ssp_get_slider_options' , $options, $slider_id );

}

function muneeb_ssp_get_gallery_images( $post_id, $ids = array() ) {

	$attachments = get_children( array(
			'post_parent' => $post_id,
			'post_status' => 'inherit',
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'order' => 'ASC',
			'orderby' => 'menu_order ID'
		) );

	if ( ! empty( $ids ) && is_array( $ids ) ) {

		$attachments = get_posts( array(
			'post__in' => $ids,
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'orderby' => 'post__in',
			'numberposts' => count( $ids )
		) );

	}

	if ( empty( $attachments ) ) return array();

	$image = array(
		'id' => NULL,
		'url' => NULL,
		'alt' => NULL,
		'link' => NULL,
		'caption' => NULL,
		'sizes' => array(
			'thumbnail' => NULL,
			'medium' => NULL,
			'large' => NULL,
			'full' => NULL
		)
	);

	$slide = array(
		'label' => '',
		'type' => 'image',
		'attachment' => '',
		'image' => '',
		'html' => ''
	);

	$slides = array();

	foreach ( $attachments as $attachment ) {

		$attachment_id = $attachment->ID;

		$slide['label'] = $attachment->post_title;

		$slide['attachment'] = $attachment_id;

		$image['id'] = $slide['attachment'];

		$image['url'] = wp_get_attachment_url( $image['id'] );

		$image['alt'] = get_post_meta( $image['id'],
			'_wp_attachment_image_alt', true );

		$image['link'] = get_post_meta( $image['id'],
			'_wp_attachment_url', true );

		$image['caption'] = get_post_field( 'post_excerpt', $image['id'] );

		$sizes = get_intermediate_image_sizes();
		$sizes[] = 'full';

		foreach ( $sizes as $size ) {
			$img = wp_get_attachment_image_src( $image['id'] , $size );
			$image['sizes'][$size] = $img[0];
		}

		$slide['image'] = $image;

		$slides[] = $slide;

	}

	return $slides;

}

//print out or render the slider
function muneeb_ssp_slider( $slider_id, $shortcode_atts = NULL ) {

	SSP_SKIN::setup_slider( $slider_id, $shortcode_atts );

	SSP_SKIN::render_slider();

}

//get slider active skin
function muneeb_ssp_get_slider_skin( $slider_id ) {

	return get_post_meta( $slider_id, 'skin', true );

}

function muneeb_ssp_slider_fixes() {

	remove_filter( 'the_content', 'wpautop' );

	add_filter( 'the_content', 'wpautop', 10 );

}

?>