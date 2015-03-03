<div id="recipe-sharebar" class="flri mt10 mb10">
	<div id="divVideoSharebar"></div>
</div><!-- /#recipe-sharebar -->
<script>
	$(document).ready(function(){
		var vid_pathname = $(location).attr('href');
		if( $("h3.title").length){
			var vid_pagetitle = $('h3.title').clone().find('a').remove().end().text();
			if(vid_pagetitle.length < 1){
				var vid_pagetitle = "Better Recipes"
			}
		} else {
			var vid_pagetitle = "Better Recipes"
		}    
		if( $(".summary").length){
			var vid_pagedesc = $(".summary").clone().find('a').remove().end().text();
		} else {
			var vid_pagedesc = "An online cookbook of recipes for any meal. Browse recipes by topic or search to find the perfect recipe at Better Recipes. Become a member to upload ..."
		}
		var confVideo = {  
				APIKey:'2_t7ugJniPXN32-uUr2BkBDPmTa-oo6VVzt2Gl2MFyw-N8bgqbxzpADm4C1F_6gD51'  
		}     
					
		var uaVideo = new gigya.services.socialize.UserAction();  
		uaVideo.setLinkBack(vid_pathname); // The URL  
		uaVideo.setTitle(vid_pagetitle);  // The page title
		uaVideo.setDescription(vid_pagedesc); // The page summary
					
		var paramsVideo ={   
				userAction:uaVideo,  
				shareButtons: "facebook-like,google-plusone,share,twitter",  
				containerID: 'divVideoSharebar'
		}  
    // console.log("Video url = "+vid_pathname);
    // console.log("Video pagetitle = "+vid_pagetitle);
    // console.log("Video pagedesc = "+vid_pagedesc);
		gigya.services.socialize.showShareBarUI(confVideo,paramsVideo);
	});
</script>