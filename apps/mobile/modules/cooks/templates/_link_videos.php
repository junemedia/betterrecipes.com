<? //  if (!empty($videos['items'])): ?>
<div class="videos" id="videos">
  <p class="header">
    <a href="<? //= getRoute('cook_profile_videos', $user) ?>#videos" title="View <? //= ($my_profile ? 'my' : $user->getDisplayName()) ?>[user]'s videos" >
      <span class="green"><? //= ($my_profile ? 'my' : $user->getDisplayName()) ?>[user]'s VIDEOS</span>
      <span class="all">&gt;&gt; All</span>
    </a>
  </p>
</div><!-- /.videos -->
<? // endif; ?>