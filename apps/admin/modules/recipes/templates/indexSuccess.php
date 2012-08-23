<script>		
  $(document).ready(function(){    
    //Ajax for filtering - dynamic dropdowns
    $('#main_categories').change(function() {
      $("#subcategory").load("<?= url_for('recipes/updateSubcategory') ?>", {catid:this.value});
    });        
  });
  
  function changeActive(obj, cat_count){
    //Flip checked value 
    var checked = !obj.checked;
    if (checked){
      msg = "Are you sure you would like to make this inactive?";
      activeUpdate = 0;
    } else {
      msg = "Are you sure you would like to make this active?";
      activeUpdate = 1;
    }
    var recipeId = $(obj).parents("li").attr("id");    
    //Recipe is Active - Change to inactive if user confirms
    if(cat_count == 0 && activeUpdate == 1){
      obj.checked = false;
      alert("This recipe does not have a category and cannot be activated. Please contact ResoluteD");
    } else {
      var answer = confirm(msg);
      if (answer)
      //Ajax to update active status
        $.get("<?= url_for('recipes/updateActive') ?>", {recipeId:recipeId, active:activeUpdate});      
      else 
        obj.checked = checked;      
    }
  }  
</script>

<div id="mainHeading">
  <h1>Recipes</h1> 
</div>

<!-- Filtering Section -->
<div id="recipeFilter" class="filterRow big">
  <form method="get" action="<?= url_for('@recipes_index') ?>" > 
    <div id="mainCategory" class="filter">           
      <select name="main_categories" id="main_categories" class="main_categories" onchange="">
        <option value="">-- Category --</option>
        <? if (sizeof($categories) > 0): ?>        
          <? foreach ($categories as $category): ?>
            <option value="<?= $category->getId() ?>" <?= ($mainCat == $category->getId()) ? "Selected" : ""; ?>><?= $category->getName() ?></option>
          <? endforeach; ?>
        <? endif; ?>
      </select>
    </div>
    <div id="subcategory" class="filter">
      <? include_partial('subcategory', compact('subcategories', 'subCat')) ?>
    </div>
    <div id="username" class="filter">
      <label for="username" id="usernameLabel">Recipe By</label>
      <input type="text" name="username" id="usernameInput" value="<?= !empty($username) ? $username : 'username' ?>">
      <input type="submit" class="submit" id="usernameSubmit" value="Go" />
    </div> 
    <div id="keyword" class="filter">
      <label for="keywords" id="keywordLabel" >containing</label>
      <input type="text" name="keywords" id="recipeKeywordsInput" >
      <input type="submit" class="submit" id="keywordSubmit" value="Go" />
    </div>
  </form>
</div>
<!-- End Filtering Section -->

<!-- Filtering for URL -->
<? $currentFilter = ( $sf_params->has('main_categories') ) ? '&main_categories=' . $sf_params->get('main_categories') : ''; ?>
<? $currentFilter .= ( $sf_params->has('sub_categories') ) ? '&sub_categories=' . $sf_params->get('sub_categories') : ''; ?>
<? $currentFilter .= ( $sf_params->has('username') ) ? '&username=' . $sf_params->get('username') : ''; ?>
<? $currentFilter .= ( $sf_params->has('keywords') ) ? '&keywords=' . $sf_params->get('keywords') : ''; ?>
<? $currentFilterSort = $currentFilter; ?>
<? $currentFilterSort .= ( $sf_params->has('sort') ) ? '&sort=' . $sf_params->get('sort') : ''; ?>
<? $currentFilterSort .= ( $sf_params->has('sortDir') ) ? '&sortDir=' . $sf_params->get('sortDir') : ''; ?>
<!-- End Filtering for URL -->

<!-- Top Pagination -->
<div class="paginationRow">
  <? if ($pager->haveToPaginate()): ?>
    <div class="pagination">
      <div class="pagination_link">
        <?= link_to('<<', '@recipes_index?page=' . $pager->getPreviousPage() . $currentFilterSort) ?>
      </div>
      <? $links = $pager->getLinks() ?>
      <? foreach ($links as $page): ?>   
        <div class="pagination_link">
          <?= ($page == $pager->getPage()) ? $page : link_to($page, '@recipes_index?page=' . $page . $currentFilterSort) ?> 
        </div>
      <? endforeach; ?>
      <div class="pagination_link">
        <?= link_to('>>', '@recipes_index?page=' . $pager->getNextPage() . $currentFilterSort) ?>
      </div>
    </div>
  <? endif; ?>
</div>
<!-- End Pagination -->

<?

//Sort Method to change the sorting direction

function getSortDirection($sortDir)
{
  if (!is_null($sortDir)) {
    if ($sortDir == 'ASC')
      return 'DESC';
    else
      return 'ASC';
  } else
    return "ASC";
}
?>

<!-- Recipe Headings -->
<div id="recipeHeadings" class="headings big row">
  <ul>
    <li><span class="name <?
if ($sort == 'name') {
  echo ($sortDir == 'ASC') ? "asc" : "desc";
}
?>"><?= link_to('Recipe Name', '@recipes_index?page=1' . $currentFilter . '&sort=name&sortDir=' . getSortDirection($sf_params->get('sortDir')), 'class=name') ?></span></li>
    <li><span class="rating <?
              if ($sort == 'rating') {
                echo ($sortDir == 'ASC') ? "asc" : "desc";
              }
