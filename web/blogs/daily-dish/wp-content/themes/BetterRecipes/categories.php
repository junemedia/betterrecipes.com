<?php
/*
Template Name: Categories
*/
?>
<?php get_header(); ?>

		
				<div id="maincolumn">
					<div id="maincontentwell">

						<div id="content">
						<?php include('breadcrumb.php'); ?>
    <h2>Categories</h2>
    <ul><?php wp_list_categories(); ?></ul>
    
    <h2>Tags</h2>
    <ul><?php the_tags(' ', ',', ''); ?></ul>
  </div>

					<div class="clearall"> </div>	
					</div><!-- end maincontentwell -->
					

				</div><!-- end maincolumn -->
				
				
<?php get_sidebar('left'); ?> 
<?php get_sidebar('right'); ?>
<?php get_footer(); ?>
