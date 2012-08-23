<div id="mainHeading">
  <h1>Recipe Categories</h1>  
</div>

<script type="text/javascript">
//Reload page on filtering selection
function reload(form) {    
	var page = 1;
	var filter = form.options[form.selectedIndex].value;  
	window.location = "<?php echo url_for('@category_index') ?>"+ '?page=' + page + '&filter=' + filter;
}

/*
  function changeActive(obj){
    //Flip checked value 
    var checked = !obj.checked;
    if (checked){
      msg = "Are you sure you would like to make this inactive?";
      activeUpdate = 0;
    } else {
      msg = "Are you sure you would like to make this Active?";
      activeUpdate = 1;
    }
    var categoryId = $(obj).parents("li").attr("id").replace('categoryRows', '');
    
    //Recipe is Active - Change to inactive if user confirms
    var answer = confirm(msg);
    if (answer)
      //Ajax to update active status
      $(obj).parents("li").load("<?//= url_for('categories/updateActive')?>", {categoryId:categoryId, active:activeUpdate});      
    else 
      obj.checked = checked;      
  }
  */
</script>
<? $currentFilter = ( $sf_params->has('filter') ) ? '&filter='.$sf_params->get('filter') : ''; ?>
<? $heading = ''; ?>
<? if ( $sf_params->has('filter') ) : ?>
	<? 
		switch( $sf_params->get('filter') ) {
			case '0' :
				$heading = 'Parent ';
			break;	
			case '1' :
				$heading = 'Child ';
			break;
			default :
				$heading = '';
		}
	?>
<? endif; ?>

<!-- Top Pagination -->

<?php if ($pager->haveToPaginate()): ?>
  <div class="paginationRow">
    <div class="pagination">
      <div class="pagination_link">
        <?php echo link_to('<<', '@category_index?page='.$pager->getPreviousPage().$currentFilter) ?>
      </div>

      <?php $links = $pager->getLinks(); foreach ($links as $page): ?>   
        <div class="pagination_link">
          <?php echo ($page == $pager->getPage()) ? $page : link_to($page, '@category_index?page='.$page.$currentFilter) ?> 
        </div>
      <?php endforeach ?>

      <div class="pagination_link">
        <?php echo link_to('>>', '@category_index?page='.$pager->getNextPage().$currentFilter) ?>
      </div>
    </div>
  </div>
<?php endif ?>
<!-- End Top Pagination -->

<!-- Filtering Row -->
<!-- Edit Form -->
<div id="categoryFilter" class="filterRow">
  <form method="post" action="<?=url_for('categories/sort')?>">
    <input type="submit" id="editSort" class="btn-grey28" value="Edit"/>
  </form>
</div>
<!-- End Filtering Row -->

<!-- Category Headings -->
<div id="categoryHeadings" class="headings row">
  <ul>
    <li>
      <span class="name nosort"><?=$heading?>Category Name</span>
      <!--
      <div id="categoryType">
        <select name="filter" id="categoryTypes" onchange="javascript:reload(this)">
          <option <?// if (empty($heading)) echo 'SELECTED' ?>       value="-1">All Recipe Categories</option>
          <option <?// if ($heading == 'Parent ') echo "SELECTED" ?> value="0" >Parent Categories Only</option>
          <option <?// if ($heading == 'Child ') echo 'SELECTED' ?>  value="1" >Children Categories Only</option>
        </select>      
      </div> -->
    </li>
    <li><span class="active nosort">Active</span></li>
  </ul>
</div>

<!-- Category Results -->
  <ul id="categoryRows" class="results">
    <? foreach ($pager->getResults() as $i => $category): ?>
    <li class="row <?= ($i % 2) == 0 ? "even" : "odd"; ?>" id="<?= $category->getId() ?>">
      <span class="name"><a href="<?= url_for('categories/'. ( $category->isMainCategory() ? 'detail' : 'edit').'?id='.$category->getId()) ?>"><?php echo $category->getName() ?></a></span>
      <span class="active">
        <?= ($category->getIsActive()) ? "Yes" : "No"; ?>
        <!--<input type="checkbox" class="activeCheckbox" value="<?//= ($category->getIsActive() == 1) ? "1" : "0"; ?>" <?//= $category->getIsActive() ? "checked='checked'" : ""; ?> onchange="changeActive(this)" />-->
      </span>
    </li>  
  <? endforeach; ?>
</ul>  
<!-- Pagination -->

<? if ($pager->haveToPaginate()): ?>
  <div class="paginationRow">
    <div class="pagination">
      <div class="pagination_link">
        <?= link_to('<<', '@category_index?page='.$pager->getPreviousPage().$currentFilter) ?>
      </div>
      <? $links = $pager->getLinks(); foreach ($links as $page): ?>   
        <div class="pagination_link">
          <?= ($page == $pager->getPage()) ? $page : link_to($page, '@category_index?page='.$page.$currentFilter) ?> 
        </div>
      <? endforeach ?>
      <div class="pagination_link">
        <?= link_to('>>', '@category_index?page='.$pager->getNextPage().$currentFilter) ?>
      </div>
    </div>
  </div>
<? endif ?>
