<div class="recipebox">
	<div class="header">
    	<p class="green">MY RECIPE BOX</p>
    </div>
    <div id="saved-recipes">
	    <p class="title">saved recipes</p>
	    <? if (count($saved_recipes) > 0): ?>
	    <ul>
	    	<? include_partial('savedRecipeList', compact('saved_recipes')) ?>
	    </ul>
	    <? else: ?>
	    	<span>You do not have any saved recipes.</span>
	    <? endif; ?>
	</div><!-- /#saved-recipes -->
	
	
	<div id="personal-recipes">
	    <p class="title">my recipes</p>
	    <? if (count($personal_recipes) > 0): ?>
	    <ul>
	    	<? include_partial('personalRecipeList', compact('personal_recipes')) ?>
	    </ul>
	    <? else: ?>
	    	<span>You do not have any personal recipes.</span>
	    <? endif; ?>
    </div><!-- /#personal-recipes -->
</div>
