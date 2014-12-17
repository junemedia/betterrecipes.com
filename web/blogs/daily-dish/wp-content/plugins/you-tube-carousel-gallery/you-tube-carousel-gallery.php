<?php
/**************************************************************************
====================================================
--------------Youtube Carousel Gallery--------------
====================================================
Plugin Name:  You tube Carousel Gallery
Plugin URI:   http://www.designaeon.com/youtube-carousel-gallery.
Description:  Create You tube video Marry go round .Comes with pretty photo Effect combining with jquery image flow.Feches you tube video's images from channel ,or via id or search.
Version:      1.0.1
Author:       Ramandeep Singh
Author URI:   http://www.designaeon.com/
License: GPLv2

**************************************************************************/


class youtubeCarouselGallery{
	protected $pluginPath;  
	protected $pluginUrl;
	private $username;
	private $feedUrl;
	private $feed;
	function __construct(){
		$this->pluginPath = dirname(__FILE__);
		$this->pluginUrl = WP_PLUGIN_URL.'/youtube-carousel-gallery/';

		/*remove_filter( 'the_content', 'wpautop' );
		add_filter( 'the_content', 'wpautop' , 99);
		add_filter( 'the_content', 'shortcode_unautop',100 );*/	
		
		add_shortcode('ytcarousel', array($this, 'build_utube_gallery'));	
				
		//add_filter('the_content', array(&$this,'pre_process_shortcode'), 11);		
		
		
		add_action('wp_head',array($this,'add_headscripts'));	
		add_action('admin_menu',array(&$this,'ycg_add_page'));
		
		add_action('init', array($this,'YTC_addbuttons'));
		add_filter( 'tiny_mce_version', array($this,'my_refresh_mce'));	
	}
	
	function add_headscripts(){
		$path=$this->pluginUrl;
		wp_enqueue_script('jquery');
		//check if prettyPhoto is loaded
		$loadprettyPhoto = get_option('ycg_loadprettyPhoto');
		if($loadprettyPhoto=='yes'){
		echo '<link rel="stylesheet" type="text/css" href="'.$path.'assets/prettyPhoto/css/prettyPhoto.css" media="screen" />';
		wp_enqueue_script('jqueryPrettyPhoto', $path.'assets/prettyPhoto/js/jquery.prettyPhoto.js', array('jquery'),'0.5');
		}
		//check if prettyPhoto is loaded
		$path = WP_PLUGIN_URL.'/youtube-carousel-gallery/';
		$src=$path.'assets/ContentFlow/contentflow.js';
		wp_enqueue_script('jqueryContentFlow',$src,array('jquery'));
		wp_enqueue_script('ytcarousel', $path.'js/ytcarousel.js', array('jquery'),'0.1');
	}
	
	/*--WpAutoP fix---*/
	function pre_process_shortcode($content) {
		$new_content = '';
		$pattern_full = '{(\[ytcarousel\].*?\[/ytcarousel\])}is';
		$pattern_contents = '{\[ytcarousel\](.*?)\[/ytcarousel\]}is';
		$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

		foreach ($pieces as $piece) {
			if (preg_match($pattern_contents, $piece, $matches)) {
				$new_content .= $matches[1];
			} else {
				$new_content .= wptexturize(wpautop($piece));
			}
		}

		return $new_content;
	}
	/*--/WpAutoP fix---*/
	