?>"><?= link_to('Rating', '@recipes_index?page=1' . $currentFilter . '&sort=rating&sortDir=' . getSortDirection($sf_params->get('sortDir')), 'class=rating') ?></span></li>
    <li><span class="dateAdded <?
              if (($sort == 'date') || (!isset($sort))) {
                echo ($sortDir == 'ASC' || (!isset($sort))) ? "asc" : "desc";
              }
?>"><?= link_to('Date Added', '@recipes_index?page=1' . $currentFilter . '&sort=date&sortDir=' . getSortDirection($sf_params->get('sortDir')), 'class=dateAdded') ?></span></li>
    <li><span class="dateEdited <?
              if (($sort == 'date_edited') || (!isset($sort))) {
                echo ($sortDir == 'ASC' || (!isset($sort))) ? "asc" : "desc";
              }
?>"><?= link_to('Date Edited', '@recipes_index?page=1' . $currentFilter . '&sort=date_edited&sortDir=' . getSortDirection($sf_params->get('sortDir')), 'class=dateEdited') ?></span></li>
    <li><span class="editedBy <?
              if (($sort == 'updated_by') || (!isset($sort))) {
                echo ($sortDir == 'ASC' || (!isset($sort))) ? "asc" : "desc";
              }
?>"><?= link_to('Edited By', '@recipes_index?page=1' . $currentFilter . '&sort=updated_by&sortDir=' . getSortDirection($sf_params->get('sortDir')), 'class=editedBy') ?></span></li>
    <li><span class="sponsor <?
              if ($sort == 'sponsor') {
                echo ($sortDir == 'ASC') ? "asc" : "desc";
              }
?>"><?= link_to('Sponsor', '@recipes_index?page=1' . $currentFilter . '&sort=sponsor&sortDir=' . getSortDirection($sf_params->get('sortDir')), 'class=sponsor') ?></span></li>
    <li><span class="active <?
              if ($sort == 'active') {
                echo ($sortDir == 'ASC') ? "asc" : "desc";
              }
?>"><?= link_to('Actv.', '@recipes_index?page=1' . $currentFilter . '&sort=active&sortDir=' . getSortDirection($sf_params->get('sortDir')), 'class=active') ?></span></li>
  </ul>  
</div>
<!-- End Recipe Headings -->

<!-- Recipe Results -->
<? $i = 0; ?>
<? foreach ($pager->getResults() as $i => $recipe): ?>
  <? $recipe_category_count = $recipe->getCategoryRecipe()->count() ?> 
  <ul id="recipeRows" class="results">
    <li class="row <?= ($i % 2) == 0 ? "even" : "odd"; ?> big" id="<?= $recipe->getId() ?>">
      <? if ($recipe_category_count > 0): ?>
        <span class="name"><a href="<?= url_for('recipes/detail?id=' . $recipe->getId()) ?>"><?= $recipe->getName() ?></a></span>
      <? else: ?>
        <? if ($recipe->getIsActive()): ?>
          <span class="name error"><a  class="error" href="<?= url_for('recipes/detail?id=' . $recipe->getId()) ?>"><?= $recipe->getName() ?></a> - FIX ME!</span>
        <? else: ?>
          <span class="name"><?= $recipe->getName() ?></span>
        <? endif; ?>
      <? endif; ?>
      <span class="rating">
        <div id="backgroundRating">
          <div id="fillRating" style="width:<?= $recipe->getRating() * 85 / 5 ?>px"></div>
        </div>        
      </span>
      <span class="dateAdded f11"><?= date('m-d-y g:ia', strtotime($recipe->getCreatedAt())) ?></span>
      <span class="dateEdited f11"><?= date('m-d-y g:ia', strtotime($recipe->getUpdatedAt())) ?></span>
      <span class="editedBy f11">
        <? if (is_null($recipe->getUpdatedById())): ?>
          N/A
        <? else: ?>
          <?= $recipe->getUpdatedBy()->getDisplayName() ?>
        <? endif; ?>
      </span>
      <span class="sponsor">
        <? if (is_null($recipe->getSponsorId())): ?>
          <? if ($recipe_category_count > 0): ?>
            <a onclick="addSponsor(this, '<?= url_for('recipes/addSponsor') ?>')">Add</a>
          <? endif; ?>
        <? else: ?>
          <?= $recipe->getSponsor()->getName() ?>
        <? endif; ?>
      </span>
      <span class="active">
        <input type="checkbox" id="active" value="<?= ($recipe->getIsActive() == 1) ? "1" : "0"; ?>" <?= $recipe->getIsActive() ? "checked='checked'" : ""; ?> onchange="changeActive(this, <?= $recipe_category_count ?>)" />
      </span>
    </li>
  </ul>
<? endforeach; ?>
<!-- End Recipe Results -->

<!-- Bottom Pagination -->
<div class="paginationRow">
  <? if ($pager->haveToPaginate()): ?>
    <div class="pagination">
      <div class="pagination_link">
        <?= link_to('<<', '@recipes_index?page=' . $pager->getPreviousPage() . $currentFilterSort) ?>
      </div>
      <? $links = $pager->getLinks() ?>
      <? foreach ($links as $page): ?>   
        <div class="pagination_link">
          <?= ($page == $pager->getPage()) ? $page : link_to($page, '@recipes_index?page=' . $page . $currentFilterSort) ?> 
        </div>
      <? endforeach; ?>
      <div class="pagination_link">
        <?= link_to('>>', '@recipes_index?page=' . $pager->getNextPage() . $currentFilterSort) ?>
      </div>
    </div>
  <? endif; ?>
</div>
<!-- End Pagination -->