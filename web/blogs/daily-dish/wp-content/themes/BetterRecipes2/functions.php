<?php
// added to prevent www.betterrecipes.com from showing-up when WP tries to add a trailing slash to a blog entry
remove_filter('template_redirect', 'redirect_canonical');

 if ( function_exists('register_sidebar') )
 register_sidebar();
?>
<?php
function show_first_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];

  if(empty($first_img)){ //Defines a default image
    $first_img = "http://www.betterrecipes.com/blogs/daily-dish/img/logo-betterrecipes.png";
  }
  return $first_img;
}

function remove_anchor($data)
{
    // the code for removing the anchor here

    global $post;
   $pattern ="/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
   $replacement = '<a$1href=$2$3.$4$5 rel="lightbox" title="'.$post->post_title.'"$6>';
   $content = preg_replace($pattern, $replacement, $data);
    return $data;
}

// then use WP's filter/hook system like this:
//add_filter('the_content', 'remove_anchor');

function get_first_image() {
		global $post, $posts;
		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		$first_img = $matches [1] [0];
		
		if(empty($first_img)){ //Defines a default image
			$first_img = "";
		}
		return $first_img;
	}


?>