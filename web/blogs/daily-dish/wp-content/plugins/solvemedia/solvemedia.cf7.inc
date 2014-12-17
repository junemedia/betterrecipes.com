<?php

/*
 * Copyright (c) 2012 by Solve Media, Inc.
 * Author: Ilia Fishbein
 * Function: Portion of the WordPress plugin related to Contact Form 7
 *
 * $Id$
 */

if (file_exists($wp_plugin_dir . '/contact-form-7/includes/shortcodes.php'))
    include_once($wp_plugin_dir . '/contact-form-7/includes/shortcodes.php');
if (file_exists($wp_plugin_dir . '/contact-form-7/includes/taggenerator.php'))
    include_once($wp_plugin_dir . '/contact-form-7/includes/taggenerator.php');

// Generate markup for Contact-Form-7
function solvemedia_cf7_get_html($tag) {
    global $adcopy_opt;

    if (class_exists('WPCF7_Shortcode'))
    {
        $tag = new WPCF7_Shortcode ($tag);
        if (empty($tag->name))
            return '';
    }
    else
    {
        if ($tag['type'] != 'solvemedia')
            return;
    }

    $theme = $adcopy_opt['re_theme_cf7'];

    $html  = '<span><span class="wpcf7-form-control-wrap solvemedia"></span>';
    $html .= solvemedia_wp_get_html('', $theme) . '</span>';

    return $html;
}

// Handle 'solvemedia' Contact-Form-7 shortcode
add_action('init','wpcf7_add_shortcode_solvemedia', 5);

function wpcf7_add_shortcode_solvemedia()
{
    global $adcopy_opt;
    if (function_exists('wpcf7_add_shortcode') && $adcopy_opt['re_contact_form_7'])
    {
        wpcf7_add_shortcode('solvemedia', 'solvemedia_cf7_get_html', true);
    }
}

function adcopy_enqueue_scripts() {
    global $WP_type, $adcopy_opt, $wp_plugin_url;

    if (!$adcopy_opt['re_contact_form_7'])
        return;

    wp_enqueue_script( 'puzzle_reload',
        $wp_plugin_url . '/solvemedia/puzzle_reload.js',
        array( 'jquery', 'jquery-form' )
    );
}

// Check response from Contact-Form-7
function check_resp_cf7($result) {
    global $adcopy_opt, $wpcf7_contact_form;
    
    if ($_POST['adcopy_challenge']) {
        if (empty($_POST['adcopy_response'])) {
            $result['valid'] = false;
            $result['reason']['solvemedia'] = $adcopy_opt['error_blank_cf7'];
        }
        else {
            $response = solvemedia_wp_check_answer();

            if (!$response->is_valid) {
                $result['valid'] = false;
                $result['reason']['solvemedia'] = $adcopy_opt['error_incorrect_cf7'];
            }
        }
    }
    
    return $result;
}

add_action( 'init', 'adcopy_enqueue_scripts' );
add_filter( 'wpcf7_validate_solvemedia', 'check_resp_cf7', 10, 2 );

// Add "Solve Media Puzzle" to the tag generator options
if (function_exists('wpcf7_add_tag_generator'))
    add_action( 'admin_init', 'wpcf7_add_tag_generator_solvemedia', 15 );

function wpcf7_add_tag_generator_solvemedia() {
    wpcf7_add_tag_generator( 'solvemedia', __( 'Solve Media Puzzle', 'wpcf7' ),
                             'wpcf7-tg-pane-solvemedia', 'wpcf7_tg_pane_solvemedia' );
}

// Markup to show the generated tag
function wpcf7_tg_pane_solvemedia() {
?>

<div id="wpcf7-tg-pane-solvemedia" class="hidden">
	<form action="">
		<table>
			<tr><td><?php echo esc_html( __( 'Name', 'wpcf7' ) ); ?><br /><input type="text" name="name" class="tg-name oneline" /></td><td></td></tr>
		</table>
		<div class="tg-tag">
            <?php echo esc_html( __( "Copy this code and paste it into the form left.", 'wpcf7' ) ); ?>
            <br />
            <input type="text" name="solvemedia" class="tag" readonly="readonly" onfocus="this.select()" />
        </div>
	</form>
</div>

<?php
}

?>