	function get_tube_image_arr($vid){
		if(is_array($vid)){
			$links=array();
			$imQuality=get_option('ycg_imageQuality','default');
			
			if($imQuality=="mq"){
				foreach($vid as $k=>$id){
				$links[$k]['tube']['img']="http://i.ytimg.com/vi/$id/mqdefault.jpg";
				$links[$k]['tube']['vid']="http://www.youtube.com/watch?v=$id";
				$links[$k]['tube']['title']=$this->get_yt_title($id);
				}
			}
			else if($imQuality=="hq"){
				foreach($vid as $k=>$id){			
				$links[$k]['tube']['img']="http://i.ytimg.com/vi/$id/hqdefault.jpg";
				$links[$k]['tube']['vid']="http://www.youtube.com/watch?v=$id";
				$links[$k]['tube']['title']=$this->get_yt_title($id);
				}
			}
			else{
				foreach($vid as $k=>$id){	
				$no=rand(0,3);$no.='.jpg';
				$links[$k]['tube']['img']="http://img.youtube.com/vi/$id/$no";
				$links[$k]['tube']['vid']="http://www.youtube.com/watch?v=$id";
				$links[$k]['tube']['title']=$this->get_yt_title($id);
				}
			}			
			return $links;
		}
	}
	/*-------------Channel Functions--------*/
	private function getYTid($links) {
        $IDs = array();
		$i=0;
        foreach ($links as $href) {
		/*
            $ytURL = $href;
        //$ytURL = $this->feed->entry->link['href'];

            $ytvIDlen = 11; // This is the length of YouTube's video IDs

            // The ID string starts after "v=", which is usually right after 
            // "youtube.com/watch?" in the URL
            $idStarts = strpos($ytURL, "?v=");

            // In case the "v=" is NOT right after the "?" (not likely, but I like to keep my 
            // bases covered), it will be after an "&":
            if($idStarts === FALSE)
            $idStarts = strpos($ytURL, "&v=");
            // If still FALSE, URL doesn't have a vid ID
            if($idStarts === FALSE)
            die("YouTube video ID not found. Please double-check your URL.");

            // Offset the start location to match the beginning of the ID string
            $idStarts +=3;

            // Get the ID string and return it
            $ytvID = substr($ytURL, $idStarts, $ytvIDlen);    
            $IDs[] = $ytvID;*/
			
			$ytURL=$href['link'];
			$tubeid=parse_url($ytURL);
			$v;
			parse_str($tubeid['query']);
			$IDs[$i]['id']=$v;
			$IDs[$i]['link']=$href['link'];
			$IDs[$i]['title']=$href['title'];
			$i++;
        }
        return $IDs;           
    }

	private function showFullFeed(){ 
    $vidarray = array(); 
			$i=0;
        foreach($this->feed->entry as $video){
			
            $vidarray[$i]['title'] = $video->title;         
            $vidarray[$i]['link'] = $video->link['href'];
			$i++;	
        }
        return $vidarray;
    }   
	
	function get_videos_from_channel($channel_name,$params=null){
		 $this->username=$channel_name;        
        //$this->feedUrl=$url='http://gdata.youtube.com/feeds/api/users/'.$username.'/uploads?orderby=published';
        //$this->feedUrl=$url='http://gdata.youtube.com/feeds/api/videos?author=' . $channel_name.'&max-results=30&start-index=2&q=qc&orderby=published';
		if(is_null($params)){
			$this->feedUrl=$url='http://gdata.youtube.com/feeds/api/videos?author=' . $channel_name;
        }
		else{
			$this->feedUrl=$url='http://gdata.youtube.com/feeds/api/videos?author=' . $channel_name.'&'.$params.'&orderby=published';
		}
		//$this->feedUrl=$url='http://gdata.youtube.com/feeds/api/users/' . $channel_name.'/uploads';
        
		$this->feed=@simplexml_load_file($url);		
		$vids = $this->showFullFeed();		
		$vidIDs = $this->getYTid($vids);
		return $vidIDs;
	}
	function search_videos($params){		
		if(is_null($params)){
			$this->feedUrl=$url='http://gdata.youtube.com/feeds/api/videos';
        }
		else{
			$this->feedUrl=$url='http://gdata.youtube.com/feeds/api/videos?'.$params.'&orderby=published';
		}
		$this->feed=@simplexml_load_file($url);		
		$vids = $this->showFullFeed();		
		$vidIDs = $this->getYTid($vids);
		return $vidIDs;
	}
	/*-------------/Channel Functions--------*/
	
	function get_tube_image($vid){
		$id=$vid;
		$imQuality=get_option('ycg_imageQuality','default');
		
		/*if(empty($imQuality))
			$imQuality="default";*/
			
		if($imQuality=="mq"){			
			return "http://i.ytimg.com/vi/$id/mqdefault.jpg";
		}
		else if($imQuality=="hq"){			
			return "http://i.ytimg.com/vi/$id/hqdefault.jpg";
		}
		else{
			$no=rand(0,3);$no.='.jpg';
			return "http://img.youtube.com/vi/$id/$no";
		}		
	}
	function tube_link($vid){
		$id=$vid;
		return "http://www.youtube.com/watch?v=".$id;
	}
	function get_yt_title($clip_id)
	{
    $entry = @simplexml_load_file('http://gdata.youtube.com/feeds/api/videos/' . $clip_id);
    return ($entry) ? ucwords(strtolower($entry->children('http://search.yahoo.com/mrss/')->group->title)) : false;
	}
	function get_video_title($vid){
		$video_id = $vid;
		$content = file_get_contents("http://youtube.com/get_video_info?video_id=" . $video_id);
		parse_str($content, $ytarr);
		return $ytarr['title'];
	}
	function csv_convert($s){
		$ids=array();
		$ids=explode(",",$s);
		return $ids;
	}
	
