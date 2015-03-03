<h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
<? if( is_single() ){  ?>
	<p class="fs11">
		<a href="#<?php comments_number(__('article-detail'), __('top-o-comments'), __('top-o-comments')); ?>"><?php comments_number(__('No Comments'), __('1 Comment'), __('% Comments')); ?></a> |
		Written on <?php the_time('F j, Y'); ?> at <?php the_time() ?>, by <a href="#" title="Author Name"><?php the_author_posts_link(); ?></a>	
	</p>

<? } else { ?>	
	
	<p class="fs11">
		<a href="<?php the_permalink() ?>#respond"><?php comments_number(__('No Comments'), __('1 Comment'), __('% Comments')); ?></a> |
		Written on <?php the_time('F j, Y'); ?> at <?php the_time() ?>, by <a href="#" title="Author Name"><?php the_author_posts_link(); ?></a>	
	</p>

<? } ?>
