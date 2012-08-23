<? // if (!empty($journals['items'])): ?>
<div class="journals" id="journals">
  <p class="header">
    <a href="<? //= getRoute('cook_profile_journals', $user) ?>#journals" title="View <? //= ($my_profile ? 'my' : $user->getDisplayName()) ?>[user]'s journals" >
      <span class="green"><? //= ($my_profile ? 'my' : $user->getDisplayName()) ?>[user]'s JOURNALS</span>
      <span class="all">&gt;&gt; All</span>
    </a>
  </p>
</div><!-- /.journals -->
<? // endif; ?>