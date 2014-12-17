				<div id="leftcolumn">

					<?php /* banner file name = blog_name_wpbnr.jpg */
						$thisblogname = get_bloginfo('name');				
					?>
					
					<?php
						switch ($thisblogname)
						{
						case "The Daily Dish":
							$thisblogbanner = "http://images.meredith.com/betterrecipes/images/blogs/DailyDishHeader.gif";
							break;
						default:
							$thisblogbanner = 'http://dummyimage.com/660x100';
						}
					?>

					<div id="CommunityBlogHeader">
						<a href="<?php echo bloginfo('url'); ?>/">
							<img 	src="<?php echo $thisblogbanner; ?>" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>" />
						</a>
					</div>
				

				<!--// widgets \\-->
						<div class="sidebar">
						  <ul>
							 <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>
							 <?php endif; ?>
						  </ul>
						</div><!-- end sidebar -->
<div class="tags">
							<ul>
							<?php
$tags = get_tags();
foreach ( (array) $tags as $tag ) {
echo '<li><a href="' . get_tag_link ($tag->term_id) . '" rel="tag">' . $tag->name.'</a></li>';
}
?>
						</ul>
						</div>
				<!--\\ widgets //-->
				
			<div class="clearall"> </div>
			</div><!-- end lefttcolumn -->
			






