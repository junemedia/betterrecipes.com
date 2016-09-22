<style>
.resetpwd {
  border: #acacac solid 1px;
  height: 21px;
  line-height: 21px;
  width: 25%;
  padding: 0 5px;
  background: #fff url(/img/bg-input-text.png) repeat-x top left;
  margin-bottom: 20px;
}
</style>
<div class="notice"></div>
<div class="article signout">
<? if (!empty($error) && $error) { ?>
<? if (!empty($error) && $error==3) { ?>
  <h3 style="text-transform: none;" class="title green mt20 mb20">Click <a href = '/signin?referrer=%2F'>here</a> to login.</h3>
<? } ?>

<? } else { ?>
  <h3 style="text-transform: none;" class="title green mt20 mb20">Are you sure you want to reset your password? Clicking 'Cancel' will do nothing.</h3>
<!--  <p class="mb20">You are currently logged in as: <php /*echo $sf_user->getDisplayName(); //*/ ?> - <?php /* echo $sf_user->getEmail(); //*/ ?></p>-->
  <form class="reg-form" action="<?=getDomainUri() . '/auth/reset' ?>" method="post" class="login mb20">
		<div>
		<label for="email" class="title mt20">Password:</label>
	  <input autofocus="autofocus" class= "resetpwd" type="text" name="password" value=""/><br/>
	<label for="verify" class="title mt20">Verify:</label>
	  <input class= "resetpwd" type="text" name="verify" value=""/>
	  </div>
    <fieldset>
	  <div class="error"><? if (!empty($issue) && $issue) { echo $issue; }?></div>
	  <input type="hidden" name="token" value="<?=$sf_request->getParameter('token', '');?>"/>
      <input type="submit" name="cancel" value="Cancel" class="btn-purple28" style="margin-right: 20px;" />
      <input type="submit" name="Reset" value="Reset" class="btn-purple28" style="margin-right: 0;" />
    </fieldset>
  </form>
<? } ?>
</div>