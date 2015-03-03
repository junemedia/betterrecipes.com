//console.log("ramp-scripts loaded");
jQuery(function($) {
	"use strict";
	//console.log("ramp-scripts fired");
	var settings = {
		videoModal: null,
		videoPlayer: $(".videoPlayer"),
		modalWidth: 1016,
		modalHeight: 645,
		responsiveFlag: false,
		clickEventType: 'click',
		autoInit: true
	};
	$("body").append("<div id='videoModal'></div>");
	settings.videoModal = $("#videoModal");
	var _self = this;
    this.getWidth = function(){
        var width = (window.innerWidth !== undefined && window.innerWidth < settings.modalWidth) ? window.innerWidth - 50 : settings.modalWidth;
        return width;
    };
    this.getHeight = function(){
        var height = (window.innerWidth !== undefined && window.innerHeight > window.innerWidth-100) ? window.innerHeight - 100 : settings.modalHeight;
        return height;
    };
    this.getLibraries = function( cb ){
        var head = $('head');
        if($('link[href*="jquery-ui-recipecom"]').length === 0){
            $("<link>").appendTo(head).attr({type : 'text/css', rel : 'stylesheet'}).attr('href', 'http://www.parents.com/web/css-min/js/mdp/lib/jquery/ui/jquery-ui-recipecom.css');
        }
        if (typeof jQuery.ui == 'undefined') {
            $.ajax({
                url: "http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js",
                dataType: "script",
                success: function(){
                    cb();
                }
            });
        } else {
            cb();
        }
    };
    this.init = function() {
        if(settings.videoPlayer.length > 0){
            _self.getLibraries(function(){
                if( !settings.videoModal ){
                    $("body").append("<div id='videoModal'></div>");
                    settings.videoModal = $("#videoModal");
                }
                settings.videoModal.dialog({
                    autoOpen:false,
                    modal:true,
                    resizable:false,
                    draggable:false,
                    width: (settings.responsiveFlag) ? _self.getWidth() : settings.modalWidth,
                    height: 'auto',
                    close: function() {
                        settings.videoModal.empty();
                    }
                });
                settings.videoPlayer.each(function(){
					var thisItem = $(this),
                        thisTitle = thisItem.find(".videoTitle"),
                        titleText = thisTitle.find("a").text();
                    thisTitle.html(titleText);
                    if( thisItem.hasClass('singleVideo')) {
                        thisItem.bind(settings.clickEventType, function(){
                            var clickItem = $(this);
                            clickItem.html('<iframe src="'+$(this).data('videoembedurl')+'&width='+clickItem.width()+'&height='+clickItem.height()+'&playerType=embed" width="'+clickItem.width()+'" height="'+clickItem.height()+'" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" allowfullscreen="allowfullscreen"></iframe>');
                        });
                    } else {
                        thisItem.bind(settings.clickEventType, function() {
                            var clickItem = $(this),
                                iframeWidth = (settings.responsiveFlag) ? _self.getWidth() : settings.modalWidth,
                                iframeHeight = (settings.responsiveFlag) ? _self.getHeight() : settings.modalHeight;
							var d = settings.videoModal.html('<iframe width="' + iframeWidth + '" height="' +
								iframeHeight + '" scrolling="no" src="' + clickItem.data('videoembedurl') +
								'&playerType=overlay&metaq=true" frameborder="0" allowfullscreen></iframe>');
                            d.dialog("option", "title", clickItem.data("videotitle")).dialog("open");
                        });
                    }
                });
            });
        }
    };
    if(settings.autoInit){
		_self.init();
	}
	//console.log("ramp-scripts completed");
});