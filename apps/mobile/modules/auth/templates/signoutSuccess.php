<div class="article signout">
	<h3 style="text-transform: none;" class="title green mt20 mb20">Are you sure you want to log out?</h3>
  <p class="mb20">You are currently logged in as: <?= $sf_user->getDisplayName() ?> - <?= $sf_user->getEmail() ?></p>
  <? /*
  <p class="mb20">You will no longer be able to take advantage of your Member Benefits by logging out.</p>
	*/ ?>
  <form class="standard-form reg-form" action="<?= getSignoutUri() ?>" method="post">
    <fieldset>
      <input type="submit" name="cancel" value="Cancel" class="btn-purple28" style="margin-right: 20px;" />
      <input type="submit" name="signout" value="Log Out" class="btn-purple28" style="margin-right: 0;" />
    </fieldset>
  </form>
</div>