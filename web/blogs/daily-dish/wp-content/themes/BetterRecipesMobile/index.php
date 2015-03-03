<?php get_header(); ?>
	
	<?php
	
		if(is_home() || is_front_page()) {
			$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
			query_posts('showposts=2&paged='.$page.'&posts_per_page=2');
     	}

	
	?>
	
	<div class="posts-wrap">
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	    <div class="post">
	      <?php include('posthead.php'); ?>
	      <div class="the-content">
	      	<?php the_content(__('Read more'));?>
	      </div><!-- /.the-content -->
	    </div><!-- /.post -->
    <?php endwhile; ?>
    <?php endif; ?>
    
    
    
  </div><!-- /.posts-wrap -->
  	<div id="post-nav">
	<p class="cta-more"><?php next_posts_link('View Older Posts') ?></p>
	</div>

<?php get_footer(); ?>