	public function build_utube_gallery($atts){
		$opts=$this->ycg_get_options();
		$showscroller = $opts['ycg_showscroller'];
		$backgroundcolor=$opts['ycg_backgroundcolor'];
		$captioncolor = $opts['ycg_captioncolor'];
		extract(shortcode_atts(array(  
			'vid' => '',
			'channel'=>'',
			'max'=>'',
			'start'=>'',
			'query'=>'',	
			'captioncolor'		=>	$captioncolor,
			'background'		=>	$backgroundcolor,
			'showscroller'		=>	$showscroller,	
		    ), $atts));
		//echo $vid;   
		$ytgallery='';
		if(!empty($vid)){
			$ids=$this->csv_convert($vid);
			//print_r($ids);
			$ids=$this->get_tube_image_arr($ids);
			//echo"<pre>";
			//print_r($ids);
			//echo"</pre>";
			//$IDs=$this->get_videos_from_channel('setindia');
			//echo  $this->pluginUrl.'tinymce/editor_plugin.js';
			
			$ytgallery="<div class='yt-carousel'><div class='ContentFlow' style='background-color:".$background.";'><div class='loadIndicator'><div class='indicator'></div></div><div class='flow yt-carousel-gallery'>";
			foreach($ids as $id){
				//$ctitle=$this->get_video_title($id);
				$ctitle=$id['tube']['title'];
				//$ytgallery.='<a class="item" title="'.$ctitle.'" rel="prettyPhoto" href="'.$id['tube']['vid'].'"><img class="content" src="'.$id['tube']['img'].'" alt="YouTube" title="'.$ctitle.'"/><div class="caption">'.$ctitle.'</div></a>';
				$ytgallery.='<div class="item" title="'.$ctitle.'" rel="prettyPhoto" href="'.$id['tube']['vid'].'"><img class="content" src="'.$id['tube']['img'].'" alt="YouTube" title="'.$ctitle.'"/><div class="caption">'.$ctitle.'</div></div>';
			}
			$ytgallery.="</div>";
			$ytgallery.="<div class='globalCaption' style='color:".$captioncolor."'></div>";
			if($showscroller=="yes"){
				$ytgallery.='<div class="scrollbar"><div class="slider"><div class="position"></div></div></div>';
			}
			$ytgallery.="</div></div>";
			//return $ytgallery;
		}
		else if(!empty($channel)){
			$params=null;
			if(!empty($max)){
				$params['max-results']=$max;
			}
			if(!empty($start)){
				$params['start-index']=$start;
			}
			if(!empty($query)){
				$params['q']=$query;
			}
			
			if(!is_null($params))
				$params=http_build_query($params);
			//print_r($params);
			
			$ids=$this->get_videos_from_channel($channel,$params);
			//echo"<pre>";
			//print_r($ids);
			//echo"</pre>";
			//$ids=$this->get_tube_image_arr($ids);
			$ytgallery=$this->carouselMarkUp($ids,$background,$captioncolor,$showscroller);			
			//return $ytgallery;
		}
		else if(!empty($query) & empty($channel)){
			$params=null;
			if(!empty($max)){
				$params['max-results']=$max;
			}
			if(!empty($start)){
				$params['start-index']=$start;
			}
			if(!empty($query)){
				$params['q']=$query;
			}
			
			if(!is_null($params))
				$params=http_build_query($params);
				
				
			$ids=$this->search_videos($params);
			$ytgallery=$this->carouselMarkUp($ids,$background,$captioncolor,$showscroller);		
			//return $ytgallery;
		}		
		
		//$ytgallery=wpautop(trim($ytgallery));	
		
		return $ytgallery;		
	}		
	

	function carouselMarkUP($ids,$background,$captioncolor,$showscroller){
		$ytgallery="<div class='yt-carousel'><div class='ContentFlow' style='background-color:".$background.";'><div class='loadIndicator'><div class='indicator'></div></div><div class='flow yt-carousel-gallery'>";
			foreach($ids as $id){
				//$ctitle=$this->get_video_title($id);
				$ctitle=$id['title'];
				$img=$this->get_tube_image($id['id']);
				//$ytgallery.='<a class="item" title="'.$ctitle.'" rel="prettyPhoto" href="'.$id['link'].'"><img class="content" src="'.$img.'" alt="YouTube" title="'.$ctitle.'"/><div class="caption">'.$ctitle.'</div></a>';
				$ytgallery.='<div class="item" title="'.$ctitle.'" rel="prettyPhoto" href="'.$id['link'].'"><img class="content" src="'.$img.'" alt="YouTube" title="'.$ctitle.'"/><div class="caption">'.$ctitle.'</div></div>';
			}
			$ytgallery.="</div>";
			$ytgallery.="<div class='globalCaption' style='color:".$captioncolor."'></div>";
			if($showscroller=="yes"){
				$ytgallery.='<div class="scrollbar"><div class="slider"><div class="position"></div></div></div>';
			}
			$ytgallery.="</div></div>";
			return $ytgallery;
	}	
	
