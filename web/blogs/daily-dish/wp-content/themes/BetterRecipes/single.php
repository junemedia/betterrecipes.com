<?php get_header(); ?>

		
				<div id="maincolumn">
					<div id="maincontentwell">

<div id="content">
						<?php include('breadcrumb.php'); ?>
						<div class="post">
   <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						  <?php include('posthead.php'); ?>
							<?php the_content(__('Read more'));?>
  
    <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
  
							<?php include('postfoot.php'); ?>
  
   <?php comments_template(); ?>
   <?php endwhile; else: ?>

								<h2>There has been an Error</h2>
								<p>There are no posts to display</p>

   <?php endif; ?>
						  </div><!-- end post -->
						</div><!-- end content -->

					<div class="clearall"> </div>	
					</div><!-- end maincontentwell -->
					

				</div><!-- end maincolumn -->
				

<?php get_sidebar('left'); ?> 
<?php get_sidebar('right'); ?>
<?php get_footer(); ?>
