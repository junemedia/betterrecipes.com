<?php get_header(); ?>
<div class="article">
  <div id="article-detail">
    <?php is_tag(); ?>
    <?php if (have_posts()) : ?>
    <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
    <?php /* If this is a category archive */ if (is_category()) { ?>
    <h1 class="catTitle">
      <?php single_cat_title(); ?>
    </h1>
    <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
    <h1 class="catTitle">
      <?php single_tag_title(); ?>
    </h1>
    <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
    <h1 class="catTitle">
      <?php the_time('F jS, Y'); ?>
    </h1>
    <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
    <h1 class="catTitle">
      <?php the_time('F Y'); ?>
    </h1>
    <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
    <h1 class="catTitle">
      <?php the_time('Y'); ?>
    </h1>
    <?php /* If this is an author archive */ } elseif (is_author()) { ?>
    <?php
						if(isset($_GET['author_name'])) : $curauth = get_userdatabylogin($author_name);
						else : $curauth = get_userdata(intval($author));
						endif;
				?>
    <h1 class="catTitle"><?php echo $curauth->display_name; ?></h1>
    <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
      <h1 class="catTitle">Blog Archives</h1>
      <?php } ?>
    <div class="navigation">
      <div class="alignleft">
        <?php next_posts_link('&laquo; Older Entries') ?>
      </div>
      <div class="alignright">
        <?php previous_posts_link('Newer Entries &raquo;') ?>
      </div>
    </div>
    <div class="post">
      <?php while (have_posts()) : the_post(); ?>
      <?php include('posthead.php'); ?>
      <?php the_content(__('Read more'));?>
      <?php include('postfoot.php'); ?>
      <?php endwhile; ?>
    </div>
    <!-- end post -->
    <div class="navigation">
      <div class="alignleft">
        <?php next_posts_link('&laquo; Older Entries') ?>
      </div>
      <div class="alignright">
        <?php previous_posts_link('Newer Entries &raquo;') ?>
      </div>
    </div>
    <?php else : ?>
    <div class="post">
      <h2>Not Found</h2>
      <p>Try using the search form below</p>
      <?php include (TEMPLATEPATH . '/searchform.php'); ?>
    </div>
    <?php endif; ?>
  </div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
