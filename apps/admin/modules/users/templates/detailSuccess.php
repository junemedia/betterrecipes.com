<script>
	function updateRecipeFeaturedStatus(obj, id) {
		var status = $(obj).is(':checked') ? 1 : 0;
		$.post('<?= url_for('@update_featured_recipe') ?>', { id: id, is_featured: status });
	}
</script>

<div id="mainHeading">
  <h1>View User</h1>
</div>
<div id=userContainer" class="container">
  <div id="subHeading">
    <h2>General Details</h2>
    <form id="userSearch" action="<?= getRoute('users_edit', $user) ?>">
      <input type="submit" class="detail btn-grey28" value="Edit" />
    </form>
  </div>
  <div class="list">
    <ul>
      <li><span class="label">Meredith Profile Id</span><span class="data"><?= $user->getProfileId() ?></span></li>
      <li><span class="label">Email</span><span class="data"><?= $user->getEmail() ?></span></li>
      <li><span class="label">Display Name</span><span class="data"><?= $user->getDisplayName() ?></span></li>
      <li><span class="label">Is Active</span><span class="data"><? if ($user->getIsActive() == 1): ?>Yes<? else: ?>No<? endif; ?></span></li>
      <li><span class="label">Is Admin</span><span class="data"><? if ($user->getIsAdmin() == 1): ?>Yes<? else: ?>No<? endif; ?></span></li>
      <li><span class="label">Is Super Admin</span><span class="data"><? if ($user->getIsSuperAdmin() == 1): ?>Yes<? else: ?>No<? endif; ?></span></li>
      <li><span class="label">Is Featured Blogger</span><span class="data"><? if ($user->getIsFeaturedBlogger() == 1): ?>Yes<? else: ?>No<? endif; ?></span></li>
    </ul>      
  </div>
</div> 

<? if ($user->getIsFeaturedBlogger() == 1): ?>
	<h2 style="margin-bottom:20px">Select Featured Blogger Recipes:</h2>
		<ul class="userSearchHeadings headings big row">
	    <li><span class="nosort email" style="width:450px">Recipe</span></li>
	    <li><span class="nosort displayName">Dated Added</span></li>
	    <li><span class="nosort dateAdded">Is Featured</span></li>
	  </ul>
		<ul class="results userSearchHeadings">
			<? if ( isset($user_recipes) && sizeof($user_recipes) > 0 ): ?>
				<? foreach ($user_recipes as $i => $recipe): ?>
					<li class="row <?= ($i % 2) == 0 ? 'even' : 'odd'; ?> big" id="<?= $recipe->getId() ?>">
						<span class="displayName" style="width:450px"><a href="<?= getUrl($recipe) ?>" target="_blank"><?= $recipe->getName() ?></a></span>
						<span class="dateAdded"><?= date('m/d/Y', strtotime($recipe->getCreatedAt())) ?></span>
					    <span class="active" style="text-align:right"><input type="checkbox"<? if ($recipe->getIsFeatured()): ?> checked <? endif; ?> class="is-active" onchange="updateRecipeFeaturedStatus(this, <?= $recipe->getId() ?>)"/></span>
					</li>
				<? endforeach; ?>
			<? else: ?>
		      <li class="row even big">
		        <span>
		          User has not posted any recipes
		        </span>
		      </li>
			  <? endif; ?>
		</ul>
<? endif; ?>