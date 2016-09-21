<?php
/**
 * Plugin Name: Ramp Video
 * Plugin URI: http://www.parents.com/blogs/
 * Description: This plugin replaces Ramp video tags with brand-specific Ramp video HTML. Supported brands include BHG, FC, Fitness, LHJ, Parents, Rachael Ray and Recipe.com.
 * Version: 2.0
 * Author: Jeremy Schultz
 * Author URI: http://jeremyschultz.com/
 * License: Meredith Corporation internal use only
 */

$brand_id = array(
	"bhg" => "bhg",
	"fc" => "familycircle",
	"fitness" => "fitnessmagazine",
	"lhj" => "lhj",
	"parents" => "parents",
	"rrmag" => "rachaelraymag",
	"recipe" => "recipe"
);

define("video_embed", "<div class=\"rampVideo\"><a style=\"width: 628px; height: 410px; display: inline-block;\" class=\"mdpVideoPlayer embed\" data-autoload=\"true\" data-videotitle=\"video_data_name\" href=\"video_data_embedUrl\"><div class=\"videoImage\"><span class=\"playvideoLarge\"></span><img src=\"video_data_thumbnailImg\" width=\"100%\" style=\"margin: 1px auto;\" class=\"photo\" /></div></a><script src=\"http://www.bhg.com/bhg/files/partner/ramp/mdp.video.popup.min.js\"></script></div>");

define("video_embed_transcript", "<div class=\"rampVideo\"><a style=\"width: 628px; height: 410px; display: inline-block;\" class=\"mdpVideoPlayer embed\" data-transcript=\"true\" data-autoload=\"true\" data-videotitle=\"video_data_name\" href=\"video_data_embedUrl\"><div class=\"videoImage\"><span class=\"playvideoLarge\"></span><img src=\"video_data_thumbnailImg\" width=\"100%\" style=\"margin: 1px auto;\" class=\"photo\" /></div></a><p>video_data_transcript</p><script src=\"http://www.bhg.com/bhg/files/partner/ramp/mdp.video.popup.min.js\"></script></div>");

define("video_popup", "<div class=\"rampPopup rampVideo\"><div class=\"videoRight\"><div data-videotitle=\"video_data_name\" data-videoid=\"video_data_videoId\" data-videoembedurl=\"video_data_embedUrl?autoplay=true&amp;preload=true&amp;social=true&amp;includecompads=true&amp;videoIDs=video_data_videoId\" class=\"popupVideoPlayer\"> <span class=\"playvideoLarge\"></span> <img width=\"100%\" alt=\"video_data_name\" style=\"margin: 2% auto; display: inline;\" src=\"video_data_thumbnailImg\" class=\"photo lazy\"> </div><a href=\"video_data_url\" class=\"popupVideoPlayer\"> <span class=\"playvideoLarge\"></span> <img width=\"100%\" alt=\"video_data_name\" style=\"margin: 2% auto; display: inline;\" src=\"video_data_thumbnailImg\" class=\"photo lazy\"></a><div class=\"heading3\">video_data_name</div></div></div>");

$html_template = array(
	"bhg" => constant("video_popup"),
	"fc" => constant("video_popup"),
	"fitness" => constant("video_popup"),
	"lhj" => constant("video_popup"),
	"parents" => constant("video_popup"),
	"rrmag" => constant("video_popup"),
	"recipe" => constant("video_popup")
);

function add_support_code() {
	wp_enqueue_style("ramp_css", "/wp-content/plugins/ramp-video/ramp-styles.css");
	wp_enqueue_script("jquery_ui", "http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.24/jquery-ui.min.js");
	wp_enqueue_script("ramp_js", "/wp-content/plugins/ramp-video/ramp-scripts.js");
}

add_action('wp_head', 'add_support_code');

function replace_tags($content) {
	return (preg_replace_callback("/\[(ramp|Ramp)[[:space:]]([0-9]+)(?: )?([a-zA-Z]+)?\]/", 'process_tags', $content));
}

function process_tags($match) {
	global $brand_id, $html_template;
	$ramp_video_id = $match[2];
	if ($match[3]) {
		$ramp_brand_id = strtolower($match[3]);
	} else {
		$ramp_brand_id = $_SERVER["HTTP_HOST"];
		foreach ($brand_id as $value) {
			if (strpos($ramp_brand_id, $value)) {
				$ramp_brand_id = array_search($value, $brand_id);
			} else {
				$ramp_brand_id = "parents";
			}
		}
	}
	$ramp_brand_domain = $brand_id[$ramp_brand_id];
	$video_data_tags = array("video_data_embedUrl", "video_data_name", "video_data_thumbnailImg", "video_data_url", "video_data_videoId", "video_data_transcript");
	$video_data = json_decode(file_get_contents("http://www." . $ramp_brand_domain . ".com/rest/application/v1/video/" . $ramp_video_id . "?site=" . $ramp_brand_id));
	$video_data = $video_data[0];
	$video_data_values = array($video_data->{"embedUrl"}, $video_data->{"name"}, $video_data->{"thumbnailImg"}, $video_data->{"url"}, $video_data->{"videoId"}, $video_data->{"transcript"});
	$output = str_replace($video_data_tags, $video_data_values, $html_template[$ramp_brand_id]);
	return ($output);
}

add_filter('the_content', 'replace_tags');

function admin_page() {
?>

<div class="wrap">
	<style>
.wrap em { color: gray; } .wrap ul { list-style: disc; margin: 10px 15px; }
</style>
	<h2>Jeremy's Ramp Video plugin</h2>
	<p>Just put a Ramp video tag in any content area on the blog and the plugin will do the rest. The syntax:</p>
	<p><strong>[ramp 79902140 bhg]</strong></p>
	<h3>Ramp video tag syntax</h3>
	<ol>
		<li>Tags now allow mixed case. <em>(New to version 2.0)</em></li>
		<li>"ramp" is required.</li>
		<li>The Ramp video ID number is required. You don't need to add quotes or "id=" around the number.</li>
		<li>The brand ID is optional.
			<ul>
				<li>If it exists, the plugin will make its API call to the correct brand and use the video player from that brand's site.</li>
				<li>If it doesn't exist, or if it is not a recognized brand (see list below), the plugin will auto-detect the brand based on the blog URL.</li>
			</ul>
		</li>
	</ol>
	<h3>List of supported Meredith brand IDs</h3>
	<ul>
		<li>bhg <em>(BHG.com)</em></li>
		<li>fc <em>(FamilyCircle.com)</em></li>
		<li>fitness <em>(FitnessMagazine.com)</em></li>
		<li>lhj <em>(LHJ.com)</em></li>
		<li>parents <em>(Parents.com)</em></li>
		<li>rrmag <em>(RachaelRayMag.com</em>)</li>
		<li>recipe <em>(Recipe.com)</em></li>
	</ul>
</div>
<?php
}
function add_admin_page() {
	add_options_page('Ramp Video', 'Ramp Video', 'manage_options', 'ramp-video.php', 'admin_page'); 
}
add_action('admin_menu', 'add_admin_page'); 
?>
