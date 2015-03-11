/*
window.Meebo||function(c){
  function p(){
    return["<",i,' onload="var d=',g,";d.getElementsByTagName('head')[0].",j,"(d.",h,"('script')).",k,"='//cim.meebo.com/cim?iv=",a.v,"&",q,"=",c[q],c[l]?"&"+l+"="+c[l]:"",c[e]?"&"+e+"="+c[e]:"","'\"></",i,">"].join("")
  }
  var f=window,a=f.Meebo=f.Meebo||function(){
    (a._=a._||[]).push(arguments)
  },d=document,i="body",m=d[i],r;
  if(!m){
    r=arguments.callee;
    return setTimeout(function(){
      r(c)
    },100)
  }
  a.$={
    0:+new Date
  };
    
  a.T=function(u){
    a.$[u]=new Date-a.$[0]
  };
    
  a.v=5;
  var j="appendChild",h="createElement",k="src",l="lang",q="network",e="domain",n=d[h]("div"),v=n[j](d[h]("m")),b=d[h]("iframe"),g="document",o,s=function(){
    a.T("load");
    a("load")
  };
    
  f.addEventListener?f.addEventListener("load",s,false):f.attachEvent("onload",s);
  n.style.display="none";
  m.insertBefore(n,m.firstChild).id="meebo";
  b.frameBorder="0";
  b.name=b.id="meebo-iframe";
  b.allowTransparency="true";
  v[j](b);
  try{
    b.contentWindow[g].open()
  }catch(w){
    c[e]=d[e];
    o="javascript:var d="+g+".open();d.domain='"+d.domain+"';";
    b[k]=o+"void(0);"
  }
  try{
    var t=b.contentWindow[g];
    t.write(p());
    t.close()
  }catch(x){
    b[k]=o+'d.write("'+p().replace(/"/g,'\\"')+'");d.close();'
  }
  a.T(1)
}({
  network:"meredith:betterrecipes"
});
*/

debug = function (log_txt) {
  if (window.console != undefined) {
    console.log(log_txt);
  }
}

function initCKEditor(obj) {
  CKEDITOR.config.scayt_autoStartup = true,
  CKEDITOR.replace( obj,
  {
    on :
    {
      instanceReady : function( ev )
      {
        this.dataProcessor.writer.setRules( 'li',
        {
          indent : false,
          breakBeforeOpen : false,
          breakAfterOpen : false,
          breakBeforeClose : false,
          breakAfterClose :false
        });
        this.dataProcessor.writer.setRules( 'ul',
        {
          indent : false,
          breakBeforeOpen : false,
          breakAfterOpen : false,
          breakBeforeClose : false,
          breakAfterClose :false
        });
        this.dataProcessor.writer.setRules( 'ol',
        {
          indent : false,
          breakBeforeOpen : false,
          breakAfterOpen : false,
          breakBeforeClose : false,
          breakAfterClose :false
        });
        this.dataProcessor.writer.setRules( 'p',
        {
          indent : false,
          breakBeforeOpen : false,
          breakAfterOpen : false,
          breakBeforeClose : false,
          breakAfterClose :false
        });
      }
    },
		        
    height: '300px',
    toolbar :
    [
    {
      name: 'basicstyles', 
      items : [  'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat'  ]
    },
    {
      name: 'paragraph', 
      items : [ 'NumberedList','BulletedList','-','Outdent','Indent' ]
    },
    {
      name: 'links', 
      items : [  'Link','Unlink' ]
    },
    {
      name: 'insert', 
      items : [ 'Image','Smiley','SpecialChar' ]
    },
    {
      name: 'clipboard', 
      items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ]
    },
    {
      name: 'styles', 
      items : [ 'Format','FontSize' ]
    },
    {
      name: 'colors', 
      items : [ 'TextColor' ]
    },
    {
      name: 'spellchecker', 
      items : ['Scayt']
    }
    ]
		        
  });
  CKFinder.setupCKEditor( null, '/ckfinder/' ) ;	
        	
  CKEDITOR.on( 'dialogDefinition', function( ev )
  {
    // Take the dialog name and its definition from the event data.
    var dialogName = ev.data.name;
    var dialogDefinition = ev.data.definition;
    if ( dialogName == 'image' )
    {
      // FCKConfig.ImageDlgHideAdvanced = true	
      dialogDefinition.removeContents( 'advanced' );
      // FCKConfig.ImageDlgHideLink = true
      dialogDefinition.removeContents( 'Link' );
      var infoTab = dialogDefinition.getContents( 'info' );
      infoTab.remove( 'browse' );
					
      dialogDefinition.onLoad = function () {
        // This code will open the Upload tab.
        this.selectPage('Upload');
        $('#cke_102_label').html('Upload Image');
      };
    }
				
    if ( dialogName == 'link' )
    {
      // Get a reference to the "Link Info" tab.
      var infoTab = dialogDefinition.getContents( 'info' );
      dialogDefinition.removeContents( 'advanced' );
      dialogDefinition.removeContents( 'upload' );
      infoTab.remove( 'browse' );
    }
  });	
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
    $("#groupcreatetwo_contacts").multiselect({
      autoOpen: true
    });
        
  } else {  
    alert('Error :' + response.errorMessage);  
  }  
}  

