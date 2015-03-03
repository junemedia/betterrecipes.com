<div id="mainHeading">
  <h1>Recipe Categories</h1>  
</div>
<script>
  $(function() {
	$("#sortable").sortable();
  });    
</script>

<div id="categoryFilter" class="filterRow">
  <span><? if (isset($success)) echo $success ?></spam>
</div>

<!-- Category Headings -->
<div id="categoryHeadings" class="headings row">
  <ul>
    <li><span class="name nosort">Category Name</span></li>
    <li><span class="active nosort">Active</span></li>
  </ul>
</div>

<!-- Category Reordering Results -->
<form id="sortCategories" method="post" action="<?=url_for('categories/sort?sorted=true')?>">
  <div id="categorySorting">
    <ul id="sortable" class="categories">
      <? foreach ($pager->getResults() as $i => $c): ?>    
        <li>
          <input type="hidden" name="category_ids[]" value="<?= $c->getId() ?>" />
          <span class="name"><?= $c->getName() ?></span>
          <span class="active"><?= ($c->getIsActive()) ? "Yes" : "No"; ?></span>
        </li>
      <? endforeach; ?>
    </ul> 
  </div>
  <input type="submit" id="saveSort" class="btn-grey28" value="Save"/>
</form>
<!-- End Category Reodering Results -->