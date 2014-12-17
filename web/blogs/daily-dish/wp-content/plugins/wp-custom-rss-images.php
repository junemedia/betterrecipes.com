<?php
/*
Plugin Name: WP Custom RSS Images
Plugin URI: http://resolute.com
Description: Add feature images to your blog rss with a custom-field override. Based on WP RSS Images plugin by Alain Gonzalez @ http://web-argument.com/
Version: 0.9
Author: Benjamin Sanders
Author URI: http://resolute.com
*/

function get_http_response_code($theURL) {
    $headers = get_headers($theURL);
    return substr($headers[0], 9, 3);
}

function get_the_image_scan() 
{

	/* Search the post's content for the <img /> tag and get its URL. */
	preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', get_post_field( 'post_content', $post->ID), $matches );

	/* If there is a match for the image, return its URL. */
	if ( isset( $matches ) && !empty( $matches[1][0] ) )
		return array( 'src' => $matches[1][0] );

	return false;
}



function myErrorHandler($errno, $errstr, $errfile, $errline)
{
/*
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }

    switch ($errno) {
    case E_USER_ERROR:
        echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
        echo "  Fatal error on line $errline in file $errfile";
        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        echo "Aborting...<br />\n";
        exit(1);
        break;

    case E_USER_WARNING:
        echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
        break;

    case E_USER_NOTICE:
        echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
        break;

    default:
        echo "Unknown error type: [$errno] $errstr<br />\n";
        break;
    }
//*/
    /* Don't execute PHP internal error handler */
    return true;
}

// set to the user defined error handler to surpress warnings in the feed for bad image locations. Comment out the following line to allow normal error handling. 
$old_error_handler = set_error_handler("myErrorHandler");


function wp_rss_img_get_options($default = false){
	$rss_img_default_op = array(
										"size"=>"thumbnail",
										"rss"=>0,
										"rss2"=>1,
										"media"=>0,
										"enclosure"=>1,
										"version"=>"1.1"
	);
	
	if ($default) {
	update_option('wp_rss_img_op', $rss_img_default_op);
	return $rss_img_default_op;
	}
	
	$options = get_option('wp_rss_img_op');
	if (isset($options)){
	    if (isset($options['version'])) {	
			$chk_version = version_compare("1.1",$options['version']);
			if ($chk_version == 0) 	return $options;
			else if ($chk_version > 0) $options = $rss_img_default_op;
        } else {
		$options = $rss_img_default_op;
		}
	}	
	update_option('wp_rss_img_op', $options);
	return $options;
}

add_action('admin_menu', 'wp_rss_img_menu');
add_action("do_feed_rss","wp_rss_img_do_feed",5,1);
add_action("do_feed_rss2","wp_rss_img_do_feed",5,1); 

function wp_rss_img_do_feed($for_comments){
	if(!$for_comments) {
		$options = wp_rss_img_get_options();
		if($options['media']) add_action('rss2_ns', 'wp_rss_img_adding_yahoo_media_tag');
		if ($options['rss'])  add_action('rss_item', 'wp_rss_img_include');
		if ($options['rss2'])  add_action('rss2_item', 'wp_rss_img_include');
	}
}

function wp_rss_img_include (){
	global $post,$post_meta_cache, $wp_query;	//ben added

//  $pass_keys - Array of allowed custom keys. Modify to your needs.
	$pass_keys = array('rss_image');


	$options = wp_rss_img_get_options();
	$media = $options['media'];
	$enclosure = $options['enclosure'];
	$image_size = $options['size'];

	$customtext = '';
	if( is_feed() ) 
	{
		if( $post_meta_cache[$wp_query->post->ID] )
			$post_meta_cache = $post_meta_cache[$wp_query->post->ID];
		else
			$post_meta_cache = get_post_custom($wp_query->post->ID);

		if( $post_meta_cache ) {
			foreach( get_post_custom_keys() as $key ) {
				if( in_array($key, $pass_keys) ) {
					foreach( get_post_custom_values($key) as $value )
						$customtext .= $value;
				}
			}
		}
	}
	if ($customtext)
		$image_url = $customtext;
	else
		$image_url = wp_rss_img_url($image_size);
	
	if (!empty($image_url) && ($enclosure || $media)) {
	    
		$uploads = wp_upload_dir();
		$url = parse_url($image_url);
		$path = $uploads['basedir'] . preg_replace( '/.*uploads(.*)/', '${1}', $url['path'] );
		
		if ( file_exists( $path ) )
		{
		  $filesize = filesize( $path );
		  $url = $path;
		  
		} else {		
			$ary_header = get_headers($image_url, 1);					   
			$filesize = $ary_header['Content-Length'];	
			$url = $image_url;				
		}
		$statuscode = get_http_response_code($image_url);
		if($enclosure && $statuscode && $statuscode != "404") 
		{
			$image_url = str_replace("my.wordpress.blog","blogs.mydevstaging.com", $image_url);
			echo '<enclosure url="' . $image_url . '" length="' . $filesize . '" type="image/jpg" />';				
		}
		if($media && $statuscode && $statuscode != "404"){
				list($width, $height, $type, $attr) = getimagesize($url);
				echo '<media:content url="'.$image_url.'" width="'.$width.'" height="'.$height.'" medium="image" type="'.image_type_to_mime_type($type).'" />';
		}
	
	}
	
}

function wp_rss_img_adding_yahoo_media_tag(){

	echo 'xmlns:media="http://search.yahoo.com/mrss/"';

}

