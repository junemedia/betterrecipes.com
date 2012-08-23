<? // if (!empty($comments)): ?>
  <div class="raves" id="raves">
    <p class="header">
      <a href="<? //= getRoute('cook_profile_raves', $user) ?>#raves" title="View <? //= ($my_profile ? 'my' : $user->getDisplayName()) ?>[user]'s raves" >
        <span class="green"><? //= ($my_profile ? 'my' : $user->getDisplayName()) ?>[user]'s RAVES</span>
        <span class="all">&gt;&gt; All</span>
      </a>
    </p>
  </div><!-- /.raves -->
<? // endif; ?>