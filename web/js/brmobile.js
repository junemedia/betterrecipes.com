debug = function (log_txt) {
    if (window.console != undefined) {
        console.log(log_txt);
    }
}


var page = {};
page.track = function(vars) {
    if (typeof s === 'undefined' || typeof vars !== 'object') return;
    var backup = {}, i, out;
    for (i in vars) {
        backup[i] = s[i];
        s[i] = vars[i];
    }
    out = s.t();
    if (out) $(out).appendTo('body');
    for (i in backup) s[i] = backup[i];
}


function renderUI(res) {  
    var connected = (res.user != null && res.user.isConnected); 
    if ( $('#btnGetContacts').length > 0 ) { 
    	document.getElementById('btnGetContacts').disabled = !connected;  
    }
    if ( $('#btnGetFriends').length > 0 ) { 
    	document.getElementById('btnGetFriends').disabled = !connected;  
    }
} 

function getContacts_callback(response) {  
    document.getElementById('btnGetContacts').disabled = false;  
    if (response.errorCode == 0) { 
    
        var array = response.contacts.asArray();  
        for (var i = 0; i < array.length; i++) {  
        	//list.add(new Option(array[i].firstName + " " + array[i].lastName, array[i].email));
        	$("#groupcreatetwo_contacts").append('<option value="'+array[i].email+'">'+array[i].email+'</option>');
        }
        $("#groupcreatetwo_contacts").multiselect('refresh');
        $("#groupcreatetwo_contacts").multiselect({autoOpen: true});
        
    } else {  
        alert('Error :' + response.errorMessage);  
    }  
}  

function getFriends_callback(response) {  
    document.getElementById('btnGetFriends').disabled = false;  
    if (response.errorCode == 0) { 
    	var array = response.friends.asArray();  
        for (var i = 0; i < array.length; i++) {  
        	//debug('email '+array[i].email+' name '+array[i].firstName+" "+array[i].lastName);
        	$("#groupcreatetwo_fb_friends").append('<option value="'+array[i].email+'">'+array[i].firstName+" "+array[i].lastName+'</option>');
        }
        $("#groupcreatetwo_fb_friends").multiselect('refresh');
        $("#groupcreatetwo_fb_friends").multiselect({autoOpen: true});
    } else {  
        alert('Error :' + response.errorMessage);  
    }  
}  