function wp_rss_img_url($size = 'medium') {	
	global $post;
	if( function_exists ('has_post_thumbnail') && has_post_thumbnail($post->ID)) {
	    $thumbnail_id = get_post_thumbnail_id( $post->ID );
		if(!empty($thumbnail_id))
		$img = wp_get_attachment_image_src( $thumbnail_id, $size );	
	} else {
		$attachments = get_children( array(
											'post_parent' => $post->ID, 
											'post_type' => 'attachment', 
											'post_mime_type' => 'image',
											'orderby' => 'menu_order', 
											'order' => 'ASC', 
											'numberposts' => 1) );
		if($attachments == true) {
			foreach($attachments as $id => $attachment) :
				$img = wp_get_attachment_image_src($id, $size);			
			endforeach;					
		}
	
	}
	if (isset($img)) 
		return $img[0];
	else
	{
		$img = get_the_image_scan();
		return $img['src'];

//		echo "BEN:".
//		print_r($img);
	}
}


function wp_rss_img_menu() {
    add_options_page('WP Custom RSS Images', 'WP Custom RSS Images', 'administrator', 'wp-custom-rss-image', 'wp_custom_rss_image_setting');	 
}



function wp_custom_rss_image_setting() {
	
	$options = wp_rss_img_get_options();
	     
    if(isset($_POST['Submit'])){
		$newoptions = array();			
		$newoptions['media'] = isset ($_POST['media'])? $_POST['media']: 0;
		$newoptions['enclosure'] = isset ($_POST['enclosure'])? $_POST['enclosure']: 0;
		$newoptions['rss'] = isset ($_POST['rss'])? $_POST['rss']: 0;
		$newoptions['rss2'] = isset ($_POST['rss2'])? $_POST['rss2']: 0;
		$newoptions['size'] = isset ($_POST['size'])? $_POST['size']: $options['size'];
		$newoptions['version'] = $options['version'];
	
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('wp_rss_img_op', $options);		
?>
         <div class="updated"><p><strong><?php _e('Options saved.', 'mt_trans_domain' ); ?></strong></p></div>         
<?php  }  ?>
<?php  }  

	$media = $options['media'];
	$enclosure = $options['enclosure'];
	$rss = $options['rss'];	
	$rss2 = $options['rss2'];	
	$image_size = $options['size'];
	$version = $options['version'];
	
?>

<div class="wrap">   

<form method="post" name="options" target="_self">

<h2><?php _e("WP Custom RSS Images Setting") ?></h2>
<h3><?php _e("Select the size of the images") ?></h3>
<p><?php _e("The plugin uses the Posts feature images or the first image added to the post gallery. You can change the dimension of this sizes under Settings/ Media.") ?></p>
<table width="100%" cellpadding="10" class="form-table">

  <tr valign="top">
  	<td width="200" align="right">
  	  <input type="radio" name="size" id="radio" value="thumbnail" <?php if ($image_size == 'thumbnail') echo "checked=\"checked\"";?>/>
  	</td>
  	<td align="left" scope="row"><?php _e("Thumbnail") ?></td>
  </tr>
  <tr valign="top">
  	<td width="200" align="right">
	 <input name="size" type="radio" id="radio" value="medium" <?php if ($image_size == 'medium') echo "checked=\"checked\"";?> />
     </td> 
  	<td align="left" scope="row"><?php _e("Medium Size") ?></td>
  </tr>
  <tr valign="top">
  	<td width="200" align="right">
	 <input type="radio" name="size" id="radio" value="full" <?php if ($image_size == 'full') echo "checked=\"checked\"";?>/>
     </td> 
  	<td align="left" scope="row"><?php _e("Full Size") ?></td>
  </tr>
</table>

<h3> <?php _e("Apply to: ") ?></h3>
<table width="100%" cellpadding="10" class="form-table">  
  <tr valign="top">
  	<td width="200" align="right"><input name="rss" type="checkbox" id="rss" value="1" 
	<?php if ($rss) echo "checked" ?> /></td>
  	<td align="left" scope="row"><?php _e("RSS") ?>   <a href="<?php echo get_bloginfo('rss_url'); ?> " title="<?php bloginfo('name'); ?> - rss" target="_blank"><?php echo get_bloginfo('rss_url'); ?> </a> </td>
  </tr>
  <tr valign="top">
  	<td width="200" align="right"><input name="rss2" type="checkbox" id="rss2" value="1" 
	<?php if ($rss2)  echo "checked" ?> /></td>
  	<td align="left" scope="row"><?php _e("RSS 2") ?>    <a href="<?php echo get_bloginfo('rss2_url'); ?> " title="<?php bloginfo('name'); ?> - rss2" target="_blank"><?php echo get_bloginfo('rss2_url'); ?> </a> </td>
  </tr>    
</table>

<h3> <?php _e("Include: ") ?></h3>
<table width="100%" cellpadding="10" class="form-table">  
  <tr valign="top">
  	<td width="200" align="right"><input name="enclosure" type="checkbox" value="1" 
	<?php if ($enclosure) echo "checked" ?> /></td>
  	<td align="left" scope="row"><?php _e("Enclosure Tag") ?></td>
  </tr>
  <tr valign="top">
  	<td width="200" align="right"><input name="media" type="checkbox" value="1" 
	<?php if ($media)  echo "checked" ?> /></td>
  	<td align="left" scope="row"><?php _e("Media Tag") ?></td>
  </tr>    
</table>

<p class="submit">
<input type="submit" name="Submit" value="<?php _e("Update") ?>" />
</p>

</form>
</div>

<?php }  ?>
