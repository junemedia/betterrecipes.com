=== Gallery Slider ===
Contributors: Cameron Preston
Donate link: http://cameronpreston.com/projects/plugins
Tags: slideshow pro, slide show, wordpress plugins, slideshow gallery, slides, slideshow, image gallery, gallery, content gallery, javascript, javascript slideshow, slideshow gallery, jquery, ajax
Requires at least: 2.8
Tested up to: 3.0.1
Stable tag: 0.2

Gallery Slider slides through your wordpress gallery.
== Description ==
Gallery Slider is a photo and image viewing plugin that integrates seemlessly with the WordPress image upload and gallery system.  Using the most current web technologies like AJAX and JQuery, this viewing and linking solution is the best and easiest to use slideshow available on Wordpress.
Check out more details here: http://cameronpreston.com/projects/plugins/gallery-slider/
Flexible, configurable and easy to use. Embed-able and hardcode-able and improved. To embed into a post/page, simply insert <code>[gslider]</code> into its content with optional <code>post_id</code>, <code>exclude</code>, <code>exclude</code>, and <code>auto</code>  parameters. To hardcode into any PHP file of your WordPress theme, simply use <code><?php if (class_exists('GSlider')) { $GSlider = new GSlider(); $GSlider -> slideshow($output = true, $post_id = null); } ?></code> and specify the required <code>$post_id</code> parameter accordingly.
== Installation ==

Installing the Gallery Slider plugin manually is very easy. Simply follow the steps below.

1. Extract the package to obtain the `gallery-slider` folder
1. Upload the `gallery-slider` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configure the settings according to your needs through the 'GallerySlider' > 'Configuration' menu
1. Add and manage your slides in the 'GallerySlider' section (Or just use the built in wordpress gallery)
1. Put `[slideshow post_id="X" exclude="" caption="on/off"]` to embed a slideshow with the images of a post into your posts/pages or use `[slideshow custom=1]` to embed a slideshow with your custom added slides or `<?php if (class_exists('GSlider')) { $GSlider = new GSlider(); $GSlider -> slideshow($output = true, $post_id = null); }; ?>` into your WordPress theme
1. For the most up to date list of options available please goto: http://cameronpreston.com/projects/plugins/gallery-slider/

== Frequently Asked Questions ==

= Can I display/embed multiple instances of the slideshow gallery? =

Yes, you can, but only one slideshow per page.

= What if I only want captions on some of my pages

Set your default captions to off; for any slideshow you put on your page use `[slideshow caption="on"]`

= What if my configuration isn't showing up? =

You're most likely not running PHP5. Talk to your host to upgrade or switch your hosting provider. PHP5 is eleventy years old.

= How do I find the numbers to exclude (or include)? =

Not as easy as it used to be! Go into the Media Library. Choose an image you want to exclude and click on it and notice your address bar: "/wp-admin/media.php?action=edit&attachment_id=353". Therefore, `[slideshow exclude=353]`

== Screenshots ==

1. ...
2. ...
== Upgrade Notice ==

== Changelog ==
= 0.2 =
Added preload for custom slides
changed preload image to one with white background
updated some readme stuff
= 0.1 =
first one
== Upgrade Notice ==
