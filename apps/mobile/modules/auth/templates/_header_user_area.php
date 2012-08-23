<div class="welcome">
<? if (sizeof($profile)>0): ?>
		<img src="<?=$profile['avatar_img']?>" height="75" width="75" alt="<?= $profile['display_name'] ?>" />
    <ul>
    	<li class="green fs15">Welcome <?= $profile['display_name'] ?></li>
        <li><a href="<?= getRoute('myrecipebox') ?>" title="Visit My Recipe Box">>> My Recipe Box</a></li>
        <li><a href="<?= getUrl($sf_user->getUser()) ?>" title="Visit My Profile">>> My Profile</a></li>
        <? /*<li><a href="<?= getSignoutUri() ?>" title="Log out">>> Logout</a></li>*/ ?>
    </ul>
<? else: ?>
	<ul>
		<li class="green fs15">Welcome to Better Recipes.com</li>
    <li>Already a Member? <a href="<?= getSigninUri() ?>#login" title="Log into your Better Recipes account" class="first">Log In</a></li>
    <? /* OLD VERSION: the new one is just anchors, because this version is redundant on sign in page, no?
		<li>Get Started Today! <a href="<?= getSigninUri() ?>" title="Log into your Better Recipes account" class="first">Log In</a> | <a href="<?= getSignupUri() ?>" title="Create your Better Recipes account">Register</a></li>
		*/ ?>
	</ul>
<? endif; ?>
</div><!-- /.welcome -->