function getFriends_callback(response) {  
  document.getElementById('btnGetFriends').disabled = false;  
  if (response.errorCode == 0) { 
    var array = response.friends.asArray();  
    for (var i = 0; i < array.length; i++) {  
      debug('email '+array[i].email+' name '+array[i].firstName+" "+array[i].lastName);
      $("#groupcreatetwo_fb_friends").append('<option value="'+array[i].email+'">'+array[i].firstName+" "+array[i].lastName+'</option>');
    }
    $("#groupcreatetwo_fb_friends").multiselect('refresh');
    $("#groupcreatetwo_fb_friends").multiselect({
      autoOpen: true
    });
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
      this.updateMessageCount();
      this.interval = window.setInterval(this.updateMessageCount, 30000);
    }
  },
  gigya: {
    conf: {
      APIKey: null // set by layout
    // BEGIN: FROM ET#5787
    /*
						,enabledProviders: 'facebook,twitter,yahoo'
       */
    // END: FROM ET#5787
    },
    params: {
      userAction: null
      , 
      shareButtons: [
      {
        provider: 'facebook-like',
        enableCount: true
      }
      //Note this image is CSS hidden and we use our own image, if this order is changed, the CSS must change.
      /*, {
        provider: 'pinterest',
        enableCount: true,
      }*/
      , {
        provider: 'twitter-tweet'
      }
      ,{
        provider: 'google-plusone',
        enableCount: true,
      }
      ,{
        provider: 'share', 
        enableCount: false
      }
      //Note this is CSS display none and the email A link is used ot click this.
      ,{
        provider: 'email'
      }
      /*, {
        provider: 'share'
        , 
        iconImgUp: '/img/facebook.png'
        , 
        enableCount: false
        , 
        iconOnly: true
      }
      , {
        provider: 'email'
        , 
        iconImgUp: '/img/email.png'
        , 
        enableCount: false
        , 
        iconOnly: true
      }*/
      ]
      , 
      containerID: 'inlinesharebar'
      , 
      operationMode:'multiSelect'
      , 
      shortURLs: 'whenRequired'
      ,
      noButtonBorders: true
    // BEGIN: FROM ET#5787
    /*
						,showTermsLink: 'false'
						,height: 85
						,width: 330
						,buttonsStyle: 'fullLogo'
						,autoDetectUserProviders: 'facebook'
						,facepilePosition: 'top'
       */
    // END: FROM ET#5787
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
        return str.length ? str : 'An online cookbook of recipes for any meal. Browse recipes by topic or search to find the perfect recipe at Better Recipes. Become a member to upload…';
      },
      img: function() {
	    	if ( $('.images .main-image img').length > 0 ) {
		    	var img = { type: 'image', src: 'http://' + window.location.hostname + $('.images .main-image img').attr('src') }
	    	}  else {
		    	var img = { type: 'image', src: 'http://' + window.location.hostname + '/img/logo-betterrecipes.png' }
	    	}
	    	return img;
      },
      target: 'inlinesharebar'
    },
    sharebar: function (args) {
      
      // invoke and assign the userAction object
      brmb.gigya.ua = brmb.gigya.params.userAction = new gigya.services.socialize.UserAction()
      // defaults
      brmb.gigya.params.containerID = brmb.gigya.defaults.target;
      var url = brmb.gigya.defaults.url();
      var title = brmb.gigya.defaults.title();
      var desc = brmb.gigya.defaults.desc();
      var img = brmb.gigya.defaults.img();


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
        if (typeof args.img != 'undefined') img = args.img;
      }
      brmb.gigya.ua.setLinkBack(url);
      brmb.gigya.ua.setTitle(title);
      brmb.gigya.ua.setDescription(desc);
      brmb.gigya.ua.addMediaItem(img);
      gigya.services.socialize.showShareBarUI(brmb.gigya.conf,brmb.gigya.params);
    },
    getContacts: function() {
      gigya.services.socialize.getContacts(brmb.gigya.conf, {
        callback: getContacts_callback
      }); 
      document.getElementById('btnGetContacts').disabled = true;
    },
    getFriends: function() {
      var getFriendsParams = {
        detailLevel:'extended', 
        callback:getFriends_callback
      };  
      gigya.services.socialize.getFriendsInfo(brmb.gigya.conf, getFriendsParams); 
      document.getElementById('btnGetFriends').disabled = true;
    },
    showConnectionsUI: function() {
      // show 'Add Connections' Plugin in "divConnect" 
      gigya.services.socialize.showAddConnectionsUI(brmb.gigya.conf, {   
        height:65  
        ,
        width:120  
        ,
        showTermsLink:false // remove 'Terms' link  
        ,
        hideGigyaLink:true // remove 'Gigya' link  
        ,
        requiredCapabilities: "Contacts" // we want to show only providers that support retrieving contacts.  
        ,
        containerID: "divConnect" // The component will embed itself inside the divConnect Div   
      });  
    },
    showFriendsUI: function() {
      // show 'Friends' Plugin in "divConnectFb" 
      gigya.services.socialize.showAddConnectionsUI(brmb.gigya.conf, {   
        height:65  
        ,
        width:120  
        ,
        showTermsLink:false // remove 'Terms' link  
        ,
        hideGigyaLink:true // remove 'Gigya' link 
        , 
        enabledProviders: 'facebook' 
        ,
        containerID: "divConnectFb" // The component will embed itself inside the divConnectFb Div   
      });  
    },
    init: function() {
      if ( $('#gigya-auth.signin-page').length > 0 ) {
        gigya.services.socialize.showLoginUI(brmb.gigya.conf, {
          containerID: "gigya-auth", 
          cid: '', 
          width: 212, 
          height: 30, 
          showWhatsThis: false, 
          buttonsStyle: 'signInWith', 
          redirectURL: 'http://' + document.domain + '/auth/socialize', 
          showTermsLink: false, 
          hideGigyaLink: true, // remove 'Terms' and 'Gigya' links
          siteName: 'betterrecipes.com',
          enabledProviders: 'facebook'
        });
      } else if ( $('#gigya-auth').length > 0 ) {
        gigya.services.socialize.showLoginUI(brmb.gigya.conf, {
          containerID: "gigya-auth", 
          cid: '', 
          width: 360, 
          height: 86, 
          showWhatsThis: false, 
          buttonsStyle: 'signInWith', 
          redirectURL: 'http://' + document.domain + '/auth/socialize', 
          showTermsLink: false, 
          hideGigyaLink: true, // remove 'Terms' and 'Gigya' links
          siteName: 'betterrecipes.com',
          enabledProviders: 'facebook'
        });
      } 
      // get user info  
      gigya.services.socialize.getUserInfo(brmb.gigya.conf, {
        callback: renderUI
      });  
      // register for connect status changes  
      gigya.services.socialize.addEventHandlers(brmb.gigya.conf, {
        onConnectionAdded: renderUI, 
        onConnectionRemoved: renderUI
      }); 
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
      $('.tabbednav li a').each(
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
/*
var brmb_panel_rotate_interrupt = false;
var brmb_panel_rotate = function () {
  if (brmb_panel_rotate_interrupt) {
    return false;
  }
  var anchor = $("#gallery ul li a.current").length ? $("#gallery ul li a.current") : $("#gallery ul li:first-child a");

  if (anchor.length < 1) {
    return false;
  }

  // var slide_count = $("#gallery ul").children().length;
  var next_slide = anchor.parent().next().find('a');
  if (next_slide.length < 1) {
    next_slide = $("#gallery ul li:first-child a");
  }
  var next_marker_offset = next_slide.position().top;
  var index = parseInt(next_slide.attr('index'));
  next_slide.addClass('current');
  anchor.removeClass('current');
  $('#gallery .picture .picts').animate(
    {
      'left': '-'+(300*index).toString()+'px'
    },
    500
  );
  $('#gallery .marker').animate(
    {
      'top':(next_marker_offset-10).toString()+'px'
    },
    250
  );

  setTimeout(brmb_panel_rotate,3000);
}
 */

jQuery(document).ready(function($){

  if( $('.blog_post_img img').length > 0 )
  {
    $('.blog_post_img img').lazy({ callback: rd.resize, css: { opacity: '1' } });
  }

  // BEGIN: gallery animation, take 2
  if( $('#gallery .picture .picts').length > 0 ){
    $('#gallery .picture .picts').cycle({ 
      fx:      'scrollHorz', 
      speed:    500, 
      timeout:  4000,
      before: function(){
        $('#gallery ul li a').removeClass("current");
		$('#gallery ul li').removeClass("curr");
        $("#gallery .marker, .featured-gallery .marker").stop();
      },
      after: function(curr, next, opts){
        $("#gallery ul > li:nth-child(" + (opts.currSlide + 1) + ") a").addClass("current");
		$("#gallery ul > li:nth-child(" + (opts.currSlide + 1) + ")").addClass("curr");
        $("#gallery .marker, .featured-gallery .marker").animate({
          "top": opts.currSlide * 48.25 + "px"
        }, 300);
      }
    });
  
    $('#gallery ul > li:nth-child(1) a').mouseenter(function() {
      $('#gallery .picture .picts').cycle('pause'); 
      $('#gallery .picture .picts').cycle(0); 
      return false; 
    }); 
    $('#gallery ul > li:nth-child(2) a').mouseenter(function() {
      $('#gallery .picture .picts').cycle('pause'); 
      $('#gallery .picture .picts').cycle(1); 
      return false; 
    }); 
    $('#gallery ul > li:nth-child(3) a').mouseenter(function() {
      $('#gallery .picture .picts').cycle('pause'); 
      $('#gallery .picture .picts').cycle(2); 
      return false; 
    }); 
    $('#gallery ul > li:nth-child(4) a').mouseenter(function() {
      $('#gallery .picture .picts').cycle('pause'); 
      $('#gallery .picture .picts').cycle(3); 
      return false; 
    }); 	 
    $('#gallery ul > li:nth-child(5) a').mouseenter(function() {
      $('#gallery .picture .picts').cycle('pause'); 
      $('#gallery .picture .picts').cycle(4);  
      return false;  
    }); 
    $('#gallery ul li a').mouseleave(function() {
      $('#gallery .picture .picts').cycle('resume');
    }); 
  
  }
  // TERMINATE: gallery animation, take 2
    
  brmb.init();

  /*setTimeout(brmb_panel_rotate,3000);*/
    
  // daily dish modal hack: parse all anchor tags and replace bogus href's with valid img src paths, open them via modal
  // index page level
  if ( $('.dd-list').length > 0 ) {
    $(".dd-list a[rel^='attachment']").each(function() { 
      $(this).attr('rel', 'shadowbox');
      $(this).attr('href', $("img", this).attr("src"));
    });
    // one modal to rule them all, yup, yup
    Shadowbox.init();
  }
	
  // daily dish modal hack: parse all anchor tags and replace bogus href's with valid img src paths, open them via modal
  // detail page level
  if ( $('#dishContents').length > 0 ) {
    $("#dishContents a[rel^='attachment']").each(function() { 
      $(this).attr('rel', 'shadowbox');
      $(this).attr('href', $("img", this).attr("src"));
    });
    // one modal to rule them all, yup, yup
    Shadowbox.init();
  }
		

  if ($('.profile-photo-toggles').length) {
    $('.profile-photo-toggles .profile-photo-toggle').bind('change', function(event) {
      if ($(this).attr('value') == 'choice') {
        $('.profile-photo-upload').slideUp().find('input').attr('value', '');
        $('.profile-photo-choices').slideDown();
      } else {
        $('.profile-photo-upload').slideDown();
        $('.profile-photo-choices').slideUp().find('input').removeAttr('checked');
      }
    });
  }
  // BEGIN: homepage gallery
  /*
    $('#gallery > ul > li a').each(
      function (index,element) {
        $(this).attr('index',index);
        $(this).removeClass('current');
        $(this).hover(
          function(e) {
            brmb_panel_rotate_interrupt = true;
            e.preventDefault();
            var anchor = $(this);
            var index = anchor.attr('index');
            var offsetTop = anchor.position().top;
            // debug('shifting -'+(300*index).toString()+'px');
            // debug('offset '+index+':'+offsetTop);
            $('#gallery .picture .picts').stop(true, true).animate( // I added a stop to this animation (clearQueue = true, jumpToEnd = true)
              {
                'left': '-'+(300*index).toString()+'px'
              },
              150
            );
            $("#gallery ul li a").removeClass("current");
            anchor.addClass("current");
            // debug('adding "current" to '+anchor.text());
            $('#gallery .marker').animate(
              {
                'top':(offsetTop-10).toString()+'px'
              },
              100
            );

            // // old way of animation stacked
            // $('#gallery .picture .picts').animate(
            //   {
            //     'left': '-'+(300*index).toString()+'px'
            //   },
            //   500,
            //   function() {
            //     $("#gallery ul li a").removeClass("current");
            //     anchor.addClass("current");
            //     debug('adding "current" to '+anchor.text());
            //     $('#gallery .marker').animate(
            //       {
            //         'top':(offsetTop-10).toString()+'px'
            //       },
            //       250,
            //       function() {
            //       // Animation complete
            //       }
            //     );
            //   }
            // );
          }
        );
      }
    );
   */
  // BEGIN: breadcrumb sidebar fix
  if( $("#breadcrumbs").length >= 1 ){
    $("#main-content").addClass("has-breadcrumbs");
  }
  // END: breadcrumb sidebar fix
  // BEGIN: search input
  $(".search-bar #hd-search input[type='text'], .search-bar #ft-search input[type='text']").focus(function(){
    if( $(this).val() == 'Search for recipe' ){
      $(this).val('');
    }
  });
  $(".search-bar #hd-search input[type='text'], .search-bar #ft-search input[type='text']").blur(function(){		
    if( $(this).val() == '' ){
      $(this).val('Search for recipe');
    }
  });
  // END: search input
  // BEGIN: add a label to the Daily Dish text areas...
  if( $(".daily-dish #commentsform textarea") ){
    var new_label = "<label for='comment'>Comment</label><br />" + $(".daily-dish #commentsform textarea").parent("p").html()
    $(".daily-dish #commentsform textarea").parent("p").html(new_label);
  }
  //"<label for='comment'>Comment</label><br />"
  // BEGIN: add a label to the Daily Dish text areas...
  // BEGIN: toggle backgrounds
  $("#show_guac").click(function(){
    $("#theme-wrap").removeClass().addClass("show-guac");
  });
  $("#show_pom").click(function(){
    $("#theme-wrap").removeClass().addClass("show-pom");
  });
  $("#show_cabbage").click(function(){
    $("#theme-wrap").removeClass().addClass("show-cabbage");
  });
  // END: toggle backgrounds
  // BEGIN: recipe detail rating
  if( $("div.rating ul.hornav li a").length > 0 ){
    $("div.rating ul.hornav li a").mouseenter(function(){
      var my_class = $(this).attr("class");
      switch(my_class){
        case 'one':
          // do nothing because css covers it
          break;
        case 'two':
          $("div.rating ul.hornav li a.one").addClass("active");
          break;
        case 'three':
          $("div.rating ul.hornav li a.one, div.rating ul.hornav li a.two").addClass("active");
          break;
        case 'four':
          $("div.rating ul.hornav li a.one, div.rating ul.hornav li a.two, div.rating ul.hornav li a.three").addClass("active");
          break;
        case 'five':
          $("div.rating ul.hornav li a.one, div.rating ul.hornav li a.two, div.rating ul.hornav li a.three, div.rating ul.hornav li a.four").addClass("active");
          break;
        default:
      // code to be executed if n is different from case 1 and 2
      }
    });
  }
  $("div.rating ul.hornav li a").mouseleave(function(){
    $("div.rating ul.hornav li a").removeClass("active");
  });
  // END: recipe detail rating
  // BEGIN: hide/show add a rave
  $("#my-raves form").hide();
  $(".cta-writerave a").click(function(){
    $(this).hide();
    $("#my-raves form").slideDown();
  });
  $("#my-raves form input[type='submit']").click(function(){
    $(".cta-writerave a").show();
    $("#my-raves form").slideUp();
  });
  // END: hade/show add a rave
  // BEGIN: hide/show share bar
  $(".close_sharebar").click(function(){
    $('#sharebar').animate({
      bottom: '-60px'
    }, 500, function() {
      // done
      });
    //$('#main-footer .wrapper').removeClass('pb60');
    $('#main-footer .wrapper').animate({
      'padding-bottom': '0px'
    }, 500, function() {
      // Animation complete.
      });	
    if( $('#vote-box') ){
      $('#vote-box').animate({
        bottom: '0'
      }, 500, function() {
        // done
        });
      $('#main-footer .wrapper').animate({
        'padding-bottom': '60px'
      }, 500, function() {
        // Animation complete.
        });	
    }
  });
  $("#show_sharebar a").click(function(){
    $('#sharebar').animate({
      bottom: '0px'
    }, 500, function() {
      // Animation complete.
      });			
    //$('#main-footer .wrapper').addClass('pb60');
    $('#main-footer .wrapper').animate({
      'padding-bottom': '60px'
    }, 500, function() {
      // Animation complete.
      });		
    if( $('#vote-box') ){
      $('#vote-box').animate({
        bottom: '52px'
      }, 500, function() {
        // done
        });
      $('#main-footer .wrapper').animate({
        'padding-bottom': '100px'
      }, 500, function() {
        // Animation complete.
        });		
    }
  });
  // END: hide/show share bar
  // BEGIN: popup
  $("#open_popup").click(function(){
    $(".popup").removeClass("hide");
  });
  $("#close_popup").click(function(){
    $(".popup").addClass("hide");
  });
  // END: popup
  // BEGIN: edit profile form
  $("#open_editprofile").click(function(){
    $('fieldset.user-details.inline-changes.values').hide();
    $('fieldset.user-details.inline-changes.editing').show();
    $('#open_editprofile').hide();
  });
  $("#close_editprofile").click(function(){
    $('fieldset.user-details.inline-changes.values').show();
    $('fieldset.user-details.inline-changes.editing').hide();
    $('#open_editprofile').show();
  });
  // END: edit profile form
        
  //BEGIN: Placeholder Text
  var placeholdersID = {
    searchRecipesText:"Find my recipe by entering it here..."
  };

  //Set values of search textfields 
  $.each(placeholdersID, function(id, val) { 
    //Set Starting Values
    $('#'+id).val(val);
    //Removes text on focus for textfield
    $('#'+id).focus(function(){
      if($(this).val() == val)
        $(this).val('');
    });
    //Replaces textfield with value if still empty
    $('#'+id).blur(function(){
      if ($(this).val() == '')
        $(this).val(val);
    });
  });
  //END: End Place Holder text
         
  if ( $('#userComment').length > 0 ) {
    initCKEditor('userComment');
  }
        
  if ( $('#journaladd_body').length > 0 ) {
    initCKEditor('journaladd_body');
  }
        
  if ( $('#forumContent').length > 0 ) {
    initCKEditor('forumContent');
  }
        
  if ( $('#postContent').length > 0 ) {
    initCKEditor('postContent');
  }
        
  if ( $('#dishTerm').length > 0 ) {
    $('#dishTerm').bind('keypress', function(e) {
      if(e.keyCode==13){
        if ( $.trim( $('#dishTerm').val() ) == '' || $.trim( $('#dishTerm').val() )  == 'Search the daily dish' ) {
          alert('please enter a search term');
        } else {
          location.href = '/search?term='+$('#dishTerm').val()+'&PageType=blogs';
        }
      }
    });
  }
  
  if( $('#no-border').length > 0 ){
    $('#no-border').css({
      "border":"none", 
      "margin":"0", 
      "padding":"0"
    });
  }
  
  $('#open_add-recipes').bind('click', function() {
    window.location.hash = "add-recipes";
  });
  
  $('#open_add-a-recipe').bind('click', function() {
    window.location.hash = "add-a-recipe";
  });  
  
  if(window.location.hash == "#add-a-recipe"){
    $("#add-a-recipe").show();        
    $("#add-recipes").hide();      
    $("#open_add-recipes").parent().removeClass("active");        
    $("#open_add-a-recipe").parent().addClass("active");        
  } else if(window.location.hash == "#add-recipes"){
    $("#add-a-recipe").hide();        
    $("#add-recipes").show();      
    $("#open_add-recipes").parent().addClass("active");        
    $("#open_add-a-recipe").parent().removeClass("active");        
  } 
  
  
  // START - OPEN GRAPH PUBLISH ACTIONS COMMANDS
  
  // print recipe action
  if ( $('#printRecipeBtn').length > 0 ) {
    addActionPrint();
  }
  
  
  // END - OPEN GRAPH PUBLISH ACTIONS COMMANDS
  
  if ( $('#recipe-detail .main-image').length > 0 ) {
    $('#recipe-detail .main-image').hover(
      function () {
        $('#saveRecipeHover').show();
        $('#pinButtonMain').show();
      }, 
      function () {
        $('#saveRecipeHover').hide();
        $('#pinButtonMain').hide();
      }
      );
    $('#saveRecipeHover').click(function () {
      $(this).remove();
    });

  }
  
  if ( $('#pinButtonMain').length > 0 ) {
	  $('#pinButtonMain a img').mouseover(function(){
		  $('#mainImg').addClass('fade');
	  });
	  $('#pinButtonMain a img').mouseout(function(){
	  	$('#mainImg').removeClass('fade');
	  });
  }
  
  if ( $('#friendRibbonContainer').length > 0 ) {
	  friendRibbonHover();
  }
        
}); // END: doc ready

function pin_this(e, url) {
		window.open(url, 'pinterest', 'screenX=100,screenY=100,height=580,width=730');
		e.preventDefault();
		e.stopPropagation();
}

function friendRibbonHover() {
	$("#friendRibbonContainer img.friend-avatar").mouseover(function() {
		if ( $("#friendRibbonContainer .friend_activity_list").is(':visible') ) {
			$("#friendRibbonContainer .friend_activity_list").hide('fast');
		}
        $(this).next(".friend_activity_list").show('fast');
      });
      $("#friendRibbonContainer .friend_activity_list").mouseleave(function() {
        $(this).hide("fast");
      });
}

// BEGIN: runs as part of the slideshow $.cycle
function onAfter(curr,next,opts) {
  var caption = (opts.currSlide + 1) + ' / ' + opts.slideCount;
  $('#caption1').html(caption);
}
// END: runs as part of the slideshow $.cycle

function ajaxPaginate(obj, path, page, type) {
  $(obj).load(path, {
    page: page
  } );
  if (type == 'polls') {
    s.pageName=s.eVar9='Category:Polls:'+page;
    s.t();
  } else if (type == 'journals') {
    s.pageName=s.eVar9='Category:Journals:'+page;
    s.t();
  } else if (type == 'discussion') {
    s.pageName=s.eVar9='Category:Discussions:'+page;
    s.t();
  }
  refreshAdtags();
}

function ajaxPaginateDailyDishList(path, page, tag) {
  $('#dailydishContainer').load(path, {
    page: page, 
    tag: tag
  } );
//refreshAdtags();
}

function recipeVoteOmniture() {
  s.pageName=s.eVar9= s.pageName + ':voted'; 
}

function fireOmniture() {
  s.t();
}

function ajaxPaginatePolls(obj, path, page, poll_blog) {

  $(obj).load(path, {
    page: page, 
    poll_blog: poll_blog
  } );
  s.pageName=s.eVar9='Polls:Groups:'+$('#displayTitle').text()+':'+page;
  s.t();
  refreshAdtags();
}

function ajaxPaginateMembers(obj, path, page, slug, cat) {
  $(obj).load(path, {
    page: page, 
    slug: slug
  } );
  s.pageName=s.eVar9='Groups:'+cat+':'+$('#displayTitle').text()+':members:'+page;
  s.t();
  refreshAdtags();
}

function ajaxPaginateRecipes(obj, path, page, slug, cat, sort) {
  $(obj).load(path, {
    page: page, 
    slug: slug, 
    sort: sort
  } );
  s.pageName=s.eVar9='Groups:'+cat+':'+$('#displayTitle').text()+':recipes:'+page;
  s.t();
  refreshAdtags();
}

function ajaxPaginatePhotos(obj, path, page, slug, sort) {
  $(obj).load(path, {
    page: page, 
    slug: slug, 
    sort: sort
  } );
  s.pageName=s.eVar9='Photos:Groups:'+$('#displayTitle').text()+':'+page;
  s.t();
  refreshAdtags();
}

function ajaxPaginateVideos(obj, path, page, slug, sort) {
  $(obj).load(path, {
    page: page, 
    slug: slug, 
    sort: sort
  } );
  s.pageName=s.eVar9='Videos:Groups:'+$('#displayTitle').text()+':'+page;
  s.t();
  refreshAdtags();
}

function ajaxPaginateDiscussions(obj, path, page, slug) {
  $(obj).load(path, {
    page: page, 
    slug: slug
  }, function(data) {
    $('#forumContent').wysiwyg();
  } );
  s.pageName=s.eVar9='Discussions:Groups:Main:'+$('#displayTitle').text()+':'+page;
  s.t();
  refreshAdtags();
}

function ajaxPaginateDiscussionsDetails(obj, path, page, slug, thread_id) {
  $(obj).load(path, {
    page: page, 
    slug: slug, 
    thread_id: thread_id
  }, function(data) {
    $('#postContent').wysiwyg();
  } );
  s.pageName=s.eVar9='Discussions:Groups:Detail:'+$('#displayTitle').text()+':'+page;
  s.t();
  refreshAdtags();
}



function checkGroupName(path) {
  $('#checkName').hide();
  $.post(path, {
    name: $.trim($('#groupcreateone_name').val())
  }, function(data) {
    $('#checkName').html(data);
    $('#checkName').show();
  }, "json" );
}

function groupRecipeSearch(path, id) {
  $('#existingRecipeList').load(
    path, 
    {
      user_id: id, 
      search_type: $('input:radio[name=search-recipes-check]:checked').val(), 
      search_val: $('#searchRecipesText').val()
    },
    function(data) {
      $(".recipe-list").multiselect({
        autoOpen: true
      });
    }
    );
}

function addcomment(path) {
  /* if we use the the WYSIWYG we need to grab the user's HTML input and manually set the textarea prior to running jquery post */
  if ( $('#addComment textarea').hasClass('wym-editor') ) {
    $('#addComment textarea').val(CKEDITOR.instances.userComment.getData());
  }
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

function startDiscussion(category, groupname) {
  //alert(category+' '+groupname);
  $('#discussionStart').css('visibility','visible');
  //s.PageName='Groups:'+category+':'+groupname+':discussions:start';
  s.pageName=s.eVar9='Discussions:Groups:'+groupname+':discussions:start';        
  s.prop1='Groups:'+category;
  s.prop2='Discussions:Group:Main';
  s.t();
}

function startReply() {
  $('#postStart').css('visibility','visible');
}

function createThread(path, reload) {
  /* if we use the the wym-editor WYSIWYG we need to grab the user's HTML input and manually set the textarea prior to running jquery post */
  if ( $('#discussionStart textarea').hasClass('wym-editor') ) {
    $('#discussionStart textarea').val(CKEDITOR.instances.forumContent.getData());
  }
  $.post( 
    path, 
    $('#discussionStart').serialize(), 
    function(data) {
      $('#forumTitle').val('');
      $('#forumContent').val('');
      $('#message').html(data.message);
      $('#message').show();
      location.href = reload;
    }, 
    "json" 
    );
}

function createPost(path, reload) {
  /* if we use the the wym-editor WYSIWYG we need to grab the user's HTML input and manually set the textarea prior to running jquery post */
  if ( $('#postStart textarea').hasClass('wym-editor') ) {
    $('#postStart textarea').val(CKEDITOR.instances.postContent.getData());
  }
  $.post( 
    path, 
    $('#postStart').serialize(), 
    function(data) {
      $('#postContent').val('');
      $('#message').html(data.message);
      $('#message').show(); 
      location.href = reload; 
    }, 
    "json" 
    );

}

function journalAddSubmit() {
  /* if we use the the wym-editor WYSIWYG we need to grab the user's HTML input and manually set the textarea prior to submitting the form */
  if ( $('#journalAdd textarea').hasClass('wym-editor') ) {
    $('#journalAdd textarea').val(CKEDITOR.instances.journaladd_body.getData());
  }
  $('#journalAdd').submit();
}

function groupCreateAddRecipe(theval) {
  $('#recipe_submit_type').val(theval);
  document.getElementById('add-a-recipe').submit();
}

function makeFriend(path, u, f, display, subdir) {
  $.post( path, 
  {
    user_id: u, 
    friend_id: f
  }, 
  function(data) { 
    if (data.code == 1) {
      $('#friend-reqest').html('<p>'+display+' has been invited to be your Friend.<br /><a href="/message/compose?friend='+subdir+'">Send them a message</a>.');
    } else {
      alert(data.message);
    } 
  }, "json" 
  );
}

function manageFriendRequest(path, friend_id) {
  $.post( path, {
    friend_id: friend_id, 
    user_id: $('#userId').val()
  }, function(data) {
    if(data.code == '1') {
      window.location.reload();
    } else {
      alert(data.message);
    }
  }, "json" );
}

function ajaxPaginateFriends(obj, path, page, subdir, user_id, type, my_profile) {
  $(obj).load(path, {
    page: page, 
    subdir: subdir, 
    user_id: user_id, 
    type: type, 
    my_profile: my_profile
  } );
}

function clearText(field){
  if (field.defaultValue == field.value) field.value = '';
  else if (field.value == '') field.value = field.defaultValue;
}

function submitSearchDish() {
  if ( $.trim( $('#dishTerm').val() ) == '' || $.trim( $('#dishTerm').val() )  == 'Search the daily dish' ) {
    alert('please enter a search term');
  } else {
    location.href = '/search?term='+$('#dishTerm').val()+'&PageType=blogs';
  }
}

function cancelAction(path) {
  var r=confirm("Are you sure you want to cancel and leave this page?");
  if (r==true) {
    location.href = path;
  } else {
    return false;
  }
}

function disableEnterKey(e)
{
  var key;     
  if(window.event)
    key = window.event.keyCode; //IE
  else
    key = e.which; //firefox     

  return (key != 13);
}


function erinVote(path, obj, poll_id) {
  if (!$("input[@name='vote-option']:checked").val()) {
    alert('Please select an option to vote for');
  } else {
    s.PageName='Polls:Detail:Voted';
    s.eVar9='Polls:Detail:Voted';
    s.t();
    $(obj).load(path, {
      poll_id: poll_id, 
      option_id: $("input[@name='vote-option']:checked").val()
    } );
  }
}

function castVoteFeatured(path, obj, poll_id, option_id, option_title, poll_title) {
  $(obj).load(
    path, {
      poll_id: poll_id, 
      option_id: option_id
    },
    function() {
      $.post(
        '/opengraph/addVotedPoll', 
        {
          option_id: option_id,
          option_title: option_title, 
          poll_title: poll_title
        },
        function(data) {
          if (data) {
            // launch activity completed box
            openActivityCompleted(data.id);
          }
        }, "json"
        );
    }
    );
}

function reportAbuse(obj, path, user_id, x_id, x_type) {
  $.post( path, {
    user_id: user_id, 
    xref_id: x_id, 
    type: x_type
  }, function(data) {
    $(obj).parent().text(data.message);
  }, "json" );
}


// SEARCH FUNCTIONS BEGIN 

function doSearchWith() {
  var without = '';
  var r = '';
  var c = '';
  var w = 'with=';
  if ( $('#with').val() != '' ) {
    w += $('#with').val() + ',' + $('#with-field').val();
  } else {
    w += $('#with-field').val();
  }
	
  if ( $('#without').val() != '' ) {
    without = '&without='+$('#without').val();
  }
	
  if ( $('#recipeOwner').val() != '' ) {
    r = '&recipeOwner='+$('#recipeOwner').val();
  }
	
  if ( $('#totalCats').val() != '' ) {
    c = '&CategoryName='+$('#totalCats').val();
  }
	
  // construct the url
  var url = '/search?'+w+without+r+c+$('#current-params').val();
  //alert(url);
  location.href = url;
}

function deleteWith(val) {
  var without = '';
  var r = '';
  var c = '';
	
  var w = 'with=';
  var tempParam = '';
  var str = $('#with').val();
  var temp = str.split(",");
  var newParam;
  $.each(temp, function(index, value) {
    if ( $.trim(value) !== '') {
      if ($.trim(value) != val) {
        tempParam += $.trim(value) +',';
      }
    }
  });
  newParam = tempParam.substring(0, tempParam.length - 1);
	
  if ( $('#without').val() != '' ) {
    without = '&without='+$('#without').val();
  }
	
  if ( $('#recipeOwner').val() != '' ) {
    r = '&recipeOwner='+$('#recipeOwner').val();
  }
	
  if ( $('#totalCats').val() != '' ) {
    c = '&CategoryName='+$('#totalCats').val();
  }
	
  if (newParam != '') {
    var url = '/search?'+w+newParam+$('#current-params').val()+without+r+c;
  } else {
    var url = '/search?'+$('#current-params').val()+without+r+c;
  }
  location.href = url;
}


function doSearchWithout() {
  var withval = '';
  var r = '';
  var c = '';
  var w = 'without=';
  if ( $('#without').val() != '' ) {
    w += $('#without').val() + ',' + $('#without-field').val();
  } else {
    w += $('#without-field').val();
  }
	
  if ( $('#with').val() != '' ) {
    withval = '&with='+$('#with').val();
  }
	
  if ( $('#recipeOwner').val() != '' ) {
    r = '&recipeOwner='+$('#recipeOwner').val();
  }
	
  if ( $('#totalCats').val() != '' ) {
    c = '&CategoryName='+$('#totalCats').val();
  }
	
  // construct the url
  var url = '/search?'+w+withval+r+c+$('#current-params').val();
  //alert(url);
  location.href = url;
}



function deleteWithout(val) {
  var withval = '';
  var r = '';
  var c = '';
	
  var w = 'without=';
  var tempParam = '';
  var str = $('#without').val();
  var temp = str.split(",");
  var newParam;
  $.each(temp, function(index, value) {
    if ( $.trim(value) !== '') {
      if ($.trim(value) != val) {
        tempParam += $.trim(value) +',';
      }
    }
  });
  newParam = tempParam.substring(0, tempParam.length - 1);
	
  if ( $('#with').val() != '' ) {
    withval = '&with='+$('#with').val();
  }
	
  if ( $('#recipeOwner').val() != '' ) {
    r = '&recipeOwner='+$('#recipeOwner').val();
  }
	
  if ( $('#totalCats').val() != '' ) {
    c = '&CategoryName='+$('#totalCats').val();
  }
	
  if (newParam != '') {
    var url = '/search?'+w+newParam+$('#current-params').val()+withval+r+c;
  } else {
    var url = '/search?'+$('#current-params').val()+withval+r+c;
  }
  location.href = url;
}

function clearSearchIngredients(type) {
  var w = '';
  var r = '';
  var c = '';
  if (type == 'with') {
    if ( $('#without').val() != '' ) {
      w = '&without='+$('#without').val();
    }
  } else {
    if ( $('#with').val() != '' ) {
      w = '&with='+$('#with').val();
    }
  }
	
  if ( $('#recipeOwner').val() != '' ) {
    r = '&recipeOwner='+$('#recipeOwner').val();
  }
	
  if ( $('#totalCats').val() != '' ) {
    c = '&CategoryName='+$('#totalCats').val();
  }
	
  var url = '/search?'+$('#current-params').val()+w+r+c;
  location.href = url;
}


function doSearchRecipeOwner() {
  var c = '';
  var w = 'recipeOwner=';
  if ( $('#recipeOwner').val() != '' ) {
    w += $('#recipeOwner').val() + ',' + $('#recipeOwner-field').val();
  } else {
    w += $('#recipeOwner-field').val();
  }
	
  if ( $('#without').val() != '' ) {
    w += '&without='+$('#without').val();
  }
	
  if ( $('#with').val() != '' ) {
    w += '&with='+$('#with').val();
  }
	
  if ( $('#totalCats').val() != '' ) {
    c = '&CategoryName='+$('#totalCats').val();
  }
	
  // construct the url
  var url = '/search?'+w+c+$('#current-params').val();
  //alert(url);
  location.href = url;
}


function deleteRecipeOwner(val) {
  var withval = '';
  var withoutval = '';
  var c = '';
	
  var w = 'recipeOwner=';
  var tempParam = '';
  var str = $('#recipeOwner').val();
  var temp = str.split(",");
  var newParam;
  $.each(temp, function(index, value) {
    if ( $.trim(value) !== '') {
      if ($.trim(value) != val) {
        tempParam += $.trim(value) +',';
      }
    }
  });
  newParam = tempParam.substring(0, tempParam.length - 1);
	
  if ( $('#with').val() != '' ) {
    withval = '&with='+$('#with').val();
  }
  if ( $('#without').val() != '' ) {
    withoutval = '&without='+$('#without').val();
  }
	
  if ( $('#totalCats').val() != '' ) {
    c = '&CategoryName='+$('#totalCats').val();
  }
	
  if (newParam != '') {
    var url = '/search?'+w+newParam+$('#current-params').val()+withval+withoutval+c;
  } else {
    var url = '/search?'+$('#current-params').val()+withval+withoutval+c;
  }
  location.href = url;
}

function clearRecipeOwner() {
  var w = '';
  var ww = '';
  var c = '';
  if ( $('#without').val() != '' ) {
    ww = '&without='+$('#without').val();
  }
  if ( $('#with').val() != '' ) {
    w = '&with='+$('#with').val();
  }
  if ( $('#totalCats').val() != '' ) {
    c = '&CategoryName='+$('#totalCats').val();
  }
	
  var url = '/search?'+$('#current-params').val()+w+ww+c;
  location.href = url;
}


function deleteCategory(val) {
  var withval = '';
  var withoutval = '';
  var r = '';
	
  var w = 'CategoryName=';
  var tempParam = '';
  var str = $('#totalCats').val();
  var temp = str.split(",");
  var newParam;
  $.each(temp, function(index, value) {
    if ( $.trim(value) !== '') {
      if ($.trim(value) != val) {
        tempParam += $.trim(value) +',';
      }
    }
  });
  newParam = tempParam.substring(0, tempParam.length - 1);
	
  if ( $('#with').val() != '' ) {
    withval = '&with='+$('#with').val();
  }
	
  if ( $('#without').val() != '' ) {
    withoutval = '&without='+$('#without').val();
  }
	
  if ( $('#recipeOwner').val() != '' ) {
    r = '&recipeOwner='+$('#recipeOwner').val();
  }
	
  if (newParam != '') {
    var url = '/search?'+w+newParam+$('#current-params').val()+withval+withoutval+r;
  } else {
    var url = '/search?'+$('#current-params').val()+withval+withoutval+r;
  }
  location.href = url;
}

function validateSearch(obj){
  keyword_field = $(obj).children("input[name='term']");
  if(/^\s+$/.test(keyword_field.val()) || keyword_field.val()==""){
    keyword_field.val("Search for recipe");
  }
  return !(keyword_field.val()=="Search for recipe");
}

// SEARCH FUNCTIONS END

function openActivityCompleted(id) {
  $('#activity_completed_container').load(
    '/opengraph/openActivityCompleted',
    {
      id: id
    },
    function(data) {
      $(this).show("fast");
    });
}

function closeActivityCompleted() {
  $("#activity_completed_container").slideUp("fast");
  $("#activity_completed_container").html("");
}

function addActionPrint() {
  $('#printRecipeBtn').bind('click', function() {
    $.post(
      '/opengraph/addPrint',
      {
        recipe: $(this).attr('rel')
      },
      function(data) {
        if (data) {
          // launch activity completed box
          openActivityCompleted(data.id);
        }
      }, "json"
      );
      addToSaved();
  }); 
}

function addToMadeThis(id, title, url) {
  $.post(
    '/opengraph/addMade',
    {
      recipe_id: id, 
      recipe_title: title, 
      recipe_url: url
    },
    function(data) {
      if ( $('#savedModal').length > 0 ) {
          	$('#savedModal').hide();
      	}
      $('#madeContainer .graphic-button').text('MADE');
      $('.madeMoreFeatures').show();
      if (data) {
        // launch activity completed box
        openActivityCompleted(data.id);
      }
    }, "json"
    );
}

function savedRecipeMade(obj, id, title, url) {
  $.post(
    '/opengraph/addMade',
    {
      recipe_id: id, 
      recipe_title: title, 
      recipe_url: url
    },
    function(data) {
      $(obj).text('MADE');
      if (data) {
        // launch activity completed box
        openActivityCompleted(data.id);
      }
    }, "json"
    );
}

function addVotedRecipeContest(recipe_id, recipe_title, contestant_id, contest_url) {
  $.post(
    '/opengraph/addVotedRecipeContest',
    {
      recipe_id: recipe_id, 
      recipe_title: recipe_title, 
      contestant_id: contestant_id, 
      contest_url: contest_url
    },
    function(data) {
      if (data) {
        // launch activity completed box
        openActivityCompleted(data.id);
      }
    }, "json"
    );
}

function addEnteredContest(contestant_id, contest_title) {
  $.post(
    '/opengraph/addEnteredContest',
    {
      contestant_id: contestant_id, 
      contest_title: contest_title
    },
    function(data) {
      if (data) {
        // launch activity completed box
        openActivityCompleted(data.id);
      }
    }, "json"
    );
}

function addToRecommend(id, title, url) {
  $.post(
    '/opengraph/addRecommend',
    {
      recipe_id: id, 
      recipe_title: title, 
      recipe_url: url
    },
    function(data) {
      $('.madeMoreFeatures').hide();
      if (data) {
        // launch activity completed box
        openActivityCompleted(data.id);
      }
    }, "json"
    );
}

// function for pagininating friendRibbon results
function friendRibbon(page_no, results_per_page) {
  $('#friendRibbonContainer').load(
  	'/opengraph/paginateFriendRibbon', 
  	{ page_no: page_no, results_per_page: results_per_page },
  	function() { friendRibbonHover(); }
  	);
}


// function for pagininating userRailActivity results
function userRailActivity(page_no, results_per_page) {
  $('#user_rail_activity_container').load('/opengraph/paginateUserRailActivity', {
    page_no: page_no, 
    results_per_page: results_per_page
  });
}

// function for pagininating userRailActivityLog results
function userRailActivityLog(page_no, results_per_page) {
  $('#activity_box').load('/opengraph/paginateUserRailActivityLog', {
    page_no: page_no, 
    results_per_page: results_per_page
  });
}

// function deletes logged in user's activity from log
// note: (R.C.) - I'm not sure what sort of user feedback is supposed to occur so I'm simply reloading the module so that pagination & total results are not messed up
function deleteActivityLog(obj, id) {
  $(obj).closest("li").remove();
  $.post(
    '/opengraph/deleteActivity',
    {
      id: id
    },
    function() {
      userRailActivityLog(1, 5);
    }
    );
}

function deleteActivity(obj, id) {
  $(obj).closest("li").remove();
  $.post(
    '/opengraph/deleteActivity',
    {
      id: id
    },
    function() {
      userRailActivity(1, 3);
    }
    );
}

function deleteActivityCompleted(id) {
  $.post(
    '/opengraph/deleteActivity',
    {
      id: id
    },
    function() {
      closeActivityCompleted();
    }
    );
}

/*  Removed 7-31-2012 Chris
    as per client Request, through Adam and Angela
function addLike(recipe_id, is_liked) {
  $.post('/recipes/addLike', {
    recipe_id: recipe_id, 
    is_liked: is_liked
  }, function() {
    $('.madeMoreFeatures').hide();
  });
}
*/

function getCookie(c_name)
{
  return $.cookie(c_name);
}

function displayPopup()
{
  $('#popup-login').css('display', 'block');
}

function setPopupCookie(click_number)
{
  expire_date = new Date();
  timestamp = new Date();
  timestamp.setHours(timestamp.getHours() + 1);
  expire_date.setDate( expire_date.getDate() + 30);
  if( document.location.hostname.indexOf(".resolute.com") == -1)
  {
    $.cookie("showPopup", click_number + ";" + timestamp, {expires:expire_date, domain:".betterrecipes.com"});
  }else
  {
    $.cookie("showPopup", click_number + ";" + timestamp, {expires:expire_date, domain:".resolute.com"});
  }
}

function closePopup(setCookie)
{
  $('#popup-login').animate({
    "opacity":"0"
  }, 500, function()

  {
    $('#popup-login').css({
      "left":"-9999%"
    });
  });
  setPopupCookie(1);
}

function emailRecipe()
{
  $("#inlinesharebar-reaction5").click();
}

function sendRequestViaMultiFriendSelector() {
  $("#options_button").removeClass("active");
  $("#options_box").hide();
  $("#options_arrow").hide();
  FB.ui({method: 'apprequests',
    message: 'Come use this great recipe website with me'
  }, requestCallback);
}

function requestCallback(response) {
  // Handle callback here
}
(function( $ ) {
    var cookie = $.fn.cookie = function (key, value, options) {
        // key and at least value given, set cookie...
        if (arguments.length > 1 && String(value) !== "[object Object]") {
            options = jQuery.extend({}, options);

            if (value === null || value === undefined) {
                options.expires = -1;
            }

            if (typeof options.expires === 'number' && options.expires !== 0) {
                var future = options.expires, t = options.expires = new Date();
                if (future > 1000) {
                    // timestamp (milliseconds)
                    t.setTime(future);
                } else {
                    // days
                    t.setDate(t.getDate() + future);
                }
            }

            value = String(value);

            return (document.cookie = [
                encodeURIComponent(key), '=',
                options.raw ? value : encodeURIComponent(value),
                options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                options.path ? '; path=' + options.path : '',
                options.domain ? '; domain=' + options.domain : '',
                options.secure ? '; secure' : ''
            ].join(''));
        }

        // key and possibly options given, get cookie...
        options = value || {};
        var result, decode = options.raw ? function (s) { return s; } : decodeURIComponent;
        return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null;
    }

    $.cookie = cookie;

    window.rd || (window.rd = {});

    window.rd.cookie = cookie;

})( window.jQuery || $ );
