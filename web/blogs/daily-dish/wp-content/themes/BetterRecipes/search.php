<?php get_header(); ?>

		
				<div id="maincolumn">
					<div id="maincontentwell">


 <div id="content">
						<?php include('breadcrumb.php'); ?>
  <div class="post">
<?php if (have_posts()) : ?> 

<h1 class="pagetitle">Search Results for '<?=the_search_query()?>'</h2>

	<?php while (have_posts()) : the_post(); ?>

						  <?php include('posthead.php'); ?>

 <?php the_content(__('Read more'));?>	

							<?php include('postfoot.php'); ?>
						  <hr class="posttween"/>

<?php endwhile; else: ?>

						 	<h2>No Results for '<?=the_search_query()?>'</h2>

							<p><?php include (TEMPLATEPATH . '/searchform.php'); ?></p>
							
<?php endif; ?>

							<div class="navigation">
								<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
								<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
</div>
							
						  </div><!-- end post -->
						</div><!-- end content -->


					<div class="clearall"> </div>	
					</div><!-- end maincontentwell -->
					

				</div><!-- end maincolumn -->
				
				
<?php get_sidebar('left'); ?> 
<?php get_sidebar('right'); ?>
<?php get_footer(); ?>
