<?php // Do not delete these lines
	  if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) {
		 // message for notifying of password-protected posts
		return;
	}
?>

<?php if (have_comments()) : ?>
    <h3 class="hot_topics">Add a Comment</h3>
    <div id="commentlist">
	<?php wp_list_comments('type=comment&callback=format_comment&style=div'); ?>
	<!--/commentlist-->
	</div>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>

	<?php $postinfo = get_post($post->ID);
	      if(comments_open()) : ?>
		  <a class="comment-reply-link" href="#goto">Would you like to join the discussion?</a>

	<?php else : ?>
	      <small>Sorry - comments are closed on this subject. You can thank the spammers for that one.</small>
	<?php endif;
	      endif; ?>