<? if ($sf_user->isAuthenticated()): ?>

	<? // is the user sign-in through Facebook (must have auth token) ?>
	<? if ( $sf_user->getRegSourceAttribute('auth_token') ): ?>
			  <script>
			    $(document).ready(function() {
			      $("ul.user-controls li").click(function() {
			        var popup = this.id.replace("_button", "");
			        if($(this).hasClass("active")){
			          $("ul.user-controls li").removeClass("active");
			          $(this).removeClass("active");
			          $("#" + popup + "_box").hide(); 
			          $("#" + popup + "_arrow").hide(); 
			        } else {
			          $("ul.user-controls li").removeClass("active");
			          $(this).addClass("active");
			          $(".facebook-switch").hide(); 
			          $(".tooltip-arrow").hide(); 
			          $("#" + popup + "_box").show(); 
			          $("#" + popup + "_arrow").show(); 
			        }
			      });
			      $("#social_switch").click(function() {
			        if($(this).html() =="Turn On"){
			          $(this).html("Turn Off");
			          $.getJSON("<?= url_for('@toggle_social?switch=1') ?>", function(data){
			            if(data.result){
			              $("#fb_social_status").html("Sharing on Facebook is ON");
			              $(".pinhead").html("Social: On").addClass("on");
			            }
			          });
			        } else {
			          $(this).html("Turn On");
			          $.getJSON("<?= url_for('@toggle_social?switch=0') ?>", function(data){
			            if(data.result){
			              $("#fb_social_status").html("Sharing on Facebook is OFF");
			              $(".pinhead").html("Social: Off").removeClass("on");
			            }
			          });
			        }
			        $("#social_button").removeClass("active");
			        $("#social_box").hide(); 
			        $("#social_arrow").hide();
			      });
			      $("#user-profile #friends_activity_container img.friend-avatar").mouseover(function() {
			        $("#user-profile #friend_activity_list ul").html($(this).next("ul.activity-list").html());
			        $("#user-profile #friend_activity_list").show("fast");
			        $("#user-profile #friend_activity_list img.tooltip-arrow").offset({left: parseInt($(this).offset().left + 18)}).show();
			      });
			      $("#user-profile #friend_activity_list").mouseleave(function() {
			        $(this).hide("fast");
			        $(this +" ul").html("");
			      });
			      
			      
			      $('#social_experience').click(function() {
				   	   $.getJSON("<?= url_for('@remove_facebook') ?>", function(data){
			            if(data.result){
			              window.location.reload();
			            }
			          });
			      });
			      
			      
			      
			    });
			                        
			  </script>
			  <div id="user-profile">
			    <? // check if user is logged in via Facebook and show all open-graph related modules ?>
			    <div class="ttupp">
			      <? // load user's avatar ?>
			      <a href="<?= getUrl('User', $sf_user->getUserData()) ?>">
			        <img class="profile-img" src="<?= $sf_user->getAvatarSrc() ?>" alt="<?= $sf_user->getFirstName() ?> <?= $sf_user->getLastName() ?>" />
			        <?= $sf_user->getFirstName() ?> <?= $sf_user->getLastName() ?>
			      </a>
			    </div>
			    <ul class="user-controls">
			      <li id="social_button">
			        <? if ($sf_user->getFbShare() == 1): ?>
			          <span class="pinhead on">Social: On</span>
			        <? else: ?>
			          <span class="pinhead">Social: Off</span>
			        <? endif; ?>
			      </li>
			      <li id="activity_button">My Activity</li>
			      <li id="options_button">Options</li>
			      <li></li>
			      <li></li>
			    </ul>
			    <div class="popup-container">
			      <div class="facebook-switch" id="social_box">
			        <? if ($sf_user->getFbShare() == 1): ?>
			          <span id="fb_social_status">Sharing on Facebook is ON</span>
			          <a id="social_switch">Turn Off</a>
			        <? else: ?>
			          <span id="fb_social_status">Sharing on Facebook is OFF</span>
			          <a id="social_switch">Turn On</a>
			        <? endif; ?>         
			      </div>
			      <img class="tooltip-arrow" id="social_arrow" src="/img/tooltip-arrow.png" />
			      <div class="facebook-switch" id="activity_box">
			        <?php include_component('opengraph', 'userRailActivityLog', array('results_per_page' => 5)) ?>
			      </div>
			      <img class="tooltip-arrow" id="activity_arrow" src="/img/tooltip-arrow.png" />
			      <div class="facebook-switch" id="options_box">
			        <ul>
			          <li><a href="" onclick="sendRequestViaMultiFriendSelector(); return false;">Invite Friends</a></li>
			          <li><a href="">Report a Problem</a></li>
			          <li><a href="<?= getSignoutUri() ?>">Sign Out</a></li>
			          <li><a href="javascript:;" id="social_experience">Remove this Experience</a></li>
			        </ul>
			      </div>
			      <img class="tooltip-arrow" id="options_arrow" src="/img/tooltip-arrow.png" />
			    </div>
			    <br />
			    <div class="seperator" />
			    <div id="activity_completed_container"></div><!-- activityCompletedContainer -->
			    <div id="user_rail_activity_container">
			      <?php include_component('opengraph', 'userRailActivity', array('results_per_page' => 3)) ?>
			    </div><!-- // user_rail_activity_container -->
			    <div class="clear-both"></div>
			    <div class="recipe-box" align="center">
			      <div class="button273x28">
			        <a href="<?= getRoute('myrecipebox') ?>" title="View this Users Recipe Box">Go to My Recipe Box</a>
			      </div>
			    </div>
			    <div class="seperator" />
			    <div id="friends_activity_container">
			      <?php include_component('opengraph', 'friendsActivityBar') ?>
			    </div><!-- friends_activity_container -->
			    <div class="clear-both"></div>
			  </div><!-- /#user-profile -->
			  
			  
	<? // user is authenticated, but they did not sign-in via Facebook or whatever reason, the auth token evaluates to false ?>
	<? else: ?>		  
		  
		  
		  <? // display logged in user's avatar, name and a callout to login via Facebook for complete social experience ?>	  
		  <div id="user-profile">
		    <? // check if user is logged in via Facebook and show all open-graph related modules ?>
		    <div class="ttupp">
		      <? // load user's avatar ?>
		      <a href="<?= getUrl('User', $sf_user->getUserData()) ?>">
		        <img class="profile-img" src="<?= $sf_user->getAvatarSrc() ?>" alt="<?= $sf_user->getFirstName() ?> <?= $sf_user->getLastName() ?>" />
		        <?= $sf_user->getFirstName() ?> <?= $sf_user->getLastName() ?>
		      </a>
		    </div>
		    <div class="clear-both"></div>
		    <div class="recipe-box" align="center">
		      <div class="button273x28">
		        <a href="<?= getRoute('myrecipebox') ?>" title="View this Users Recipe Box">Go to My Recipe Box</a>
		      </div>
		    </div>
		  </div>
		  <? // This is the state where you have autheniticated but not with Facebook ?>
		  <div id="rightrail-promo">
		    <img src="/img/facebook_logged_in.png" width="296px"/>
		    <div id="gigya-rightrail-auth"></div>
		    <script>
		      $(document).ready(function() {
		        gigya.socialize.showLoginUI({ 
		          height: 30
		          ,width: 250
		          ,showTermsLink:false // remove 'Terms' link
		          ,hideGigyaLink:true // remove 'Gigya' link
		          ,buttonsStyle: 'signInWith' 
		          ,showWhatsThis: false // Pop-up a hint describing the Login Plugin, when the user rolls over the Gigya link.
		          ,containerID: 'gigya-rightrail-auth' // The component will embed itself inside the loginDiv Div 
		          ,cid:''
		          ,redirectURL: 'http://' + document.domain + '/auth/socialize'
		          ,siteName: 'betterrecipes.com'
		          ,enabledProviders: 'facebook'
		        });
		        popupCookie = getCookie("showPopup");
		        if( popupCookie==null || popupCookie=="" )
		        {
		          displayPopup();
		        }else
		        {
			    	cookie_split = popupCookie.split(";");
			    	clicks = cookie_split[0];
			    	now = new Date();
			    	cookie_split[1] = new Date() - 100000;
			    	if( clicks < 5 )
			    	{
			    		if( cookie_split[1] < now )
			        	{
			        		setPopupCookie(Number(clicks)+1);
			        	}
			    	}else
			    	{
			    		displayPopup();
			    	}
		        }
		      });
		    </script>
		  </div>
		  
	<? endif; ?>	  
		  
		  