	//-------------Options Page---------------//
	function ycg_get_options(){
		$ycg_captioncolor = get_option('ycg_captioncolor');
		$ycg_showscroller = get_option('ycg_showscroller');
		$ycg_backgroundcolor=get_option('ycg_backgroundcolor');
		$ycg_loadprettyPhoto=get_option('ycg_loadprettyPhoto');
		$ycg_imageQuality=get_option('ycg_imageQuality');
		if(empty($ycg_captioncolor))
			$ycg_captioncolor = '#ddd';
		if(empty($ycg_backgroundcolor))
			$ycg_backgroundcolor='#ececec';
		if(empty($ycg_showscroller))
			$ycg_showscroller = 'no';
		if(empty($ycg_loadprettyPhoto))
			$ycg_loadprettyPhoto = 'yes';
		if(empty($ycg_imageQuality))
			$ycg_imageQuality='default';
			
		return array(		
		'ycg_captioncolor' => $ycg_captioncolor,
		'ycg_backgroundcolor'=>$ycg_backgroundcolor,
		'ycg_showscroller' => $ycg_showscroller,
		'ycg_loadprettyPhoto'=>$ycg_loadprettyPhoto,
		'ycg_imageQuality'=>$ycg_imageQuality
		);	
	}
	//--------------mce-Button------------//
		
		function YTC_addbuttons() {
		   // Don't bother doing this stuff if the current user lacks permissions
		   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			 return;
		 
		   // Add only in Rich Editor mode
		   if ( get_user_option('rich_editing') == 'true') {
			 add_filter("mce_external_plugins", array($this,"add_YTC_tinymce_plugin"));
			 add_filter('mce_buttons', array($this,'register_YTC_button'));
		   }
		}
		function register_YTC_button($buttons) {
		   array_push($buttons, " | ", "YTC");
		   return $buttons;
		}
		 
		// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
		function add_YTC_tinymce_plugin($plugin_array) {
		   $plugin_array['YTC'] = $this->pluginUrl.'tinymce/editor_plugin.js';
		   return $plugin_array;
		}
		
		//del mce cache
		function my_refresh_mce($ver) {
		  $ver += 3;
		  return $ver;
		}


	
	//--------------/mce-Button------------//
	
	//---------------UI--------------------//
	function ycg_add_page(){
		add_options_page('Youtube Carousel Gallery', 'YouTube Carousel Gallery', 8, 'youtubecarouselgallery', array(&$this,'ycg_options_page'));
	}
	