var brmb = {
    user: {
        interval: null,
        onSessionExpired: function() {
            window.clearInterval(User.interval);
            if (confirm('You session has expired, would you like to signin again?')) {
                document.location.href = '/signin?referrer=' + escape(document.location.href);
            } else {
                document.location.reload();
            }
        },
        updateMessageCount: function() {
            if ($('.my-new-message-count').length) {
                $.ajax({
                    url: '/messages/count',
                    success: function(data) {
                        if (data == 'login') {
                            User.onSessionExpired();
                        } else if (data > 0) {
                            $('.my-new-message-count').addClass('highlight').text(data);
                        } else {
                            $('.my-new-message-count').removeClass('highlight').text(0);
                        }
                    }
                });
            }
        },
        init: function() {
            //this.updateMessageCount();
            //this.interval = window.setInterval(this.updateMessageCount, 30000);
        }
    },
    gigya: {
        conf: {
            APIKey: null // set by layout
        },
        params: {
            userAction: null
            , shareButtons: [
                {
                    provider: 'facebook-like'
                }
								/*
                , {
                    provider: 'google-plusone'
                }
								*/
                , {
                    provider: 'share'
                    , enableCount: false
										/*, iconImgUp: '/img/m/btn-share.png'*/
                }
								/*
                , {
                    provider: 'share'
                    , iconImgUp: '/img/facebook.png'
                    , enableCount: false
                    , iconOnly: true
                }
                , {
                    provider: 'Twitter'
                    , iconImgUp: '/img/twitter.png'
                    , enableCount: false
                    , iconOnly: true
                }
								*/
                , {
                    provider: 'email'
                    /*, iconImgUp: '/img/m/btn-email.png'*/
                    , enableCount: false
                    /*, iconOnly: true*/
                }
            ]
            , containerID: 'inlinesharebar'
            , operationMode:'multiSelect'
            , noButtonBorders: true
						, layout:'vertical'
						, showCounts:'right'  
        },
        ua: null,
        defaults: {
            url: function() {
                return document.location.href;
            },
            title: function() {
                var str = $('.title').length != 0 ? $($('.title')[0]).text() : '';
                return str.length ? str : 'Better Recipes';
            },
            desc: function() {
                var str = $(".summary").length != 0 ? $($(".summary")[0]).text() : '';
                return str.length ? str : 'An online cookbook of recipes for any meal. Browse recipes by topic or search to find the perfect recipe at Better Recipes. Become a member to upload�';
            },
            target: 'inlinesharebar'
        },
        sharebar: function (args) {
      
            // invoke and assign the userAction object
            brmb.gigya.ua = brmb.gigya.params.userAction = new gigya.services.socialize.UserAction()
            // defaults
            brmb.gigya.params.containerID = brmb.gigya.defaults.target;
            //brmb.gigya.params.operationMode = 'simpleShare';
            var url = brmb.gigya.defaults.url();
            var title = brmb.gigya.defaults.title();
            var desc = brmb.gigya.defaults.desc();


            if (typeof args == 'object') {
                // override defaults:
                if (typeof args.conf == 'object') {
                    $.extend(brmb.gigya.conf, args.conf);
                }
                if (typeof args.params == 'object') {
                    $.extend(brmb.gigya.params, args.params);
                }
                if (typeof args.url != 'undefined') url = args.url;
                if (typeof args.title != 'undefined') title = args.title;
                if (typeof args.desc != 'undefined') desc = args.desc;
                if (typeof args.target != 'undefined') brmb.gigya.params.containerID = args.target;
            }
            brmb.gigya.ua.setLinkBack(url);
            brmb.gigya.ua.setTitle(title);
            brmb.gigya.ua.setDescription(desc);
            gigya.services.socialize.showShareBarUI(brmb.gigya.conf,brmb.gigya.params);
        },
        getContacts: function() {
        	gigya.services.socialize.getContacts(brmb.gigya.conf, { callback: getContacts_callback }); 
        	document.getElementById('btnGetContacts').disabled = true;
        },
        getFriends: function() {
        	var getFriendsParams = {  detailLevel:'extended', callback:getFriends_callback  };  
        	gigya.services.socialize.getFriendsInfo(brmb.gigya.conf, getFriendsParams); 
        	document.getElementById('btnGetFriends').disabled = true;
        },
        showConnectionsUI: function() {
        	// show 'Add Connections' Plugin in "divConnect" 
        	gigya.services.socialize.showAddConnectionsUI(brmb.gigya.conf, {   
	            height:65  
	            ,width:120  
	            ,showTermsLink:false // remove 'Terms' link  
	            ,hideGigyaLink:true // remove 'Gigya' link  
	            ,requiredCapabilities: "Contacts" // we want to show only providers that support retrieving contacts.  
	            ,containerID: "divConnect" // The component will embed itself inside the divConnect Div   
	        });  
        },
        showFriendsUI: function() {
        	// show 'Friends' Plugin in "divConnectFb" 
        	gigya.services.socialize.showAddConnectionsUI(brmb.gigya.conf, {   
	            height:65  
	            ,width:120  
	            ,showTermsLink:false // remove 'Terms' link  
	            ,hideGigyaLink:true // remove 'Gigya' link 
	            , enabledProviders: 'facebook' 
	            ,containerID: "divConnectFb" // The component will embed itself inside the divConnectFb Div   
	        });  
        },
        init: function() {
            if ($('#gigya-auth').length) {
                gigya.services.socialize.showLoginUI(brmb.gigya.conf, {
                    containerID: "gigya-auth"
                    , cid: ''
                    , width: 320
                    , height: 86
                    , showWhatsThis: false
                    , buttonsStyle: 'fullLogo'
                    , redirectURL: 'http://' + document.domain + '/auth/socialize'
                    , showTermsLink: false
                    , hideGigyaLink: true // remove 'Terms' and 'Gigya' links
                });
            }
            // get user info  
            gigya.services.socialize.getUserInfo(brmb.gigya.conf, { callback: renderUI });  
            // register for connect status changes  
            gigya.services.socialize.addEventHandlers(brmb.gigya.conf, { onConnectionAdded: renderUI, onConnectionRemoved: renderUI }); 
        }
    },
    tabs: {
      swap: function (e) {
        var target = $(e.target).attr('href').substr(1);
        $(e.target).parent().siblings().each(
          function() {
            $(this).removeClass('active');
            var t = $(this).find('a').attr('href').substr(1);
            $('#'+t).hide();
          }
        );
        $('#'+target).show();
        $(e.target).parent().addClass('active');
        return false;
      },
      init: function() {
        $('.tabbednav span a').each(
          function() {
            if ($(this).attr('href').indexOf('#') == 0) {
              $(this).click(brmb.tabs.swap);
            }
          }
        );
      }
    },
    init: function() {
        this.user.init();
        this.gigya.init();
        this.tabs.init();
    }
};


