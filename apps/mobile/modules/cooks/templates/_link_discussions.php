<? // if (!empty($discussions['items'])): ?>
<div class="discussions" id="discussions">
  <p class="header">
  	<a href="<? //= getRoute('cook_profile_discussions', $user) ?>#discussions" title="View <? //= ($my_profile ? 'my' : $user->getDisplayName()) ?>[user]'s discussions" >
      <span class="green"><? // = ($my_profile ? 'my' : $user->getDisplayName()) ?>[user]'s DISCUSSIONS</span>
      <span class="all">&gt;&gt; All</span>
    </a>
	</p>
</div><!-- /.discussions -->
<? // endif; ?>