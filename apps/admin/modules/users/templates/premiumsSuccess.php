<div id="mainHeading">
  <h1>Premium Users</h1>
</div>
<? include_partial('paginator', array('pager' => $pager, 'link_to' => '@premiums', 'query' => $query)) ?>
<!-- User Headings -->
<ul class="premiumUsers headings big row">
  <li><? include_partial('sorting_header', array('name' => 'email', 'title' => 'Email', 'class' => 'email')) ?></li>
  <li><? include_partial('sorting_header', array('name' => 'display_name', 'title' => 'Display Name', 'class' => 'displayName')) ?></li>
  <li><? include_partial('sorting_header', array('name' => 'created_at', 'title' => 'Date Added', 'class' => 'dateAdded')) ?></li>
  <li><? include_partial('sorting_header', array('name' => 'updated_at', 'title' => 'Date Edited', 'class' => 'dateAdded')) ?></li>
  <li><? include_partial('sorting_header', array('name' => 'is_active', 'title' => 'Active', 'class' => 'active')) ?></li>
</ul>
<!-- End User Headings -->
<!-- User Results -->
<? $result = is_object($pager) ? $pager->getResults() : array() ?>
<ul class="results premiumUsers">
  <? if (count($result) > 0): ?>
    <? foreach ($result as $i => $user): ?>
      <li class="row <?= ($i % 2) == 0 ? 'even' : 'odd'; ?> big" id="<?= $user->getId() ?>">
        <span class="email"><a href="<?= url_for('users/detail?id=' . $user->getOnesiteId()) ?>"><?= $user->getEmail() ?></a></span>
        <span class="displayName"><a href="<?= url_for('users/detail?id=' . $user->getOnesiteId()) ?>"><?= $user->getDisplayName() ?></a></span>
        <span class="dateAdded"><?= $user->getCreatedAt() ?></span>
        <span class="dateAdded"><?= $user->getUpdatedAt() ?></span>
        <span class="active">
          <?= $user->getIsActive() ? 'Yes' : 'No' ?>
        </span>
      </li>
    <? endforeach; ?>
  <? else: ?>
    <li class="row even big">
      <span>
        Your search has returned no results
      </span>
    </li>
  <? endif; ?>
</ul>    
<!-- End User Results -->
<? include_partial('paginator', array('pager' => $pager, 'link_to' => '@premiums', 'query' => $query)) ?>