jQuery(document).ready(function($){
	
	brmb.init();
	// BEGIN: custom selectbox
	$("select#jumpbox-select").selectBox();
	// END: custom selectbox
	
	// BEGIN: limit copy to 100 characters
		if( $(".limitcopy-100 span").html() ){
			var all_comments100 = [];
			$(".limitcopy-100 span").each(function(index) {
				$(this).addClass('comment' + [index]);
				all_comments100.push($(this).text());
				if( $(this).html().length > 100){
					$(this).html( $(this).html().substr(0, 100) );
					$(this).siblings("#toggle-copy").css({"display":"inline-block"}).html("  ...Read More").addClass("click_to_open");
				}
			});
		}
		$(".limitcopy-100 #toggle-copy").click(function(){
			if($(this).hasClass("click_to_open")){
				var array_placement = $(this).siblings("span").attr('class').substring(7,8);
				console.log(array_placement);
				$(this).siblings("span").html(all_comments100[array_placement]);
				$(this).removeClass("click_to_open").addClass("click_to_close").html("  ...Minimize");
			} else {
				$(this).siblings("span").html( $(this).siblings("span").html().substr(0, 100));
				$(this).removeClass("click_to_close").addClass("click_to_open").html("  ...Read More");
			}
		});
	// END: limit copy to 100 characters
	
	// jumpbox menu controls
	/*
	$('#jumpbox-input').click(function(){
		$(this).hide();
		$('#jumpbox-button').hide();
		$('#jumpbox-select').show();
		$('#jumpbox-select').change(function(e) {
			$('#jumpbox-input').val( this.options[this.selectedIndex].text );
			$(this).hide();
			$('#jumpbox-input').show();
			$('#jumpbox-button').show();
		});
	});
	$('#jumpbox-button').click(function(){
		if( $('#jumpbox-select option:selected').val() != '' ) {
			window.location.href = $('#jumpbox-select option:selected').val();
		}
	});
	*/
	// jumpbox (within a group) controls
	/*
	if ( $('#group-jumpbox').length > 0 ) {
		/*
		$('#group-jumpbox-input').click(function(){
			$(this).hide();
			$('#group-jumpbox-button').hide();
			$('#group-jumpbox-select').show();
			$('#group-jumpbox-select').change(function(e) {
				$('#group-jumpbox-input').val( this.options[this.selectedIndex].text );
				$(this).hide();
				$('#group-jumpbox-input').show();
				$('#group-jumpbox-button').show();
			});
		});
		*/
		/*
		$('#group-jumpbox-button').click(function(){
			if( $('#group-jumpbox-select option:selected').val() != '' ) {
				window.location.href = $('#group-jumpbox-select option:selected').val();
			}
		});
	}
	$('#resolution').text("HEIGHT: " + $(window).height() + " | WIDTH: " + $(window).width() );
	*/
}); // END: doc.ready


