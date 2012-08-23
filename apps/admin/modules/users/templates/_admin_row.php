<span class="email" style="width:385px"><a href="<?= url_for('users/detail?id=' . $user->getId()) ?>"><?= $user->getEmail() ?></a></span>
<span class="dateAdded"><?= date('m-d-y', strtotime($user->getCreatedAt())) ?></span>
<span class="active"><? if ($user->getIsActive()): ?> Yes <? else: ?> No<? endif; ?></span>
<span class="active"><? if ($user->getIsAdmin()): ?> Yes <? else: ?> No<? endif; ?></span>
<span class="active"><? if ($user->getIsSuperAdmin()): ?> Yes <? else: ?> No<? endif; ?></span>