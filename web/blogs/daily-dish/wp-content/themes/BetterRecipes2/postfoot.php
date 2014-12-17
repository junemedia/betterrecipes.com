<div id="postmeta">
	<p> Categories:
		<?php the_category(', ') ?>
		|  Tags:
		<?php the_tags(' ', ', ', ' '); ?>
		<br>
		<? if( is_single() ){ ?>
		<?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?>
		| <a href="#respond">Post Your Comment</a>
		<? } else { ?>
		<?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?>
		| <a href="<?php the_permalink() ?>#respond" class="btn-grey28 btn-comment">POST YOUR COMMENT</a>
		<? } ?>
	</p>
</div>
