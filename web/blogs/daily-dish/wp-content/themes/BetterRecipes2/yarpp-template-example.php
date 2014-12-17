<?php /*
Example template
Author: mitcho (Michael Yoshitaka Erlewine)
*/
?>

<div id="relatedPosts">

<?php if (have_posts()):?>
	<h3>You might also like:</h3>
	<? $counter = 0; ?>
	<?php while (have_posts()) : the_post(); ?>
	<?php if ($counter == 4): ?>
	<a class="last" href="<?php the_permalink() ?>" rel="bookmark">
	<?php else: ?>
	<a href="<?php the_permalink() ?>" rel="bookmark">
	<?php endif; ?>
		<div class="inner">
			<? if( get_first_image() != ''): ?>
			<div class="img">
				<img src="<?php echo get_first_image() ?>" alt="<?php the_title(); ?>" />
			</div>
			<? endif; ?>
			<div class="title"><?php the_title(); ?></div>
		</div>
	</a>
	<?php $counter++; ?>
	<?php endwhile; ?>
<?php else: ?>
<?php endif; ?>
</div><!-- /#relatedPosts -->