/* jQuery.preloader - v0.95 - K Reeve aka BinaryKitten
*
* v0.95
* 	# Note - keeping below v1 as really not sure that I consider it public usable.
* 	# But it saying that it does the job it was intended to do.
* 	Added Completion of loading callback.
* 	Main Reworking With Thanks to Remy Sharp of jQuery for Designers
*/

(function ($) {
	$.preLoadImages = function(imageList,callback) {
		var pic = [], i, total, loaded = 0;
		if (typeof imageList != 'undefined') {
			if ($.isArray(imageList)) {
				total = imageList.length; // used later
					for (i=0; i < total; i++) {
						pic[i] = new Image();
						pic[i].onload = function() {
							loaded++; // should never hit a race condition due to JS's non-threaded nature
							if (loaded == total) {
								if ($.isFunction(callback)) {
									callback.apply();
								}
							}
						};
						pic[i].src = imageList[i];
					}
			}
			else {
				pic[0] = new Image();
				pic[0].onload = function() {
					if ($.isFunction(callback)) {
						callback();
					}
				}
				pic[0].src = imageList;
			}
		}
		pic = undefined;
	};
})(jQuery);
