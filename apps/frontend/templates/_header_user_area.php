<? if ($sf_user->isAuthenticated()): ?>
  <li>
    <a href="<?= getUrl('User', $sf_user->getUserData()) ?>" title="View your Profile" class="first"><?= $sf_user->getDisplayName() ?></a>
  </li>
  <li><a href="<?= getSignoutUri() ?>" title="Log out">LOGOUT</a></li>
<? else: ?>
  <li><a href="<?= getSigninUri($sf_request->getParameter('referrer', '/')) ?>" title="Log into your Better Recipes account" class="first">LOGIN</a></li>
  <li><a href="<?= getSignupUri($sf_request->getParameter('referrer', '/')) ?>" title="Create your Better Recipes account" class="first">REGISTER</a></li>
  <li><a href="<?= getUrl('@add_recipe') ?>" title="Add you own recipe">ADD RECIPE</a></li>
<? endif; ?>