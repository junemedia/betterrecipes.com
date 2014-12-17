<?php
/*
Template Name: Archives
*/
?>
<?php get_header(); ?>

		
				<div id="maincolumn">
					<div id="maincontentwell">

						<div id="content">
						<?php include('breadcrumb.php'); ?>
		 <h2>Archives by Month:</h2>
		 <ul><?php wp_get_archives('type=monthly'); ?></ul>
		</div><!-- end content -->

					<div class="clearall"> </div>	
					</div><!-- end maincontentwell -->
					

				</div><!-- end maincolumn -->
				
				
<?php get_sidebar('left'); ?> 
<?php get_sidebar('right'); ?>
<?php get_footer(); ?>