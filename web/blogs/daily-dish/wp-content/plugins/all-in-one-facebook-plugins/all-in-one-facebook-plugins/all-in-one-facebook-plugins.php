<?php 
/**
 * @package All in one Facebook Plugins for Wordpress
 * @author Shaon
 * @version 1.7
 */
/*
Plugin Name: All in one Facebook Plugins for Wordpress
Plugin URI: http://www.w3xperts.com/all-in-one-facebook-plugins-for-wordpress/
Description: All in one FaceBook Plugins for Wordpress including like button, Recommendations, Activity Feed, Like Box, Facepile, Live Stream, Comments, Login with Faces and will be continued with facebook.
Author: Shaon
Version: 1.7
Author URI: http://www.w3xperts.com/
*/
 
function FaceBookJSAPI(){
     $common_settings = unserialize(get_option('common_settings'));
     $com = $common_settings['api'];
    echo '
        <div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({appId: \'$com\', status: true, cookie: true,
             xfbml: true});
  };
  (function() {
    var e = document.createElement(\'script\'); e.async = true;
    e.src = document.location.protocol +
      \'//connect.facebook.net/en_US/all.js\';
    document.getElementById(\'fb-root\').appendChild(e);
  }());
</script>

    ';
    
}

        
function FB_Like_Button($content){
    $like_opt = unserialize(get_option('like_button'));
    
    if($like_opt['action']=="recommend")
        $fb_like  = '<fb:like action="recommend"></fb:like>';
   else    
        $fb_like = '<fb:like href='.get_permalink().' font='.$like_opt[font].'></fb:like>';
    
   return $content.$fb_like;
}

function FB_Comments($content){
    
}



function FB_Recommendations(){
    $rec_opt = unserialize(get_option('rec_opts'));
    $fb_rec  = '<fb:recommendations site='.get_permalink().'></fb:recommendations>';
    return $content.$fb_rec;
}

function FB_Recommendations_widget(){
    $rec_opt = unserialize(get_option('rec_opts'));
    echo  '<fb:recommendations site='.get_permalink().'></fb:recommendations>';
     
} 

function FB_Live_Stream_widget($content){
   
   echo  '<fb:live-stream event_app_id='.'255955255198'.'></fb:live-stream>'; 
    
}
  
function FB_Login_with_Faces($content){
    
}

function FB_Activity_Feed($content){
  
   $fb_activity = '<fb:activity site='.get_permalink().'></fb:activity> ';
   return $content.$fb_activity;
}

function FB_Facepile($content){
  $facepile = unserialize(get_option('facepile'));
  $fb_facepile = '<fb:facepile></fb:facepile>';
  return $content.$fb_facepile;
  
}

 


function FB_Like_Button_Settings($content){
    if($_POST) {
        update_option("like_button",serialize($_POST['like']));
    }
    $like = unserialize(get_option('like_button'));
    $common_settings = unserialize(get_option('common_settings'));
        
    include("fb_like_settings.php");
     
}

function FB_Comments_Settings($content){
   if($_POST) {
        update_option("common_settings",serialize($_POST['common_settings']));
    }
    $common_settings = unserialize(get_option('common_settings'));
    include("fb_common_settings.php");
}

function FB_Recommendations_Settings(){
    if($_POST) {
        update_option("rec_opts",serialize($_POST['like']));
    }
    $like = unserialize(get_option('rec_opts'));
    include("fb_recommendations_settings.php");
}

function FB_Recommendations_Widget_Settings(){
    echo '<a href="admin.php?page=FB_Recommendations_Settings">Settings</a>';
}

function FB_Live_Stream_Widget_Settings(){
    echo '<a href="admin.php?page=FB_Live_Stream_Settings">Settings</a>';
}
function FB_Login_with_Faces_Settings($content){
    echo "Coming in few hours";
}

function FB_Activity_Feed_Settings($content){
   if($_POST) {
        update_option("activity_feed",serialize($_POST['activity_feed']));
    }
    $activity_feed = unserialize(get_option('activity_feed'));
    
}

function FB_Facepile_Settings($content){
   echo "Coming in few hours"; 
}



///FB_Recomended_Settings


function fbmenu(){
    add_menu_page("FB Plugins","FB Plugins",'administrator','fb-plugin-settings','FB_Like_Button_Settings');        
    add_submenu_page( 'fb-plugin-settings', 'FB Plugins', 'Like Button', 'administrator', 'fb-plugin-settings', 'FB_Like_Button_Settings');        
    add_submenu_page( 'fb-plugin-settings', 'FB Plugins', 'Recommendations', 'administrator', 'FB_Recommendations_Settings', 'FB_Recommendations_Settings');        
    add_submenu_page( 'fb-plugin-settings', 'FB Plugins', 'Login with Faces', 'administrator', 'FB_Login_with_Faces_Settings', 'FB_Login_with_Faces_Settings');        
    add_submenu_page( 'fb-plugin-settings', 'FB Plugins', 'Activity Feed', 'administrator', 'FB_Activity_Feed_Settings', 'FB_Activity_Feed_Settings');        
    add_submenu_page( 'fb-plugin-settings', 'FB Plugins', 'Facepile', 'administrator', 'FB_Facepile_Settings', 'FB_Facepile_Settings');        
    add_submenu_page( 'fb-plugin-settings', 'FB Plugins', 'Live Stream', 'administrator', 'FB_Live_Stream_Settings', 'FB_Live_Stream_Settings'); 
    add_submenu_page( 'fb-plugin-settings', 'FB Plugins', 'Settings', 'administrator', 'FB_Comments_Settings', 'FB_Comments_Settings');       
}

if(is_admin()){
    add_Action("admin_menu","fbmenu");
}

add_action('wp_footer',"FaceBookJSAPI");
add_filter("the_content","FB_Like_Button");


wp_register_sidebar_widget( 'FB_Recommendations_widget', 'FB Recommendations', 'FB_Recommendations_widget' );
register_widget_control ('FB_Recommendations_widget', 'FB_Recommendations_Widget' );

wp_register_sidebar_widget( 'FB_Live_Stream_widget', 'FB Live Stream', 'FB_Live_Stream_widget' );
register_widget_control ('FB_Live_Stream_widget', 'FB_Live_Stream_Widget' );
