<?php get_header(); ?>
<div class="article">
  <?php if (have_posts()) : ?>
  <h1 class="catTitle">
  Search Results for &ldquo;
  <?=the_search_query()?>
  &rdquo;
  </h2>
  <?php while (have_posts()) : the_post(); ?>
  <?php include('posthead.php'); ?>
  <div class="article-detail">
    <?php the_content(__('Read more'));?>
  </div>
  <?php include('postfoot.php'); ?>
  <?php endwhile; else: ?>
  <h2>No Results for &ldquo;
    <?=the_search_query()?>
    &rdquo;</h2>
  <p>
    <?php include (TEMPLATEPATH . '/searchform.php'); ?>
  </p>
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
