<? slot('multiselect') ?>
<link rel="stylesheet" type="text/css" href="/js/multiselect/jquery.multiselect.css" />
<link rel="stylesheet" type="text/css" href="/js/multiselect/jquery.multiselect.filter.css" />
<link rel="stylesheet" type="text/css" href="/js/multiselect/jquery-ui.css" />
<script type="text/javascript" src="/js/multiselect/jquery-ui.min.js"></script>
<script type="text/javascript" src="/js/multiselect/jquery.multiselect.min.js"></script>
<script type="text/javascript" src="/js/multiselect/jquery.multiselect.filter.min.js"></script>
<script language="Javascript">
  $(document).ready(function(){
    
    $("#groupcreatetwo_contacts").multiselect({
      autoOpen: false,
      minWidth: 'auto'	
    }).multiselectfilter();
    
    
    $("#groupcreatetwo_fb_friends").multiselect({
      autoOpen: false,
      minWidth: 'auto'	
    }).multiselectfilter();
    
  });
</script>
<? end_slot() ?>

<div class="article create-group create-group2">
  <h3 class="title">Add Friends</h3>
  <p class="summary">Tell your friends about your group! You can share your new group with fellow Mixers or with friends and family not yet a part of the Mixing Bowl community.</p>
  
  <form class="add-friends">
  
  	<fieldset>
      <p class="mb5" style="margin-right:0">INVITE YOUR CONTACTS</p>
      <div id="divConnect"></div> 
      <script type="text/javascript">  
	    // show 'Add Connections' Plugin in "divConnect"  
	    brmb.gigya.showConnectionsUI();
	    </script>   
	    <div style="margin:5px 0;">  
    	Click the button below to retrieve your email contacts <br /> 
	    <input class="btn-grey28" id="btnGetContacts" type="button" value="Get Contacts" onclick="brmb.gigya.getContacts()" disabled=true/>  
	    </div>
      <select id="groupcreatetwo_contacts" multiple="multiple" name="groupcreatetwo[contacts][]"> </select>   
    </fieldset>
    
    <fieldset>
      <p class="mb5" style="margin-right:0">Invite Facebook Friends</p>
      <div id="divConnectFb"></div> 
      <script type="text/javascript">  
	    // show 'Add Connections' Plugin in "divConnect"  
	    brmb.gigya.showFriendsUI();
	    </script>   
	    <div style="margin:5px 0;">  
    	Click the button below to retrieve your Facebook friends <br /> 
	    <input class="btn-grey28" id="btnGetFriends" type="button" value="Get Friends" onclick="brmb.gigya.getFriends()" disabled=true/>  
	    </div>
      <select id="groupcreatetwo_fb_friends" multiple="multiple" name="groupcreatetwo[fb_friends][]"> </select>  
    </fieldset>

  
  </form>
  
  
  </div><!-- /.section -->
<div class="sidebar">

</div><!-- /.sidebar -->
<div class="clearfix"></div>
