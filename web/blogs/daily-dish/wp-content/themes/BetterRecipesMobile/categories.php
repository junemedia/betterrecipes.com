<?php
/*
Template Name: Categories
*/
?>
<?php get_header(); ?>
<div class="article">
  <div id="article-detail">
    <h2>Categories</h2>
    <ul>
      <?php wp_list_categories(); ?>
    </ul>
    <h2>Tags</h2>
    <ul>
      <?php the_tags(' ', ',', ''); ?>
    </ul>
  </div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
