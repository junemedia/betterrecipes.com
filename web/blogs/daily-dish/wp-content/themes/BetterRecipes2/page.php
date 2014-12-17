<?php get_header(); ?>
<div class="article">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <?php include('posthead.php'); ?>
  <div id="article-detail">
    <?php the_content(__('Read more'));?>
  </div>
  <?php endwhile; else: ?>
  <p><strong>An Error Occured.</strong></p>
  <?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
