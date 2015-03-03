<? if( is_single() ): ?>
<h4 class="green"><?php the_title(); ?></h4>
<? else: ?>
<h4><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
<? endif; ?>
  <? if( is_single() ){  ?>
    <p><a href="#<?php comments_number(__('article-detail'), __('top-o-comments'), __('top-o-comments')); ?>"><?php comments_number(__('No Comments'), __('1 Comment'), __('% Comments')); ?></a> | Written on
      <?php the_time('F j, Y'); ?>
      at
      <?php the_time() ?>
      , by
      <?php the_author_posts_link(); ?>
    </p>
	<? } else { ?>
    <p><a href="<?php the_permalink() ?>#respond"><?php comments_number(__('No Comments'), __('1 Comment'), __('% Comments')); ?></a> | Written on
      <?php the_time('F j, Y'); ?>
      at
      <?php the_time() ?>
      , by
      <?php the_author_posts_link(); ?>
    </p>
<? } ?>
<div class="social">
<script type="text/javascript">
  var act = new gigya.services.socialize.UserAction();
  act.setUserMessage("Here's a great post from <?php echo get_bloginfo('name'); ?>!");
  act.setTitle("<?php the_title(); ?>");
  act.setLinkBack("<?php the_permalink(); ?>");
  act.setDescription("<?php echo str_replace("\n"," ",(htmlspecialchars(get_the_excerpt(), ENT_COMPAT))); ?>");
  act.addActionLink("Read Post", "<?php the_permalink(); ?>");
  act.addMediaItem({ type: 'image', src: '<?php echo show_first_image() ?>', href: '<?php the_permalink(); ?>' });
	// BEGIN: gigya left side
  var showShareBarUI_params=
  { 
    containerID: 'gigya<?php the_ID(); ?>',
    shareButtons: 'Facebook-Like,pinterest,twitter-tweet,google-plusone,share,email',
    emailProviders: 'google, yahoo',
    // showCounts: 'none',
    iconsOnly: 'true',
    userAction: act
  };
	// END: gigya left side
	// BEGIN: gigya right side
  /*var showShareBarUI_params2=
  { 
    containerID: 'gigya<?php the_ID(); ?>-2',
    shareButtons: 'Share,Facebook,Twitter,Email',
		shareButtons:  
		[  
			{ 
				provider:'Share',
				enableCount: false,
				iconsOnly: false,
				noButtonBorders: true
			},  
			{  
				provider:'Facebook',
				iconImgUp:'/blogs/daily-dish//wp-content/themes/BetterRecipes2/img/icon-facebook.png',
				enableCount: false,
				iconsOnly: true,
				noButtonBorders: true
			}, 
			{  
				provider:'stumbleupon',
				iconImgUp:'/blogs/daily-dish//wp-content/themes/BetterRecipes2/img/icon-stumble.jpg',// // // // 
				enableCount: false,
				iconsOnly: true,
				noButtonBorders: true
			}, 
			{
				provider:'Twitter',
				iconImgUp:'/blogs/daily-dish//wp-content/themes/BetterRecipes2/img/icon-twitter.png',
				enableCount: false,
				iconsOnly: true,
				noButtonBorders: true
			},  
			{
				provider:'Email',  
				iconImgUp:'/blogs/daily-dish//wp-content/themes/BetterRecipes2/img/icon-email.png',
				iconsOnly: true,
				noButtonBorders: true
			}  
		],  
    emailProviders: 'google, yahoo',
    // showCounts: 'none',
    // iconsOnly: 'true',
    userAction: act,
  	showEmailButton: true,
  	onSendDone: gigya.reporting.onSendDone
  };*/
	// END: gigya right side
  </script>
  <div id="gigya<?php the_ID(); ?>" class="pt5 gigyasharebar"></div>
  <!--<a id="gigya-btn" href="http://pinterest.com/kristinavanni/"><img src="http://passets-cdn.pinterest.com/images/big-p-button.png" width="61" height="61" alt="Follow Me on Pinterest" /></a>-->
  <div id="gigya<?php the_ID(); ?>-2"></div>
	<script type="text/javascript">gigya.services.socialize.showShareBarUI(conf,showShareBarUI_params); //gigya.services.socialize.showShareBarUI(conf,showShareBarUI_params2);</script>
  <a href="javascript:;" onclick="emailRecipe()" title="Email this page!" class="btn-grey28 btn-email">EMAIL</a>
  <a href="javascript:;" onclick="window.print();" title="Print this page!" class="btn-print btn-grey28">PRINT</a>
  <a href="<?php the_permalink() ?>#respond" title="Comment on this page!" class="btn-grey28 btn-comment">COMMENT</a>
</div>
<div class="clearall"></div>
