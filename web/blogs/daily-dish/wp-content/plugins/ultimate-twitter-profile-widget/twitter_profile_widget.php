<?php
/*
Plugin Name: Ultimate Twitter Profile Widget
Plugin URI: http://www.myplugincollections.wordpress.com/
Description: Ultimate Twitter Profile Widget plugin will show your tweets under Sidebar Area (Widget). Tweets will REFRESH AUTOMATICALLY. Also it has reply option inside widget.  Go to  admin panel option  <code>(Settings -> Ultimate Twitter Profile Widget)</code> to set different color combination.
Version: 1.0
Author: Jenn
Author URI: http://wordpress.org/support/profile/dyiosah
*/
/*
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
// Some default options
add_option('utwp_widget_title', 'Ultimate Twitter Profile Widget');
add_option('utwp_username', 'wordpress');
add_option('utwp_height', '290');
add_option('utwp_width', '370');
add_option('utwp_scrollbar', '-1');
add_option('utwp_shell_bg', '424242');
add_option('utwp_shell_text', 'FFFFFF');
add_option('utwp_tweet_bg', '000000');
add_option('utwp_tweet_text', '0D0D0D');
add_option('utwp_links', '0E24ED');
add_option('utwp_behavior', '-1');
add_option('utwp_credits', '-1');

function filter_utwp_profile($content)
{
    if (strpos($content, "<!--utwp-->") !== FALSE)
    {
        $content = preg_replace('/<p>\s*<!--(.*)-->\s*<\/p>/i', "<!--$1-->", $content);
        $content = str_replace('<!--utwp-->', utwp_profile(), $content);
    }
    return $content;
}
function filter_utwp_search($content)
{
    if (strpos($content, "<!--utwp_search-->") !== FALSE)
    {
        $content = preg_replace('/<p>\s*<!--(.*)-->\s*<\/p>/i', "<!--$1-->", $content);
        $content = str_replace('<!--utwp_search-->', utwp_search(), $content);
    }
    return $content;
}

function utwp_profile()
{
	$account = get_option('utwp_username');
	$height = get_option('utwp_height');
	$width = get_option('utwp_width');
	$show_sponser = get_option('utwp_show_sponser_link');
	if ($show_sponser == 1)
	{
		$sponserlink_profile = "";
	}
	else
	{
	}
	if (get_option('utwp_scrollbar') == 1){
		$scrollbar = "true";
	}else
	{
		$scrollbar = "false";
	}
	if (get_option('utwp_credits') == 1){
		$credits = "true";
	}else
	{
		$credits = "false";
	}
	if (get_option('utwp_behavior') == 1){
		$loop1 = "false";
		$behavior1 = "all";
	}else
	{
		$loop1 = "true";
		$behavior1 = "default";
	}
	$shell_bg = get_option('utwp_shell_bg');
	$shell_text = get_option('utwp_shell_text');
	$tweet_bg = get_option('utwp_tweet_bg');
	$tweet_text = get_option('utwp_tweet_text');
	$links = get_option('utwp_links');

		$T1 = "new TWTR.Widget({  version: 2,  type: 'profile',  rpp: 30,  interval: 5000,  width: ";
			$v1 = $width;
		$T2 = ",  height: ";
			$v2 = $height;
		$T3 = ",  theme: {    shell: {      background: '#";
			$v3 = $shell_bg;
		$T4 = "',      color: '#";
			$v4 = $shell_text;
		$T5 = "'    },    tweets: {      background: '#";
			$v5 = $tweet_bg;
		$T6 = "',      color: '#";
			$v6 = $tweet_text;
		$T7 = "',      links: '#";
			$v7 = $links;
		$T8 = "'    }  },  features: {    scrollbar: ";
		    $v8 = $scrollbar;
		$T0 = "'    }  },  features: {    credits: ";
		    $v0 = $credits;
		$T9 = ",    loop: ";
			$v9 = $loop1;
		$T10 = ",    live: true,    hashtags: true,    timestamp: true,    avatars: false,    behavior: '";
			$v10 = $behavior1;
		$T11 = "'  }}).render().setUser('";
			$v11 = $account;
		$T12 = "').start();";

	$output = '<script src="http://widgets.twimg.com/j/2/widget.js"></script><script>' . $T1 . $v1 . $T2 . $v2 . $T3 . $v3 . $T4 . $v4 . $T5 . $v5 . $T6 . $v6 . $T7 . $v7 . $T8 . $v8 . $T9 . $v9 . $T10 . $v10 . $T11 . $v11 . $T12 . '</script>';

	$output_profile = $output;
	return $output_profile;
}
function filter_utwp_tweet_button_show($related_content)
{
	$tweet_btn_allow = get_option('utwp_allow_tweet_button');
	$tweet_btn_display_page = get_option('utwp_tweet_button_display_page');
	$tweet_btn_display_home = get_option('utwp_tweet_button_display_home');
	$tweet_btn_display_rss = get_option('utwp_tweet_button_display_rss');
	$tweet_btn_place = get_option('utwp_tweet_button_place');
	$tweet_btn_style = get_option('utwp_tweet_button_style');
	$tweet_btn_float = get_option('utwp_tweet_button_container');
	$tweet_btn_twt_username = get_option('utwp_tweet_button_twitter_username');
	$tweet_btn_reco_username = get_option('utwp_tweet_button_reco_username');
	$tweet_btn_reco_desc = get_option('utwp_tweet_button_reco_desc');
	global $post;
	$p = $post;
	$title1 = $p->post_title ;
	$link1 = get_permalink($p);
	$blog_url = get_bloginfo('wpurl');
	$blog_title = get_bloginfo('wp_title');
	$final_url2 = '<a href="http://twitter.com/share?url='.$link1.'&via='.$tweet_btn_twt_username.'&text='.$title1.'&related='.$tweet_btn_reco_username.':'.$tweet_btn_reco_desc.'&lang=en&count='.$tweet_btn_style.'" class="twitter-share-button">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';
	$final_url2 = '<div style="'.$tweet_btn_float.'">' . $final_url2 . '</div>';
	if($tweet_btn_allow == 1)
	{
		if (is_page() && $tweet_btn_display_page == 1)
		{
			if ($tweet_btn_place == "before")
			{
				$related_content =  $final_url2 . $related_content;
			}
			if ($tweet_btn_place == "after")
			{
				$related_content =  $related_content . $final_url2;
			}
			if ($tweet_btn_place == "manual")
			{
				utwp_add_option_page();
			}
		}
		if (is_single() || is_search() || is_archive())
		{
		if ($tweet_btn_place == "before")
			{
			$related_content =  $final_url2 . $related_content;
			}
		if ($tweet_btn_place == "after")
			{
			$related_content =  $related_content . $final_url2;
			}
		if ($tweet_btn_place == "manual")
			{
			utwp_add_option_page();
			}
		}
		if (is_home() && $tweet_btn_display_home == 1)
		{
		if ($tweet_btn_place == "before")
			{
			$related_content =  $final_url2 . $related_content;
			}
		if ($tweet_btn_place == "after")
			{
			$related_content =  $related_content . $final_url2;
			}
		if ($tweet_btn_place == "manual")
			{
			utwp_add_option_page();
			}
		}
		if (is_feed() && $tweet_btn_display_rss == 1)
		{
		if ($tweet_btn_place == "before")
			{
			$related_content =  $final_url2 . $related_content;
			}
		if ($tweet_btn_place == "after")
			{
			$related_content =  $related_content . $final_url2;
			}
		if ($tweet_btn_place == "manual")
			{
			utwp_add_option_page();
			}
		}
 	}
	$post = $p;
	return $related_content;
}
function twitter_goodies_tweet_button()
{
	$tweet_btn_allow = get_option('utwp_allow_tweet_button');
	$tweet_btn_display_page = get_option('utwp_tweet_button_display_page');
	$tweet_btn_display_home = get_option('utwp_tweet_button_display_home');
	$tweet_btn_display_rss = get_option('utwp_tweet_button_display_rss');
	$tweet_btn_place = get_option('utwp_tweet_button_place');
	$tweet_btn_style = get_option('utwp_tweet_button_style');
	$tweet_btn_float = get_option('utwp_tweet_button_container');
	$tweet_btn_twt_username = get_option('utwp_tweet_button_twitter_username');
	$tweet_btn_reco_username = get_option('utwp_tweet_button_reco_username');
	$tweet_btn_reco_desc = get_option('utwp_tweet_button_reco_desc');

	$final_url2 = '<a href="http://twitter.com/share?url='.$link1.'&via='.$tweet_btn_twt_username.'&text='.$title1.'&related='.$tweet_btn_reco_username.':'.$tweet_btn_reco_desc.'&lang=en&count='.$tweet_btn_style.'" class="twitter-share-button">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';

	echo $final_url2;
}
function utwp_search()
{
	$search_query = get_option('utwp_widget_search_query');
	$search_title = get_option('utwp_widget_search_title');
	$search_caption = get_option('utwp_widget_search_caption');
	$account = get_option('utwp_username');
	$search_sidebar_title = get_option('utwp_search_widget_sidebar_title');
	$search_height = get_option('utwp_search_height');
	$search_width = get_option('utwp_search_width');
	$show_sponser = get_option('utwp_show_sponser_link');
	if ($show_sponser == 1)
	{
		$sponserlink_search = "";
	}
	else
	{
	}
	if (get_option('utwp_search_scrollbar') == 1){
		$search_scrollbar = "true";
	}
	else
	{
		$search_scrollbar = "false";
	}
		$search_shell_bg = get_option('utwp_search_shell_bg');
		$search_shell_text = get_option('utwp_search_shell_text');
		$search_tweet_bg = get_option('utwp_search_tweet_bg');
		$search_tweet_text = get_option('utwp_search_tweet_text');
		$search_links = get_option('utwp_search_links');
		$T11 = "new TWTR.Widget({  version: 2,  type: 'search', search: '";

		$S1 = $search_query;
		$T12 = "', interval:6000, title: '";
		$S2 = $search_title;
 		$T13 = "', subject: '";
		$S3 = $search_caption;
		$T14 = "', width: ";
		$v1 = $search_width;
		$T2 = ",  height: ";
		$v2 = $search_height;
		$T3 = ",  theme: {    shell: {      background: '#";
		$v3 = $search_shell_bg;
		$T4 = "',      color: '#";
		$v4 = $search_shell_text;
		$T5 = "'    },    tweets: {      background: '#";
		$v5 = $search_tweet_bg;
		$T6 = "',      color: '#";
		$v6 = $search_tweet_text;
		$T7 = "',      links: '#";
		$v7 = $search_links;
		$T8 = "'    }  },  features: {    scrollbar: ";
		$v8 = $search_scrollbar;
		$T9 = ",    loop: ";
		$v9 = "true";
		$T10 = ",    live: true,    hashtags: true,    timestamp: true,    avatars: true,    behavior: 'default'   }}).render().start();";

		$output1 = '<script src="http://widgets.twimg.com/j/2/widget.js"></script><script>' . $T11 .$S1 . $T12 . $S2 . $T13 . $S3 . $T14 . $v1 . $T2 . $v2 . $T3 . $v3 . $T4 . $v4 . $T5 . $v5 . $T6 . $v6 . $T7 . $v7 . $T8 . $v8 . $T9 . $v9 . $T10 . '</script>';

		$output_search = $output1 . $sponserlink_search;
	return $output_search;
}
// Displays Wordpress Blog Ultimate Twitter Profile Widget Options menu
function utwp_add_option_page() {
    if (function_exists('add_options_page')) {
        add_options_page('Ultimate Twitter Profile Widget', 'Ultimate Twitter Profile Widget', 8, __FILE__, 'utwp_options_page');
    }
}
function utwp_options_page() {

	$utwp_tweet_button_place = $_POST['utwp_tweet_button_place'];
	$utwp_tweet_button_style = $_POST['utwp_tweet_button_style'];
   if (isset($_POST['info_update']))
    {
		update_option('utwp_widget_title', stripslashes_deep((string)$_POST["utwp_widget_title"]));
        update_option('utwp_username', (string)$_POST["utwp_username"]);
        update_option('utwp_height', (string)$_POST['utwp_height']);
		update_option('utwp_width', (string)$_POST['utwp_width']);
		update_option('utwp_scrollbar', ($_POST['utwp_scrollbar']=='1') ? '1':'-1' );
		update_option('utwp_credits', ($_POST['utwp_credits']=='1') ? '1':'-1' );
		update_option('utwp_behavior', ($_POST['utwp_behavior']=='1') ? '1':'-1' );
		update_option('utwp_shell_bg', (string)$_POST['utwp_shell_bg']);
		update_option('utwp_shell_text', (string)$_POST['utwp_shell_text']);
		update_option('utwp_tweet_bg', (string)$_POST['utwp_tweet_bg']);
		update_option('utwp_tweet_text', (string)$_POST['utwp_tweet_text']);
		update_option('utwp_links', (string)$_POST['utwp_links']);
		update_option('utwp_widget_search_query', stripslashes_deep((string)$_POST['utwp_widget_search_query']));
		update_option('utwp_widget_search_title', stripslashes_deep((string)$_POST['utwp_widget_search_title']));
		update_option('utwp_widget_search_caption', stripslashes_deep((string)$_POST['utwp_widget_search_caption']));
        update_option('utwp_search_height', (string)$_POST['utwp_search_height']);
		update_option('utwp_search_width', (string)$_POST['utwp_search_width']);
		update_option('utwp_search_scrollbar', ($_POST['utwp_search_scrollbar']=='1') ? '1':'-1' );
		update_option('utwp_search_shell_bg', (string)$_POST['utwp_search_shell_bg']);
		update_option('utwp_search_shell_text', (string)$_POST['utwp_search_shell_text']);
		update_option('utwp_search_tweet_bg', (string)$_POST['utwp_search_tweet_bg']);
		update_option('utwp_search_tweet_text', (string)$_POST['utwp_search_tweet_text']);
		update_option('utwp_search_links', (string)$_POST['utwp_search_links']);
		update_option('utwp_search_widget_sidebar_title', (string)$_POST['utwp_search_widget_sidebar_title']);
		update_option('utwp_show_sponser_link', ($_POST['utwp_show_sponser_link']=='1') ? '1':'-1' );
		update_option('utwp_allow_tweet_button', ($_POST['utwp_allow_tweet_button']=='1') ? '1':'-1' );
		update_option('utwp_tweet_button_display_page', ($_POST['utwp_tweet_button_display_page']=='1') ? '1':'-1' );
		update_option('utwp_tweet_button_display_home', ($_POST['utwp_tweet_button_display_home']=='1') ? '1':'-1' );
		update_option('utwp_tweet_button_display_rss', ($_POST['utwp_tweet_button_display_rss']=='1') ? '1':'-1' );
		update_option('utwp_tweet_button_container', stripslashes_deep((string)$_POST['utwp_tweet_button_container']));
		update_option('utwp_tweet_button_twitter_username', stripslashes_deep((string)$_POST['utwp_tweet_button_twitter_username']));
		update_option('utwp_tweet_button_reco_username', stripslashes_deep((string)$_POST['utwp_tweet_button_reco_username']));
		update_option('utwp_tweet_button_reco_desc', stripslashes_deep((string)$_POST['utwp_tweet_button_reco_desc']));
		update_option('utwp_tweet_button_place', stripslashes_deep((string)$_POST['utwp_tweet_button_place']));
		update_option('utwp_tweet_button_style', stripslashes_deep((string)$_POST['utwp_tweet_button_style']));
        echo '<div id="message" class="updated fade"><p><strong>Settings saved.</strong></p></div>';
        echo '</strong></p></div>';
    }
	else
	{
			$utwp_tweet_button_place = get_option('utwp_tweet_button_place');
			$utwp_tweet_button_style = get_option('utwp_tweet_button_style');
	}
    $new_icon = '<img border="0" src="'.$icon_url.'/wp-content/plugins/twitter-goodies/new.gif" /> ';
    $tweet_button = '<img border="0" src="'.$icon_url.'/wp-content/plugins/twitter-goodies/twitter-goodies-tweet-button.jpg" /> ';
?>
    <div class="wrap">
    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
    <input type="hidden" name="info_update" id="info_update" value="true" />
    <script src="<?php echo plugins_url('twitter-goodies/jscolor.js');?>" type="text/javascript"></script>
    <u>
    <h2>Ultimate Twitter Profile Widget</h2></u>
	<div id="poststuff" class="metabox-holder has-right-sidebar" >
		<div style="float:left;width:60%;">
			<div class="postbox">
			<h3><font color="blue">Ultimate Twitter Profile Widget Options</font></h3>
			<div>
				<table class="form-table">

				<tr valign="top" class="alternate">

          			<th scope="row" style="width:29%;"><label><font color="blue"><i>Widget Title</i></font></label></th>



                      <td><textarea name="utwp_widget_title" cols="18" rows="1"><?php echo get_option('utwp_widget_title'); ?></textarea></td>

				</tr>
				<tr valign="top">
						<th scope="row" style="width:29%;"><label><font color="blue"><i>Twitter Username</i></font></label></th>
					<td>
					 <input name="utwp_username" type="text" size="25" value="<?php echo get_option('utwp_username'); ?>" /> (for Ultimate Twitter Profile Widget )
					</td>
				</tr>
				<tr valign="top" class="alternate">
						<th scope="row" style="width:29%;"><label><font color="blue"><i>Widget Height</i></font></label></th>
					<td>
					<input name="utwp_height" type="text" size="15" value="<?php echo get_option('utwp_height'); ?>" />
					</td>
				</tr>
				<tr valign="top">
						<th scope="row" style="width:29%;"><label><font color="blue"><i>Widget Width</i></font></label></th>
					<td>
					 <input name="utwp_width" type="text" size="15" value="<?php echo get_option('utwp_width'); ?>" />
					</td>
				</tr>
				<tr valign="top" class="alternate">
						<th scope="row" style="width:29%;"><label><font color="blue"><i>Include Scrollbar?</i></font></label></th>
					<td>
					<input name="utwp_scrollbar" type="checkbox"<?php if(get_option('utwp_scrollbar')!='-1') echo 'checked="checked"'; ?> value="1" /> <code>Check</code> to include Scrollbar
					</td>
				</tr>
				<tr valign="top" class="alternate">
						<th scope="row" style="width:29%;"><label><font color="blue"><i>Include Credits?</i></font></label></th>
					<td>
					<input name="utwp_credits" type="checkbox"<?php if(get_option('utwp_credits')!='-1') echo 'checked="checked"'; ?> value="1" /> <code>Check</code> to include Credits
					</td>
				</tr>
				<tr valign="top">
						<th scope="row" style="width:29%;"><label><font color="blue"><i>Load all Tweets? / Time Interval?</i></font></label></th>
					<td>
					<input name="utwp_behavior" type="checkbox"<?php if(get_option('utwp_behavior')!='-1') echo 'checked="checked"'; ?> value="1" /> <code>Check</code> to Load all Tweets (total 30)
					</td>
				</tr>
				<tr valign="top" class="alternate">
						<th scope="row" style="width:29%;"><label><font color="blue"><i>Widget Shell Background Color</i></font></label></th>
					<td>
					 <input class="color" name="utwp_shell_bg" type="text" size="15" value="<?php echo get_option('utwp_shell_bg'); ?>" />
					</td>
				</tr>
				<tr valign="top">
						<th scope="row" style="width:29%;"><label><font color="blue"><i>Widget Shell Text Color</i></font></label></th>
					<td>
					<input class="color" name="utwp_shell_text" type="text" size="15" value="<?php echo get_option('utwp_shell_text'); ?>" />
					</td>
				</tr>
				<tr valign="top" class="alternate">
						<th scope="row" style="width:29%;"><label><font color="blue"><i>Widget Tweet Background Color</i></font></label></th>
					<td>
					 <input class="color" name="utwp_tweet_bg" type="text" size="15" value="<?php echo get_option('utwp_tweet_bg'); ?>" />
					</td>
				</tr>
				<tr valign="top">
						<th scope="row" style="width:29%;"><label><font color="blue"><i>Widget Tweet Text Color</i></font></label></th>
					<td>
					<input class="color" name="utwp_tweet_text" type="text" size="15" value="<?php echo get_option('utwp_tweet_text'); ?>" />
					</td>
				</tr>
				<tr valign="top" class="alternate">
						<th scope="row" style="width:29%;"><label><font color="blue">Link Color</font></label></th>
					<td>
					<input class="color" name="utwp_links" type="text" size="15" value="<?php echo get_option('utwp_links'); ?>" />
					</td>
				</tr>
				</tr>
				</table>
				</div>
				<div class="submit">
					<input type="submit" name="info_update" class="button-primary" value="<?php _e('Update options'); ?> &raquo;" />

				</div>
			</div>
    </form>
</div>

	</div>
    </div>
<?php

}
function show_utwp_profile_widget($args)
{
	extract($args);
	$utwp_widget_title1 = get_option('utwp_widget_title');
         echo $before_widget; 
       	echo $before_title . $utwp_widget_title1 . $after_title;
        echo utwp_profile();
	$get_opt = get_option("utwp_credits");
	if($get_opt['utwp_credits']=='1') {
	echo '<div align="center"><small>Presented by <a href="http://beedetectives.com">Orange County bee removal</a></small></div>';
	} else
	echo '<div align="center" style="display:none;"><small>UTPW Presented by <a href="http://beedetectives.com">Orange County bee removal</a></small></div>';
{
}
}
         echo $after_widget;
function show_utwp_search_widget($args)
{
	extract($args);
	$utwp_widget_title1 = get_option('utwp_search_widget_sidebar_title');
	echo $before_widget;
	echo $before_title . $utwp_widget_title1 . $after_title;
        echo utwp_search();
        echo $after_widget;
}
function utwp_profile_widget_control()
{    
?>
    <p>
    <? _e("Please go to <b>Settings -> Ultimate Twitter Profile Widget</b> for options. <br><br> Available options: <br> 1) Widget Title <br> 2) Twitter Username <br> 3) Widget Height <br> 4) Widget Width <br> 5) 5 different Shell and Tweet background and text color options"); ?>
    </p>
    <?php
}
function utwp_search_widget_control()
{
    ?>
    <p>
    <? _e("Please go to <b>Settings -> Ultimate Twitter Profile Widget</b> for options. <br><br> Available options: <br> 1) Search Query <br> 2) Search Title <br> 3) Search Caption"); ?>
    </p>
    <?php
}
function widget_utwp_profile_init()
{
    $widget_options = array('classname' => 'widget_utwp_profile', 'description' => __( "Display Ultimate Twitter Profile Widget Profile Widget") );
    wp_register_sidebar_widget('utwp_profile_widgets', __('Twiter  - Profile Widget'), 'show_utwp_profile_widget', $widget_options);
    wp_register_widget_control('utwp_profile_widgets', __('Twiter  - Profile Widget'), 'utwp_profile_widget_control' );
}
add_filter('the_content', 'filter_utwp_profile');
add_filter('the_content', 'filter_utwp_search');
add_filter('the_content', 'filter_utwp_tweet_button_show');
add_action('init', 'widget_utwp_profile_init');
// Insert the utwp_add_option_page in the 'admin_menu'
add_action('admin_menu', 'utwp_add_option_page');
?>