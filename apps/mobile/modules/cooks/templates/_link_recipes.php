<? // if (count($recipes) > 0): ?>
<div class="recipes" id="recipes">
  <p class="header">
    <a href="<? // = getRoute('cook_profile_recipes', $user) ?>#recipes" title="View <? // = ($my_profile ? 'my' : $user->getDisplayName()) ?>[user]'s recipes" >
    	<span class="green"><? // = ($my_profile ? 'my' : $user->getDisplayName()) ?>[user]'s RECIPES</span>
      <span class="all">&gt;&gt; All</span>
  	</a>
	</p>
</div><!-- /.recipes -->
<? // endif; ?>