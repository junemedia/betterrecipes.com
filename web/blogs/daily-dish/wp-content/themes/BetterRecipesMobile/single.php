
<?php get_header(); ?>
	
	<div class="posts-wrap">
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	    <div class="post">
	      <?php include('posthead.php'); ?>
	      <div class="the-content">
	      	<?php the_content(__('Read more'));?>
	      </div><!-- /.the-content -->
	      <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
	      <?php comments_template(); ?> 
	    </div><!-- /.post -->
    <?php endwhile; else: ?>
  		<p><strong>There has been an error, please click your browser's Back button and try again.</strong></p>
    <?php endif; ?>
    
    
    
  </div><!-- /.posts-wrap -->

<?php get_footer(); ?>