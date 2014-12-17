<?php
/*
Template Name: Archives
*/
?>
<?php get_header(); ?>
<div class="article">
  <div id="article-detail">
    <h2>Archives by Month:</h2>
    <ul>
      <?php wp_get_archives('type=monthly'); ?>
    </ul>
  </div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
