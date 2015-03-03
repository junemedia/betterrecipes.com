<?php get_header(); ?> 
<div class="article">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <?php include('posthead.php'); ?>
  <div id="article-detail">
    <?php the_content(__('Read more'));?>
  </div>
  <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
  
	<script id="mNCC" language="javascript"> medianet_width='656'; medianet_height= '175'; medianet_crid='728775725'; </script>
	<script id="mNSC" src="http://contextual.media.net/nmedianet.js?cid=8CUPTG615" language="javascript"></script>
	<div class="OUTBRAIN" data-src="<?php the_permalink(); ?>" data-widget-id="AR_2" data-ob-template="BetterRecipes" ></div>
	<script type="text/javascript" async="async" src="http://widgets.outbrain.com/outbrain.js"></script>

  <?php include('postfoot.php'); ?>
  <?php comments_template(); ?> 
  <?php endwhile; else: ?>
  <p><strong>There has been an error, please click your browser's Back button and try again.</strong></p>
  <?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>