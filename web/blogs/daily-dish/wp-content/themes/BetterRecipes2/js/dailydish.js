jQuery(document).ready(function($){
	$('.gigyasharebar td:nth-child(6)').css("display", "none");
//	$('.gigyasharebar td:nth-child(2) .gig-button-td table > tbody > tr > td:nth-child(2) div').css(
//		{ "background": "url(http://d3io1k5o0zdpqr.cloudfront.net/images/pinit6.png)", 
//		"font": "11px Arial, sans-serif", "text-indent": "-9999em", "font-size": ".01em", "color": "#CD1F1F", "height": "20px",
//		"width": "43px", "background-position": "0 -7px"});
	$(".reply").each(function(){
		var this_left = $(this).siblings(".comment-author").width() + $(this).siblings(".comment-meta").width() + 78 +"px";
		$(this).css({"right":"inherit", "left":this_left, "padding-left": $(this).parent().css("padding-left")});
		console.log(this_left);
	});
	
	if ( $('.article').length > 0 ) {
        $(".article a[rel^='attachment']").each(function() { 
		      $(this).removeAttr('href');
		});
	}
});
function emailRecipe()
{
  $(".gigyasharebar td:nth-child(6) div div").click();
}

// add Pin It hover button to article images
$(function () {
	"use strict";
	var images, pinURL, headline, url, media, description, imgWidth, imgAlign, winTop, winLeft;
	images = $("#article-detail img").not("#article-detail #relatedPosts img").map(function () {
		return $(this);
	});
	$.each(images, function () {
		headline = $(this).parents(".article").children("h4");
		url = document.URL;
		media = $(this).attr("src");
		description = encodeURIComponent($(headline).text());
		pinURL = "http://pinterest.com/pin/create/button/?";
		pinURL += "url=" + url;
		pinURL += "&media=" + media;
		pinURL += "&description=" + description;
		imgWidth = $(this).width() + 20; // add padding width
		if ($(this).hasClass("alignleft")) {
			imgAlign = " alignleft";
		} else if ($(this).hasClass("alignright")) {
			imgAlign = " alignright";
		} else if ($(this).hasClass("aligncenter")) {
			imgAlign = " aligncenter";
		} else {
			imgAlign = "";
			imgWidth = imgWidth - 20; // remove padding width
		}
		$(this).parent().wrap(function () {
			return "<div class='pin-it-wrapper" + imgAlign + "' style='width:" + imgWidth + "px;' />";
		});
		$(this).parent().before("<a href='" + pinURL + "' class='pin-it'><img src='http://cookie.betterrecipes.com/img/pinit_button.png' alt='Pin It!' width='80' height='50' /></a>");
	});
	$(".pin-it").css("display", "none");
	$(".pin-it-wrapper").hover(function () {
		$(this).find(".pin-it").css("display", "block");
		$(this).find("img[alt!='Pin It!']").css({"opacity": "0.25", "filter": "alpha(opacity=25)"});
	}, function () {
		$(this).find(".pin-it").css("display", "none");
		$(this).find("img[alt!='Pin It!']").css({"opacity": "1", "filter": "alpha(opacity=100"});
	});
	$(".pin-it").click(function (event) {
		event.preventDefault();
		winTop = window.outerHeight / 2 - 144;
		winLeft = window.outerWidth / 2 - 375;
		window.open(($(this).attr("href")), '_blank', 'top=' + winTop + ',left=' + winLeft + ',width=750,height=288,location=no,menubar=no,scrollbars=no,status=no,toolbar=no');
	});
});