function addcomment(path) {
	/* if we use the the WYSIWYG we need to grab the user's HTML input and manually set the textarea prior to running jquery post */
	/*if ( $('#addComment textarea').hasClass('wym-editor') ) {
		$('#addComment textarea').val(CKEDITOR.instances.userComment.getData());
	}*/
	$.post( 
			path, 
			$('#addComment').serialize(), 
			function(data) {
								if ($('#userCommentRave').length>0) {
									$('#userCommentRave').val('');
								}
								$('#message').html(data.message);
								$('#message').show();
								/* if using WYSIWYG, clear the textarea */
								if ( $('#addComment textarea').hasClass('wym-editor') ) {
									$('#addComment textarea').val('');
								}
								window.location = window.location.href.replace( /#.*/, "");
							}, 
	"json" );
}


function ajaxPaginateMembers(obj, path, page, slug, cat) {
	s.pageName=s.eVar9='Groups:'+cat+':'+$('#displayTitle').text()+':members:'+page;
	s.t();
	$.post(
			path,
			{page: page, slug: slug, cat: cat},
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
	//refreshAdtags();
}

function ajaxPaginateDiscussionsGroup(obj, path, page, slug) {
	s.pageName=s.eVar9='Discussions:Groups:Main:'+$('#displayTitle').text()+':'+page;
	s.t();
	//refreshAdtags();
	$.post(
			path,
			{page: page, slug: slug},
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}

function ajaxPaginateDiscussionsDetails(obj, path, page, slug, thread_id) {
	s.pageName=s.eVar9='Discussions:Groups:Detail:'+$('#displayTitle').text()+':'+page;
	s.t();
	//refreshAdtags();
	$.post(
			path,
			{page: page, slug: slug, thread_id: thread_id},
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}

function ajaxPaginateRecipes(obj, path, page, slug, cat, sort) {
	s.pageName=s.eVar9='Groups:'+cat+':'+$('#displayTitle').text()+':recipes:'+page;
	s.t();
	//refreshAdtags();
	$.post(
			path,
			{page: page, slug: slug, cat: cat, sort: sort},
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}

function ajaxPaginateRecipesSort(obj, path, page, slug, cat, sort) {
	s.pageName=s.eVar9='Groups:'+cat+':'+$('#displayTitle').text()+':recipes:'+page;
	s.t();
	//refreshAdtags();
	
	$.post(
			path,
			{page: page, slug: slug, cat: cat, sort: sort},
			function(data) {
								$(obj + ' ul').replaceWith('<ul class="divider">'+data+'</ul>');
						   }
		  );
	$(obj + ' .tabbednav').children().toggleClass('active');
}

function ajaxPaginatePhotosSort(obj, path, page, slug, sort) {
	s.pageName=s.eVar9='Photos:Groups:'+$('#displayTitle').text()+':'+page;
	s.t();
	//refreshAdtags();
	$.post(
			path,
			{page: page, slug: slug, sort: sort},
			function(data) {
								$(obj + ' ul').replaceWith('<ul>'+data+'</ul>');
						   }
		  );
}

function ajaxPaginatePhotosGroups(obj, path, page, slug, sort) {
	s.pageName=s.eVar9='Photos:Groups:'+$('#displayTitle').text()+':'+page;
	s.t();
	//refreshAdtags();
	$.post(
			path,
			{page: page, slug: slug, sort: sort},
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}


function ajaxPaginateVideosSort(obj, path, page, slug, sort) {
	s.pageName=s.eVar9='Videos:Groups:'+$('#displayTitle').text()+':'+page;
	s.t();
	//refreshAdtags();
	$.post(
			path,
			{page: page, slug: slug, sort: sort},
			function(data) {
								$(obj + ' ul').replaceWith('<ul>'+data+'</ul>');
						   }
		  );
}


function ajaxPaginateVideosGroups(obj, path, page, slug, sort) {
	s.pageName=s.eVar9='Videos:Groups:'+$('#displayTitle').text()+':'+page;
	s.t();
	//refreshAdtags();
	$.post(
			path,
			{page: page, slug: slug, sort: sort},
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}



function ajaxPaginatePollsGroups(obj, path, page, poll_blog) {
	s.pageName=s.eVar9='Polls:Groups:'+$('#displayTitle').text()+':'+page;
	s.t();
	//refreshAdtags();
	$.post(
			path,
			{page: page, poll_blog: poll_blog},
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}


function ajaxPaginateJournals(obj, path, page) {
	s.pageName=s.eVar9='Category:Journals:'+page;
	s.t();
	//refreshAdtags();
	$.post(
			path,
			{page: page},
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}

function ajaxPaginateDiscussions(obj, path, page) {
	s.pageName=s.eVar9='Category:Discussions:'+page;
	s.t();
	//refreshAdtags();
	$.post(
			path,
			{page: page},
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}

function ajaxPaginatePhotos(obj, path, page) {
	s.pageName=s.eVar9='Category:Photo:'+page;
	s.t();
	//refreshAdtags();
	$.post(
			path,
			{page: page},
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}

function ajaxPaginateVideos(obj, path, page) {
	s.pageName=s.eVar9='Category:Video:'+page;
	s.t();
	//refreshAdtags();
	$.post(
			path,
			{page: page},
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}


function ajaxPaginatePolls(obj, path, page) {
	//refreshAdtags();
	s.pageName=s.eVar9='Category:Polls:'+page;
	s.t();
	$.post(
			path,
			{page: page},
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}

function ajaxPaginateSearch(obj, path, page, term, pagetype, rating, category, subcategory, _with, without, type, attrsort) {
	//refreshAdtags();
	s.PageName='Search:Results:'+page;
	s.eVar9='Search:Results:'+page;
	s.t();
	$.post(
			path,
			{ page: page, term: term, pagetype: pagetype, rating: rating, category: category, subcategory: subcategory, _with: _with, without: without, type: type, attrSort: attrsort },
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}

function ajaxPaginateSaved(obj, path, page_no) {
	//$(obj).load(path, {page: page} );
	//refreshAdtags();
	$.post(
			path,
			{ page_no: page_no },
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}

function ajaxPaginatePersonal(obj, path, page_no) {
	//$(obj).load(path, {page: page} );
	//refreshAdtags();
	$.post(
			path,
			{ page_no: page_no },
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}

function deleteSavedRecipe(obj, path, recipe) {
	var r=confirm("Are you sure you want to delete this recipe from your recipe box?");
	if (r==true) {
	  $.post(
	  			path, 
	  			{ recipe: recipe}, 
	  			function(data) { 
	  				//debug(data);
	  				if (data.status == '1') {
	  					if (data.count <= 6) {
	  						// remove the pagination link (if it exists)
	  						$(obj).parent().parent().find('.pagination').remove();
	  					}
	  					$(obj).parent().remove();
	  				}
	  			}	
	  		), "json";
	}
}


function ajaxPaginateContestants(obj, path, page, contestId) {
	//$(obj).load(path, {page: page} );
	//refreshAdtags();
	$.post(
			path,
			{ page: page, contestId: contestId },
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}

function ajaxPaginatePastContests(obj, path, page) {
	//$(obj).load(path, {page: page} );
	//refreshAdtags();
	$.post(
			path,
			{ page: page },
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}

function ajaxPaginatePastWinners(obj, path, page) {
	//$(obj).load(path, {page: page} );
	//refreshAdtags();
	$.post(
			path,
			{ page: page },
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}


function ajaxPaginateUserRecipes(obj, path, page, userId) {
	//$(obj).load(path, {page: page} );
	//refreshAdtags();
	$.post(
			path,
			{ page: page, userId: userId },
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}

function ajaxPaginateUserDiscussions(obj, path, page, userId) {
	//$(obj).load(path, {page: page} );
	//refreshAdtags();
	$.post(
			path,
			{ page: page, userId: userId },
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}

function ajaxPaginateUserPhotos(obj, path, page, userId) {
	//$(obj).load(path, {page: page} );
	//refreshAdtags();
	$.post(
			path,
			{ page: page, userId: userId },
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}

function ajaxPaginateUserVideos(obj, path, page, userId) {
	//$(obj).load(path, {page: page} );
	//refreshAdtags();
	$.post(
			path,
			{ page: page, userId: userId },
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}

function ajaxPaginateUserJournals(obj, path, page, userId) {
	//$(obj).load(path, {page: page} );
	//refreshAdtags();
	$.post(
			path,
			{ page: page, userId: userId },
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}

function ajaxPaginateUserPolls(obj, path, page, userId) {
	//$(obj).load(path, {page: page} );
	//refreshAdtags();
	$.post(
			path,
			{ page: page, userId: userId },
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}

function ajaxPaginateUserGroups(obj, path, page, userId) {
	//$(obj).load(path, {page: page} );
	//refreshAdtags();
	$.post(
			path,
			{ page: page, userId: userId },
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}


function ajaxPaginateUserFriends(obj, path, page, userId) {
	//$(obj).load(path, {page: page} );
	//refreshAdtags();
	$.post(
			path,
			{ page: page, userId: userId },
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}

function ajaxPaginateUserRaves(obj, path, page, content_id) {
	//$(obj).load(path, {page: page} );
	//refreshAdtags();
	$.post(
			path,
			{ page: page, content_id: content_id },
			function(data) {
								$(obj + ' ul li.pagination').hide();
								$(obj + ' ul').append(data);
						   }
		  );
}



function ajaxPaginateComments(path, page, contentId) {
	//refreshAdtags();
	$.post(
			path,
			{page: page, contentId: contentId},
			function(data) {
								$('#comments ul li.pagination').hide();
								$('#comments ul').append(data);
						   }
		  );
}


function erinVote(path, obj, poll_id) {
	if (!$("input[@name='vote-option']:checked").val()) {
		alert('Please select an option to vote for');
	} else {
		//s.PageName='Polls:Detail:Voted';
		//s.eVar9='Polls:Detail:Voted';
		//s.t();
		$(obj).load(path, {poll_id: poll_id, option_id: $("input[@name='vote-option']:checked").val()} );
	}
}

function saveRecipe(obj, path, id) {
	$(obj).parent().load(path, {id: id} );
}

function clearText(field){
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}

function recipeVoteOmniture() {
    s.pageName=s.eVar9= s.pageName + ':voted'; 
}

function fireOmniture() {
    s.t();
}