	//==========callback==============//
	function ycg_options_page(){
	
		if($_POST['action'] == 'update'){
			update_option('ycg_captioncolor', $_POST['ycg_captioncolor'] );	
			update_option('ycg_backgroundcolor',$_POST['ycg_backgroundcolor']);	
			update_option('ycg_showscroller', $_POST['ycg_showscroller'] );
			update_option('ycg_loadprettyPhoto',$_POST['ycg_loadprettyPhoto']);
			update_option('ycg_imageQuality',$_POST['ycg_imageQuality']);
			
			?><div class="updated"><p><strong><?php _e('Options saved.', 'eg_trans_domain' ); ?></strong></p></div><?php
			
			};

			?>
			<!--The Options Page -->
			<div class="wrap">
				<h2>Youtube Carousel Gallery Options</h2>
				<div class="ad">
					<script type="text/javascript"><!--
					google_ad_client = "ca-pub-4609862628205520";
					/* da_leaderboard */
					google_ad_slot = "3030301611";
					google_ad_width = 728;
					google_ad_height = 90;
					//--></script><script type="text/javascript"
					src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
				</div>
				<form method="post">
					<?php wp_nonce_field('youtubecarouselgallery_options'); ?>
					<input type="hidden" name="action" value="update" />
					<table class="form-table">
						<tbody>
							<tr valign="top">
							<th scope="row"><?php _e("Choose Caption Color:", 'eg_trans_domain' ); ?></th>
								<td>
								<input type="text" name="ycg_captioncolor" value="<?php echo get_option('ycg_captioncolor'); ?>" />
								<br/>
								<a href="http://colorpicker.com/" target="new">Find Color Code here =></a>
								</td>
							</tr>
							<tr valign="top">
							<th scope="row"><?php _e("Choose Background Color:", 'eg_trans_domain' ); ?></th>
								<td>
								<input type="text" name="ycg_backgroundcolor" value="<?php echo get_option('ycg_backgroundcolor'); ?>" />
								<br/>
								<a href="http://colorpicker.com/" target="new">Find Color Code here =></a>
								</td>
							</tr>
							<tr valign="top">
							<th scope="row"><?php _e("Image Quality", 'eg_trans_domain' ); ?></th>
								<td>
									<p>
									<?php $imageQuality = get_option('ycg_imageQuality'); ?>
									<select name="ycg_imageQuality">
										<option value="default" <?php if($imageQuality=="default")echo 'selected="selected"';  ?>>Default</option>
										<option value="mq" <?php if($imageQuality=="mq")echo 'selected="selected"';  ?>>MQ</option>
										<option value="hq" <?php if($imageQuality=="hq")echo 'selected="selected"';  ?>>HQ</option>
									</select>
										
										
										<br/>
								Select Image Quality	</p></td>
							</tr>	
							<tr valign="top">
							<th scope="row"><?php _e("Show Scroll Bar?", 'eg_trans_domain' ); ?></th>
								<td>
									<p>
									<?php $showscroller = get_option('ycg_showscroller'); ?>
										<input type="radio" name="ycg_showscroller"value ="no" <?php if($showscroller == "no")echo 'checked'; ?>>No
										<input type="radio" name="ycg_showscroller" value ="yes" <?php if($showscroller == "yes")echo 'checked'; ?>>Yes
										
										<br/>
								The Carousel Scroll bar	</p></td>
							</tr>	
							<tr valign="top">
							<th scope="row"><?php _e("Load Pretty Photo?", 'eg_trans_domain' ); ?></th>
								<td>
									<p>
									<?php $loadprettyPhoto = get_option('ycg_loadprettyPhoto'); ?>
										<input type="radio" name="ycg_loadprettyPhoto"value ="no" <?php if($loadprettyPhoto == "no")echo 'checked'; ?>>No
										<input type="radio" name="ycg_loadprettyPhoto" value ="yes" <?php if($loadprettyPhoto == "yes")echo 'checked'; ?>>Yes
										
										<br/>
								You can Set this option to no if pretty photo already loaded in your theme	</p></td>
							</tr>			
						</tbody>
					</table>
					<p class="submit">
						<input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
					</p>
				</form>	
				<hr/>
				<h2>Youtube Carousel Gallery Shortcode Usage:</h2>	
					<h3>Usage with video id:</h3>
				<p style="font-size:15px;font-style:italic;font-weight:bold;color:blue">[ytcarousel vid='FrN12tVhQPA,2JPo0kdB30c,Vts4J_x_ejk,V-YjBPIzL0M,y_SI2EDM6Lo,COqjmf9GUP0' captioncolor='#000' showscroller='yes']</p>
				<p style='color:red'> in vid param  enter youtube video id's separated by comma's.</p>e.g:
				<p>if url is <span style='color:green;'>http://www.youtube.com/watch?v=2JPo0kdB30c</span> :then <span style='color:red;'>2JPo0kdB30c</span> is your id. </p>	
				<hr/>
				<h3>Usage with Channel Name:</h3>				
				<p style="font-size:15px;font-style:italic;font-weight:bold;color:blue">[ytcarousel channel='indiatimes' captioncolor='#000' background='#ececec' showscroller='yes']</p>
				<p style='color:green'>if url is::http://www.youtube.com/user/indiatimes , Then Channel name here is :-<span style="color:red;"> indiatimes</span></p>
				<h3>Advanced Attribute Options:</h3>
				<p style="font-size:15px;font-style:italic;font-weight:bold;color:blue">[ytcarousel channel='indiatimes' max='30' start='3' query='your search Query' captioncolor='#000' showscroller='yes']</p>
				<h3>Search Only(search You tube videos):</h3>

					<p style="font-size:15px;font-style:italic;font-weight:bold;color:blue">[ytcarousel max="30" query="kkr" showscroller="yes"]</p>
			</div>
			<!--The Options Page -->
			<?php
	}
	
}



$WPugall=new youtubeCarouselGallery();