<? else: ?>
  <? // user is not logged in, we will update this area for a callout to use social sign-on (Facebook) ?>
  <div id="rightrail-promo-not">
    <img src="/img/facebook_not_logged_in.png" width="296px"/>
    <div id="gigya-rightrail-auth"></div>
    <script>
      $(document).ready(function() {
        gigya.socialize.showLoginUI({ 
          height: 30
          ,width: 250
          ,showTermsLink:false // remove 'Terms' link
          ,hideGigyaLink:true // remove 'Gigya' link
          ,buttonsStyle: 'signInWith' 
          ,showWhatsThis: false // Pop-up a hint describing the Login Plugin, when the user rolls over the Gigya link.
          ,containerID: 'gigya-rightrail-auth' // The component will embed itself inside the loginDiv Div 
          ,cid:''
          ,redirectURL: 'http://' + document.domain + '/auth/socialize'
          ,siteName: 'betterrecipes.com'
          ,enabledProviders: 'facebook'
        });
        popupCookie = getCookie("showPopup");
        if( popupCookie==null || popupCookie=="" )
        {
          displayPopup();
        }else
        {
        	cookie_split = popupCookie.split(";");
        	clicks = cookie_split[0];
        	now = new Date();
        	if( clicks < 5 )
        	{
        		if( cookie_split[1] < now )
	        	{
	        		setPopupCookie(Number(clicks)+1);
	        	}
        	}else
        	{
        		displayPopup();
        	}
        }
      });
    </script>
  </div>
<? endif; ?>
