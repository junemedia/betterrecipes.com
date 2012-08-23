<div id="mainHeading">
  <h1>View User</h1>
</div>
<div id=userContainer" class="container">
  <div id="subHeading">
    <h2>General Details</h2>
    <form id="userSearch" action="<?= getRoute('users_edit', $user) ?>">
      <input type="submit" class="detail btn-grey28" value="Edit" />
    </form>
  </div>
  <div class="list">
    <ul>
      <li><span class="label">Meredith Profile Id</span><span class="data"><?= $user->getProfileId() ?></span></li>
      <li><span class="label">Email</span><span class="data"><?= $user->getEmail() ?></span></li>
      <li><span class="label">Display Name</span><span class="data"><?= $user->getDisplayName() ?></span></li>
      <li><span class="label">Is Active</span><span class="data"><? if ($user->getIsActive() == 1): ?>Yes<? else: ?>No<? endif; ?></span></li>
      <li><span class="label">Is Admin</span><span class="data"><? if ($user->getIsAdmin() == 1): ?>Yes<? else: ?>No<? endif; ?></span></li>
      <li><span class="label">Is Super Admin</span><span class="data"><? if ($user->getIsSuperAdmin() == 1): ?>Yes<? else: ?>No<? endif; ?></span></li>
    </ul>      
  </div>
</div> 