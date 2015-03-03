jQuery(document).ready(function($){
	/*$(".reply").each(function(){
		var this_left = $(this).siblings(".comment-author").width() + $(this).siblings(".comment-meta").width() + 78 +"px";
		$(this).css({"right":"inherit", "left":this_left, "padding-left": $(this).parent().css("padding-left")});
		console.log(this_left);
	});*/
	
	if ( $('.posts-wrap').length > 0 ) {
        $(".posts-wrap a[rel^='attachment']").each(function() { 
		      $(this).removeAttr('href');
		});
	}

	
});