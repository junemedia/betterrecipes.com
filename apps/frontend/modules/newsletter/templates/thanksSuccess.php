<div id="main-content">
                  <div id="theme-wrap">
                    <div class="wrapper">
                      <div class="section" style="min-height:550px;">
                        <div class="article">
                            <div id="pagebody">
                            <div id="singlecolumn"><div id="singlecolumnwell">
<br>
<table width="650" cellpadding="0" cellspacing="0" border="0" class="quickSignupContainer">
    <tr>
        <td width="50" class="quickNewsHide">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td><img src="/img/img-newsletter/br_regtopper_weeklyNL.jpg"></td>
    </tr>
</table>
<br>
<script>
function check_fields() {
	var email = document.getElementById('email_addr').value;
	var pattern = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/;
	var chkFlag = pattern.test(email);
	if(!pattern.test(email)) {
		alert("If you'd like to sign up for our newsletters, please enter a valid e-mail address!");
		document.getElementById('email_addr').focus();
		return false;
	} else {
		if (!(document.getElementById('1').checked || document.getElementById('2').checked || document.getElementById('4').checked)) {
			alert("Please select at least one newsletter!");
			return false;
		} else {
			return true;
		}
	}
}
window.scroll(0,0); // horizontal and vertical scroll targets
</script>
<table width="650" cellpadding="0" cellspacing="0" border="0" class="quickSignupContainer">
    <form id="quicksignForm" action="" method="post" onsubmit="return check_fields(this)">
        <tr>
            <td width="50" class="quickNewsHide">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>
                <br><br>

                <table width="600" cellpadding="0" cellspacing="0" border="0" class="quickNewsUserInfo">
				<?php if ($success != '') { ?>
						<tr><td style="color:red;font-size:18px;font-weight:bold;"><?php echo $success; ?></td></tr>
				<?php } ?>
				<tr><td style="height:10px;"></td></tr>
				<script type="text/javascript"> 
var t=5;//set time 
setInterval("refer()",1000); //start
function refer(){  
    if(t==0){ 
        location="http://www.betterrecipes.com"; //redirect url
    } 
	if(t>=0)
	{
		document.getElementById('show').innerHTML=""+t+""; //show time
	}
    t--; 
} 
</script> 
<tr><td style="color:#000;">The page will redirect to <a href="http://www.betterrecipes.com">home page</a> after <span id="show"></span> seconds.</td></tr>

                </table>
                <!-- End info table -->
            </td>
        </tr></form></table><br><br><br>

</div>
            <div class="clearall"></div>
		</div>
    </div>
                        </div><!-- /.article -->
                        <div class="sidebar">
                        </div><!-- /.sidebar -->
                        <div class="clearfix"></div>
                      </div><!-- /.section -->
                    </div><!-- /.wrapper -->
                  </div><!-- /#theme-wrap -->
                </div><!-- /#main-content -->
   
