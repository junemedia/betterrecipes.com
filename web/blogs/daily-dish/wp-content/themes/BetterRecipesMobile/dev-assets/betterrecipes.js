jQuery(document).ready(function($){
	// BEGIN: homepage gallery
		$('#show_slide1').click(function(){
			$('#gallery .picture .picts').animate({
				'left': '0px'
			}, 500, function() {
				$("#gallery ul li a").removeClass("current");
				$("#show_slide1").addClass("current");
				$('#gallery .marker').animate({
					'top':'20px'
				}, 250, function(){
					// Animation complete
				});
			});
		});
		$('#show_slide2').click(function(){
			$('#gallery .picture .picts').animate({
				'left': '-300px'
			}, 500, function() {
				$("#gallery ul li a").removeClass("current");
				$("#show_slide2").addClass("current");
				$('#gallery .marker').animate({
					'top':'90px'
				}, 250, function(){
					// Animation complete
				});
			});
		});
		$('#show_slide3').click(function(){
			$('#gallery .picture .picts').animate({
				'left': '-600px'
			}, 500, function() {
				$("#gallery ul li a").removeClass("current");
				$("#show_slide3").addClass("current");
				$('#gallery .marker').animate({
					'top':'160px'
				}, 250, function(){
					// Animation complete
				});
			});
		});
	// END: homepage gallery
	// BEGIN: sidebar tabs
		$('#show_top_recipes').click(function(){
			$("#sidebar-recipes .nav li, #sidebar-recipes .recipes").removeClass("current");
			$("#show_top_recipes").parents('li').addClass("current");
			$("#sidebar-recipes .top").addClass("current");
		});
		$('#show_recent_recipes').click(function(){
			$("#sidebar-recipes .nav li, #sidebar-recipes .recipes").removeClass("current");
			$("#show_recent_recipes").parents('li').addClass("current");
			$("#sidebar-recipes .recent").addClass("current");
		});
		$('#show_favorite_recipes').click(function(){
			$("#sidebar-recipes .nav li, #sidebar-recipes .recipes").removeClass("current");
			$("#show_favorite_recipes").parents('li').addClass("current");
			$("#sidebar-recipes .favorite").addClass("current");
		});	
	// END: sidebar tabs
	// BEGIN: recipe description expand contract
		if( $("#recipe-detail-desc span").html() ){
			var full_description = $("#recipe-detail-desc span").html();
			if( $("#recipe-detail-desc span").html().length > 150){
				$("#recipe-detail-desc span").html( $("#recipe-detail-desc span").html().substr(0, 150) );
				$(".show_full_description").css({"display":"inline-block"}).html("  ...Read More").addClass("click_to_open");
			}
		}
		$("#recipe-detail-desc .show_full_description").click(function(){
			if($(this).hasClass("click_to_open")){
				$("#recipe-detail-desc span").html(full_description);
				$(this).removeClass("click_to_open").addClass("click_to_close").html("  ...Minimize");
			} else {
				$("#recipe-detail-desc span").html( $("#recipe-detail-desc span").html().substr(0, 150));
				$(this).removeClass("click_to_close").addClass("click_to_open").html("  ...Read More");
			}
		});
	// END: recipe description expand contract
	// BEGIN: recipe details comments
		if( $("#recipe-comments .comments .comment span").html() ){
			var all_comments = [];
			$("#recipe-comments .comments .comment span").each(function(index) {
				$(this).addClass('comment' + [index]);
				all_comments.push($(this).text());
				if( $(this).html().length > 150){
					$(this).html( $(this).html().substr(0, 150) );
					$(this).siblings(".show_full_description").css({"display":"inline-block"}).html("  ...Read More").addClass("click_to_open");
				}
			});
		}
		$("#recipe-comments .comments .comment .show_full_description").click(function(){
			if($(this).hasClass("click_to_open")){
				var array_placement = $(this).siblings("span").attr('class').substring(7,8);
				$(this).siblings("span").html(all_comments[array_placement]);
				$(this).removeClass("click_to_open").addClass("click_to_close").html("  ...Minimize");
			} else {
				$(this).siblings("span").html( $(this).siblings("span").html().substr(0, 150));
				$(this).removeClass("click_to_close").addClass("click_to_open").html("  ...Read More");
			}
		});
	// END: recipe details comments
	// BEGIN: tabbed nav
		$('#group-tabs .tabbednav li a').click(function(){
			$(this).parents("li").siblings("li").removeClass("active");
			$(this).parents('li').addClass("active");
			var create_css = $(this).attr("id").split("_");
			$("#group-tabs .section-wrap").removeClass("active")
			$("#group-tabs #" + create_css[2] ).addClass("active");
		});
	// END: tabbed nav
	// BEGIN: tabbed nav group-recipes
		$('#group-recipes .tabbednav li a').click(function(){
			$(this).parents("li").siblings("li").removeClass("active");
			$(this).parents('li').addClass("active");
			var create_css = $(this).attr("id").split("-");
			console.log($(this).attr("id"));
			$("#group-recipes .section-wrap").removeClass("active")
			$("#group-recipes #" + create_css[1] ).addClass("active");
		});
	// END: tabbed nav group-recipes
	// BEGIN: tabbed nav group-recipes
		$('#group-media .tabbednav li a').click(function(){
			$(this).parents("li").siblings("li").removeClass("active");
			$(this).parents('li').addClass("active");
			var create_css = $(this).attr("id").split("-");
			console.log($(this).attr("id"));
			$("#group-media .section-wrap").removeClass("active")
			$("#group-media ." + create_css[1] ).addClass("active");
		});
	// END: tabbed nav group-recipes
	// BEGIN: tabbed nav sidebar group activity
		$('#member-activity .tabbednav li a').click(function(){
			$(this).parents("li").siblings("li").removeClass("active");
			$(this).parents('li').addClass("active");
			var create_css = $(this).attr("id").split("-");
			console.log($(this).attr("id"));
			$("#member-activity .section-wrap").removeClass("active")
			$("#member-activity ." + create_css[1] ).addClass("active");
		});
	// END: tabbed nav sidebar group activity
	// BEGIN: limit copy to 300 characters
		if( $(".limitcopy-300 span").html() ){
			var all_comments300 = [];
			$(".limitcopy-300 span").each(function(index) {
				$(this).addClass('comment' + [index]);
				all_comments300.push($(this).text());
				if( $(this).html().length > 300){
					$(this).html( $(this).html().substr(0, 300) );
					$(this).siblings(".show_full_copy").css({"display":"inline-block"}).html("  ...Read More").addClass("click_to_open");
				}
			});
		}
		$(".limitcopy-300 .show_full_copy").click(function(){
			if($(this).hasClass("click_to_open")){
				var array_placement = $(this).siblings("span").attr('class').substring(7,8);
				console.log(array_placement);
				$(this).siblings("span").html(all_comments300[array_placement]);
				$(this).removeClass("click_to_open").addClass("click_to_close").html("  ...Minimize");
			} else {
				$(this).siblings("span").html( $(this).siblings("span").html().substr(0, 300));
				$(this).removeClass("click_to_close").addClass("click_to_open").html("  ...Read More");
			}
		});
	// END: limit copy to 300 characters
	// BEGIN: limit copy to 150 characters
		if( $(".limitcopy-150 span").html() ){
			var all_comments150 = [];
			$(".limitcopy-150 span").each(function(index) {
				$(this).addClass('comment' + [index]);
				all_comments150.push($(this).text());
				if( $(this).html().length > 150){
					$(this).html( $(this).html().substr(0, 150) );
					$(this).siblings(".show_full_copy").css({"display":"inline-block"}).html("  ...Read More").addClass("click_to_open");
				}
			});
		}
		$(".limitcopy-150 .show_full_copy").click(function(){
			if($(this).hasClass("click_to_open")){
				var array_placement = $(this).siblings("span").attr('class').substring(7,8);
				console.log(array_placement);
				$(this).siblings("span").html(all_comments150[array_placement]);
				$(this).removeClass("click_to_open").addClass("click_to_close").html("  ...Minimize");
			} else {
				$(this).siblings("span").html( $(this).siblings("span").html().substr(0, 150));
				$(this).removeClass("click_to_close").addClass("click_to_open").html("  ...Read More");
			}
		});
	// END: limit copy to 150 characters
	// BEGIN: limit copy to 135 characters
		if( $(".limitcopy-135 span").html() ){
			var all_comments135 = [];
			$(".limitcopy-135 span").each(function(index) {
				$(this).addClass('comment' + [index]);
				all_comments135.push($(this).text());
				if( $(this).html().length > 135){
					$(this).html( $(this).html().substr(0, 135) );
					$(this).siblings(".show_full_copy").css({"display":"inline-block"}).html("  ...Read More").addClass("click_to_open");
				}
			});
		}
		$(".limitcopy-135 .show_full_copy").click(function(){
			if($(this).hasClass("click_to_open")){
				var array_placement = $(this).siblings("span").attr('class').substring(7,8);
				$(this).siblings("span").html(all_comments135[array_placement]);
				$(this).removeClass("click_to_open").addClass("click_to_close").html("  ...Minimize");
			} else {
				$(this).siblings("span").html( $(this).siblings("span").html().substr(0, 135));
				$(this).removeClass("click_to_close").addClass("click_to_open").html("  ...Read More");
			}
		});
	// END: limit copy to 135 characters
	// BEGIN: limit copy to 100 characters
		if( $(".limitcopy-100 span").html() ){
			var all_comments100 = [];
			$(".limitcopy-100 span").each(function(index) {
				$(this).addClass('comment' + [index]);
				all_comments100.push($(this).text());
				if( $(this).html().length > 100){
					$(this).html( $(this).html().substr(0, 100) );
					$(this).siblings(".show_full_copy").css({"display":"inline-block"}).html("  ...Read More").addClass("click_to_open");
				}
			});
		}
		$(".limitcopy-100 .show_full_copy").click(function(){
			if($(this).hasClass("click_to_open")){
				var array_placement = $(this).siblings("span").attr('class').substring(7,8);
				$(this).siblings("span").html(all_comments100[array_placement]);
				$(this).removeClass("click_to_open").addClass("click_to_close").html("  ...Minimize");
			} else {
				$(this).siblings("span").html( $(this).siblings("span").html().substr(0, 100));
				$(this).removeClass("click_to_close").addClass("click_to_open").html("  ...Read More");
			}
		});
	// END: limit copy to 100 characters
	// BEGIN: slideshow animation using cycle
		if( $("#slideshow-wrap #slideshow .slides .slide").length ){
			$('#slideshow-wrap #slideshow .slides').cycle({
				fx:     'fade', 
				speed:  'fast', 
				timeout: 0, 
				next:   '.next-slide', 
				prev:   '.prev-slide',
				after: onAfter
			});
		}
	// END: slideshow animation using cycle
	// BEGIN: breadcrumb sidebar fix
		if( $("#breadcrumbs").length >= 1 ){
			$("#main-content").addClass("has-breadcrumbs");
		}
	// END: breadcrumb sidebar fix
	// BEGIN: form add recipes tabbed nav
		$('.add-recipes .tabbednav li a').click(function(){
			$(this).parents("li").siblings("li").removeClass("active");
			$(this).parents('li').addClass("active");
			var create_css = $(this).attr("id").split("_");
			$(".add-recipes form").removeClass("active");
			$(".add-recipes form#" + create_css[1] ).addClass("active");
		});
	// END: form add recipes tabbed nav
	// BEGIN: form add recipes tabbed nav
		$('#journals .tabbednav li a').click(function(){
			$(this).parents("li").siblings("li").removeClass("active");
			$(this).parents('li').addClass("active");
			var create_css = $(this).attr("id").split("_");
			$("#journals .section-wrap").removeClass("active");
			$("#journals #" + create_css[1] ).addClass("active");
		});
	// END: form add recipes tabbed nav
	
	// BEGIN: limit copy to 75 characters
		if( $(".limitcopy-75 span").html() ){
			var all_comments75 = [];
			$(".limitcopy-75 span").each(function(index) {
				$(this).addClass('comment' + [index]);
				all_comments75.push($(this).text());
				if ($(this).html().length <= 75) {
					$(this).siblings(".show_full_copy").css({"display":"none"})
				} else if( $(this).html().length > 75){
					$(this).html( $(this).html().substr(0, 75) );
					$(this).siblings(".show_full_copy").css({"display":"inline-block"}).html("  ...Read More").addClass("click_to_open");
				}
			});
		}
		$(".limitcopy-75 .show_full_copy").click(function(){
			if($(this).hasClass("click_to_open")){
				var array_placement = $(this).siblings("span").attr('class').substring(7,8);
				$(this).siblings("span").html(all_comments75[array_placement]);
				$(this).removeClass("click_to_open").addClass("click_to_close").html("  ...Minimize");
			} else {
				$(this).siblings("span").html( $(this).siblings("span").html().substr(0, 75));
				$(this).removeClass("click_to_close").addClass("click_to_open").html("  ...Read More");
			}
		});
	// END: limit copy to 75 characters
	
}); // END: doc ready


// BEGIN: runs as part of the slideshow $.cycle
function onAfter(curr,next,opts) {
	var caption = (opts.currSlide + 1) + ' / ' + opts.slideCount;
	$('#caption1').html(caption);
}
// END: runs as part of the slideshow $.cycle