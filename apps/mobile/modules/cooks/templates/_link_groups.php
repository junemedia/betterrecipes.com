<? // if (count($groups['items']) > 0): ?>
<div id="groups" class="groups">
  <p class="header">
    <a href="<? //= getRoute('cook_profile_groups', $user) ?>#groups" title="See All <? //= ($my_profile ? 'my' : $user->getDisplayName()) ?>[user]'s Groups">
      <span class="green"><? //= ($my_profile ? 'my' : $user->getDisplayName()) ?>[user]'s GROUPS</span>
      <span class="all">&gt;&gt; All</span>
    </a>
  </p>
</div><!-- /.groups -->
<? // endif; ?>