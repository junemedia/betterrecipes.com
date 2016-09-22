<script>
<?php $blog_shortname = mb_substr( get_bloginfo('url'), strpos(get_bloginfo('url'), ".com/blogs/") + 11); ?>
<?php $GPTSearch = ( isset($_GET['s']) && $_GET['s'] != '' ) ? $_GET['s'] : ''; ?>

(function() {

var isMobile = (jQuery && jQuery.browser) ? jQuery.browser.mobile : /Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

window.adService = {
    mobileAds: ( (isMobile) ) ? true : false,
    pageTargetingValues: {
        search: '<?php echo $GPTSearch; ?>'
    },
    unitValues: {
        adDomain: document.URL.indexOf('.resolute.com') !== -1 ? brand + (isMobile ? '.mdp.mob' : '.mdp.com') : undefined,
        channel: 'blogs',
        parent: '<?php echo $blog_shortname; ?>',
        child: ''
    }
};

})();

// define pageTargetingValues
<?php if (is_404()) { ?>
	// 404
	adService.pageTargetingValues.id = '404-<?php echo $blog_shortname; ?>';
	adService.pageTargetingValues.type = '404';
<?php } elseif (is_author()) { ?>
	// author page
	adService.pageTargetingValues.id = '<?php the_author_meta('user_login'); ?>';
	adService.pageTargetingValues.type = 'author';
<?php } elseif (is_category() || is_front_page() || is_home()) { ?>
	// category page
	adService.pageTargetingValues.id = '<?php echo sanitize_title(single_cat_title('', false)); ?>';
	adService.pageTargetingValues.type = 'category';
<?php } elseif (is_date()) { ?>
	// archive page
	adService.pageTargetingValues.id = '<?php echo sanitize_title(single_month_title('', false)); ?>';
	adService.pageTargetingValues.type = 'archive';
<?php } elseif (is_page()) { ?>
	// page
	adService.pageTargetingValues.id = '<?php echo basename(get_permalink()); ?>';
	adService.pageTargetingValues.type = 'page';
<?php } elseif (is_search()) { ?>
	// search
	adService.pageTargetingValues.id = 'search-<?php echo $blog_shortname; ?>';
    adService.pageTargetingValues.type = 'search';
    adService.pageTargetingValues.search = document.URL.substring(document.URL.indexOf('?s=') + 3);
<?php } elseif (is_single()) { ?>
	// post
	adService.pageTargetingValues.id = '<?php echo basename(get_permalink()); ?>';
	adService.pageTargetingValues.type = 'post';
<?php } elseif (is_tag()) { ?>
	// tag page
	adService.pageTargetingValues.id = '<?php echo sanitize_title(single_tag_title('', false)); ?>';
	adService.pageTargetingValues.type = 'tag';
<?php } ?>


(function(window) {
  var karmaCore=document.createElement("script");
  karmaCore.src="http://karma.mdpcdn.com/service/js-min/karma.core.js";
  var node=document.getElementsByTagName("script")[0];
  node.parentNode.insertBefore(karmaCore,node);
})(window);

</script>