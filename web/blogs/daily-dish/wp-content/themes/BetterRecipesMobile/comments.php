<?php // Do not delete these lines
 if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
  die ('Please do not load this page directly. Thanks!');
  if (!empty($post->post_password)) { // if there's a password
   if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie			?>

<p>
 <?php _e("This post is password protected. Enter the password to view comments."); ?>
</p>

<?php
   return;
  }
 }
 /* This variable is for alternating comment background */
 $oddcomment = 'alt';
?>


<div class="section-wrap">


	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>  
<?php else : ?>

<?php if ($comments) : ?>
	
	<p class="commentStat fs11 mb10"><em><?php comments_number('No Responses', 'One Response', '% Responses' );?> to &#8220;<?php the_title(); ?>&#8221;</em></p>
	
	<ul class="img100left divider">
		<?php wp_list_comments('callback=gtcn_basic_callback'); ?>
	</ul>
	
  	<p class="comment-pagination"><?php paginate_comments_links(); ?></p>
  
  
	 <?php  else : // this is displayed if there are no comments so far ?>
	 <?php if ('open' == $post-> comment_status) : ?>
	 <!-- If comments are open, but there are no comments. -->
	 <?php else : // comments are closed ?>
	 <!-- If comments are closed. -->
	 <p class="nocomments">Comments are closed.</p>
	 <?php endif; ?>
	 <?php endif; ?>
	 <?php if ('open' == $post-> comment_status) : ?>
	 <?php endif; // If registration required and not logged in ?>
	 <?php endif; // if you delete this your computer will explode ?>
 
		<?
			$comment_args = array( 'fields' => apply_filters( 'comment_form_default_fields', array(
				'author' => '<fieldset class="comment-form-author">' .
				'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />' .
				'<label for="author">' . __( 'Name' ) . '</label> ' .
				( $req ? '<span class="required">*</span>' : '' ) .
				'</fieldset><!-- #form-section-author .form-section -->',
				'email'  => '<fieldset class="comment-form-email">' .
				'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />' .
				'<label for="email">' . __( 'Email' ) . '</label> ' .
				( $req ? '<span class="required">*</span>' : '' ) .
				'</fieldset><!-- #form-section-email .form-section -->',
				'url'    => '<fieldset class="comment-form-url">' .
				 '<input id="url" name="url" type="text" value="' . esc_attr(  $commenter['comment_author_url'] ) . '" size="30" />' .
				'<label for="url">' . __( 'Website' ) . '</label>'.
				'</fieldset>'
				 ) ),
				'comment_field' => '<fieldset class="comment-form-comment">' .
				'<label for="comment">' . __( 'Let us know what you have to say:' ) . '</label>' .
				'<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>' .
				'</fieldset><!-- #form-section-comment .form-section -->',
				'comment_notes_after' => '',
			);
			comment_form($comment_args);
		?>


</div><!-- .section-wrap -->







