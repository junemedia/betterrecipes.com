<?php get_header(); ?>

		
				<div id="maincolumn">
					<div id="maincontentwell">


 <div id="content">
						<?php include('breadcrumb.php'); ?>
  						  <div class="post">
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							
						  <?php include('posthead.php'); ?>

 <?php the_content(__('Read more'));?>	
							<?php /* include('postfoot.php'); */ ?>							
						  <!--<hr class="posttween"/>-->
						  
<?php endwhile; else: ?>
						 
  <p><strong>An Error Occured.</strong></p>  
							
<?php endif; ?>

						  </div><!-- end post -->
						</div><!-- end content -->

					<div class="clearall"> </div>	
					</div><!-- end maincontentwell -->
					

				</div><!-- end maincolumn -->
				
				
<?php get_sidebar('left'); ?> 
<?php get_sidebar('right'); ?>
<?php get_footer(); ?>
