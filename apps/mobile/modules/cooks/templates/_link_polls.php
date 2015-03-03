<? // if (!empty($polls['items'])): ?>
  <div class="polls">
  	<p class="header">
      <a href="<? //= getRoute('cook_profile_polls', $user) ?>#polls" title="View <? //= ($my_profile ? 'my' : $user->getDisplayName()) ?>[user]'s polls" >
        <span class="green"><? //= ($my_profile ? 'my' : $user->getDisplayName()) ?>[user]'s POLLS</span>
        <span class="all">&gt;&gt; All</span>
      </a>
    </p>
  </div><!-- /.polls -->
<? // endif; ?>