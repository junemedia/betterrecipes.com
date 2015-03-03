<span class="email"><a href="<?= url_for('users/detail?id=' . $user->getId()) ?>"><?= $user->getEmail() ?></a></span>
<span class="displayName"><a href="<?= url_for('users/detail?id=' . $user->getId()) ?>"><?= $user->getDisplayName() ?></a></span>
<span class="dateAdded"><?= $user->getCreatedAt() ?></span>
<span class="dateAdded"><?= $user->getUpdatedAt() ?></span>
<span class="active"><input type="checkbox"<? if ($user->getIsActive()): ?> checked <? endif; ?> class="is-active" onchange="updateUserStatus(this)"/></span>
<span class="active"><? if ($user->getIsAdmin()): ?>Yes<? else: ?>No<? endif; ?></span>