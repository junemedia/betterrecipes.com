<? // if (!empty($photos['items'])): ?>
<div class="photos" id="photos">
  <p class="header">
  	<a href="<? // = getRoute('cook_profile_photos', $user) ?>#photos" title="View <? //= ($my_profile ? 'my' : $user->getDisplayName()) ?>[user]'s photos" >
      <span class="green"><? //= ($my_profile ? 'my' : $user->getDisplayName()) ?>[user]'s PHOTOS</span>
      <span class="all">&gt;&gt; All</span>
    </a>
  </p>
</div><!-- /.photos -->
<? // endif; ?>