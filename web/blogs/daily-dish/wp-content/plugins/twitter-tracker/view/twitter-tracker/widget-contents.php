<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<?php if ( ! empty( $preamble ) ) : ?><p class="tt-preamble"><?php echo $preamble; ?></p><?php endif; ?>
<ol class="tweets">
<?php foreach( $tweets AS $tweet ) : ?>
	<li class="<?php echo esc_attr( $tweet->twit_uid ); ?>">
		<div class="avatar">
			<a target="_blank" href="<?php echo esc_url( $tweet->twit_link ); ?>"><img src="<?php echo esc_url( $tweet->twit_pic ); ?>" alt="<?php echo esc_attr( $tweet->twit_name ); ?>"/></a>
		</div>
		<div class="msg">
			<span class="twit"><a target="_blank" href="<?php echo esc_url( $tweet->twit_link ); ?>"><?php echo esc_html( $tweet->twit_name ); ?></a></span>
			<span class="msgtxt"><?php echo $tweet->content; ?></span>
		</div>
	    <div class="info" style="font-size:12.6px;">
			<a target="_blank" class="tweet-link" href="<?php echo esc_url( $tweet->link ); ?>" title="<?php __( 'View tweet', 'twitter-tracker' ); ?>"></a>
		</div>
	    <div>
	    <p class="intent" style="font-size:12.6px;"><a href="https://twitter.com/intent/tweet?text=%40<?php echo esc_html( $tweet->twit_uid ); ?>%20">Reply</a>|<a href="https://twitter.com/intent/retweet?tweet_id=
		<?php $the_tweet_id_pos = strpos(esc_url($tweet->link), "/statuses/") + 10; 
		$the_tweet_id = substr(esc_url($tweet->link), $the_tweet_id_pos);
		echo $the_tweet_id; ?>">Retweet</a></p>
	    </div>
	</li>
<?php endforeach; ?>
</ol>
<?php echo $html_after; ?>