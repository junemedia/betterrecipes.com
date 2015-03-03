<script>
<?php $blog_shortname = mb_substr( get_bloginfo('url'), strpos(get_bloginfo('url'), ".com/blogs/") + 11); ?>
var yieldbotCode = {
	bhg: (jQuery.browser.mobile) ? 'bb9f' : 'e8e0', 
	dlv: 'fc78', 
	fc: 'f0bf', 
	fitness: 'fe63', 
	lhj: '71d9', 
	midwest: '7df9', 
	parents: (jQuery.browser.mobile) ? 'f467' : '2d87', 
	rrmag: 'ae32', 
	recipecom: (jQuery.browser.mobile) ? '31dd' : '8155', 
	traditionalhome: '691f', 
	wood: 'c0ed',
	br: 'd45f' 
};
var adService = {
	mobileAds: (jQuery.browser.mobile) ? true : false,
	kruxEnabled: true,
	yieldbotEnabled: true,
	yieldbotPub: yieldbotCode[brand],
	unitValues: {
		adDomain: '',
		channel: 'blogs',
		parent: '<?php echo $blog_shortname; ?>'
	},
	pageTargetingValues: {
		id: '',
		type: '',
		tags: '',
		search: '',
		excludeKargoSiteSkin: 'true'
	}
};
// define adDomain on blogs dev
if (document.URL.indexOf('green.resolute.com') !== -1) {
	adService.unitValues.adDomain = brand + ((jQuery.browser.mobile) ? '.mdp.mob' : '.mdp.com');
}
// change adDomain suffix for bhgscrapbooks
if (brand === 'sbe') {
	adService.unitValues.adDomain = 'bhgscrapbooks.msim';
}

// define pageTargetingValues
<?php if (is_404()) { ?>
	// 404
	adService.pageTargetingValues.id = '404-<?php echo $blog_shortname; ?>';
	adService.pageTargetingValues.type = '404';
<?php } elseif (is_author()) { ?>
	// author page
	adService.pageTargetingValues.id = '<?php the_author_meta('user_login'); ?>';
	adService.pageTargetingValues.type = 'author';
<?php } elseif (is_category()) { ?>
	// category page
	adService.pageTargetingValues.id = '<?php echo sanitize_title(single_cat_title('', false)); ?>';
	adService.pageTargetingValues.type = 'category';
<?php } elseif (is_date()) { ?>
	// archive page
	adService.pageTargetingValues.id = '<?php echo sanitize_title(single_month_title('', false)); ?>';
	adService.pageTargetingValues.type = 'archive';
<?php } elseif (is_front_page() || is_home()) { ?>
	// homepage or index page
	adService.pageTargetingValues.id = 'homepage-<?php echo $blog_shortname; ?>';
	adService.pageTargetingValues.type = 'homepage';
<?php } elseif (is_page()) { ?>
	// page
	adService.pageTargetingValues.id = '<?php echo basename(get_permalink()); ?>';
	adService.pageTargetingValues.type = 'page';
<?php } elseif (is_search()) { ?>
	// search
	adService.pageTargetingValues.type = 'search';
	adService.pageTargetingValues.search = document.URL.substring(document.URL.indexOf('?s=') + 3);
	adService.pageTargetingValues.id = 'search-<?php echo $blog_shortname; ?>';
<?php } elseif (is_single()) { ?>
	// post
	adService.pageTargetingValues.id = '<?php echo basename(get_permalink()); ?>';
	adService.pageTargetingValues.type = 'post';
<?php } elseif (is_tag()) { ?>
	// tag page
	adService.pageTargetingValues.id = '<?php echo sanitize_title(single_tag_title('', false)); ?>';
	adService.pageTargetingValues.type = 'tag';
<?php } ?>

(function() {
	var d = new Date(), dateBits = [], dow, diff, gadsCore, cdnPath;
	d.setUTCHours(d.getUTCHours() - 9);
	dow = d.getUTCDay();
	diff = ((dow < 2) ? 2 : 5) - dow;
	diff = (diff < 1) ? diff+4 : diff;
	d.setUTCDate(d.getUTCDate() + diff);
	dateBits.push(d.getUTCFullYear());
	dateBits.push(d.getUTCMonth()+1);
	dateBits.push(d.getUTCDate());
	adService.cacheBuster = '?' + dateBits.join('-');
	gadsCore = document.createElement('script');
	gadsCore.src = 'http://s2.mdpcdn.com/web/js-min/js/mdp/app/gpt/gpt.core.js' + adService.cacheBuster;
	var node = document.getElementsByTagName('script')[0];
	node.parentNode.insertBefore(gadsCore, node);
})();
</script>