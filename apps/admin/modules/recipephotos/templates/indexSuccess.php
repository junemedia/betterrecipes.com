<div id="mainHeading">
  <h1>Recipe Photos - <?= $recipe->getName() ?></h1> 
  <a href="<?=url_for('recipes/index?id='.$recipe->getId())?>">Back to Recipes</a>
</div>


<script>
	$(function() {
		$( "#sortable" ).sortable();
	});
    
</script>

<form method="post">
<div id="photosContainer">
  <!-- Photos Results -->
  <ul id="sortable" class="photos">
    <? foreach ($photo as $i => $p): ?>
    <li>
      <input type="hidden" name="recipephotos_ids[]" value="<?= $p->getId() ?>" />
      <img src="<?= $p->getImgSrc('280x205') ?>" alt="<?= $p->getName() ?>" />
      <?//= link_to('Edit', 'recipephotos/edit?id='.$p->getId().'&recipe_id='.$recipe->getId()) ?>
      <?= link_to('Delete', 'recipephotos/delete?id='.$p->getId().'&recipe_id='.$recipe->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
    </li>
    
    <? endforeach; ?>
  </ul>
 <input type="submit" class="btn-grey28" value="Save Photo Order" />  

</form>


<form id="addNewPhoto" action="<?=url_for("recipephotos/new?recipe_id=".$recipe->getId()) ?>">
  <input type="submit" class="btn-grey28" value="Add Photo" />
</form>

</div>
