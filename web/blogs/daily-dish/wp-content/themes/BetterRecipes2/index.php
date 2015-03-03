<?php get_header(); ?>
<div class="article">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <?php include('posthead.php'); ?>
  <div class="article-detail">
    <?php the_content(__('Read more'));?>
  </div>
  <?php include('postfoot.php'); ?>
  <hr />
  <?php endwhile; else: ?>
  <p><strong>An Error Occured.</strong></p>
  <?php endif; ?>
  <div class="navigation">
    <div class="alignleft">
      <?php next_posts_link('&laquo; Older Entries') ?>
    </div>
    <div class="alignright">
      <?php previous_posts_link('Newer Entries &raquo;') ?>
    </div>
  </div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
