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

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>  
<?php else : ?>

<?php if ($comments) : ?>
 <!-- <p class="commentStat"><?php comments_number(__('No Comment'), __('1 Comment'), __('% Comments')); ?></p> -->

 <p class="commentStat"><?php comments_number('No Responses', 'One Response', '% Responses' );?> to &#8220;<?php the_title(); ?>&#8221;</p>

 <ol id="commentlist">
  <?php foreach ($comments as $comment) : ?>
   <li class="<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
   	<? gtcn_comment_numbering($comment->comment_ID, $args); ?>
    <div class="singlecomment">
     <p class="byLine"><?php comment_date('F j, Y') ?> at <?php comment_time()?>, by <?php comment_author_link()?></p>

    </div>
   <?php if ($comment->comment_approved == '0') : ?>
    <em>Your comment is awaiting moderation.</em>
   <?php endif; ?>
		<?php 
    if(the_author('', false) == get_comment_author())
			echo "<div class='commenttext-admin'>";
    else
			echo "<div class='commenttext'>";
			comment_text();
			echo "</div>";
    ?>
    <? // comments_form(); ?>
   </li>
   <?php /* Changes every other comment to a different class */	
    if ('alt' == $oddcomment){
     $oddcomment = 'standard';
    }
     else {
     $oddcomment = 'alt';
    }
   ?>
  <?php endforeach; /* end for each comment */ ?>
 </ol>
  
  
  
 <?php else : // this is displayed if there are no comments so far ?>
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

 <!-- <p class="commentStat"><?php comments_number('No Responses', 'One Response', '% Responses' );?> to &#8220;<?php the_title(); ?>&#8221;</p> -->
 
 <div id="commentsform">
  <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
   <?php if ( $user_ID ) : ?>
   <p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>"> (Logout) </a> </p>
   <?php else : ?>
    <p><label for="author">Name <?php if ($req) echo "<small>(required)</small>"; ?></label><br />
     <input type="text" name="author" id="s1" value="<?php echo $comment_author; ?>" size="40" tabindex="1" />
    </p>
    <p><label for="email">Mail (will not be published) <?php if ($req) echo "<small>(required)</small>"; ?></label><br />
     <input type="text" name="email" id="s2" value="<?php echo $comment_author_email; ?>" size="40" tabindex="2" />
    </p>
    <p><label for="url">Website</label><br />
     <input type="text" name="url" id="s3" value="<?php echo $comment_author_url; ?>" size="40" tabindex="3" />
    </p>
   <?php endif; ?>
    <!-- <p><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></p> -->
    <p>
     <textarea name="comment" id="s4" cols="50" rows="10" tabindex="4"></textarea>
    </p>
    <p>
     <input name="submit" type="submit" id="sbutt" tabindex="5" value="Submit Comment" />
     <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
    </p>
    <!-- <p>By submitting a comment here you grant <?php bloginfo('name'); ?> a perpetual license to reproduce your words and name/web site in attribution. Inappropriate comments will be removed at admin's discretion.</p>
   <?php do_action('comment_form', $post->ID); ?> -->
  </form>
 </div>