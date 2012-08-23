<? // if (!empty($friends['items'])): ?>
  <div class="friends" id="friends">
    <p class="header">
      <a href="<? //= getRoute('cook_profile_friends', $user) ?>#friends" title="View <? //= ($my_profile ? 'my' : $user->getDisplayName()) ?>[user]'s friends" >
        <span class="green"><? //= ($my_profile ? 'my' : $user->getDisplayName()) ?>[user]'s FRIENDS</span>
        <span class="all">&gt;&gt; All</span>
      </a>
    </p>
  </div><!-- /.friends -->
<? // endif; ?>