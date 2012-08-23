<script>
  $(document).ready(function(){    
    var placeholders = { sponsorsName:"Sponsor Name" };
    //Set values of search textfields 
		$.each(placeholders, function(key, val) { 
			//Removes text on focus for textfield
			$('input[name='+key+']').focus(function(){
				if($(this).val() == val)
					$(this).val('');
			});
			//Replaces textfield with value if still empty
				$('input[name='+key+']').blur(function(){
				if ($(this).val() == '')
					$(this).val(val);
			});
    });    
  });	  
  
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
    
    var sponsorId = $(obj).parents("li").attr("id");
    
    //Recipe is Active - Change to inactive if user confirms
    var answer = confirm(msg);
    
    if (answer)      
      //Ajax to update active status
      $(obj).parents("li").load("<?= url_for('sponsors/updateActive')?>", {sponsorId:sponsorId, active:activeUpdate});      
    else 
      obj.checked = checked;      
  }
</script>

<div id="mainHeading">
  <h1>Recipe/Slideshow Sponsors</h1>
  <a href="<?php echo url_for('sponsors/new') ?>">Add Sponsor</a>
</div>

<!-- Filtering for URL -->
<? $currentFilter = ( $sf_params->has('sponsorName') ) ? '&sponsorName='.$sf_params->get('sponsorName') : ''; ?>
<? $currentFilterSort = $currentFilter; ?>
<? $currentFilterSort .= ( $sf_params->has('sort') ) ? '&sort='.$sf_params->get('sort') : ''; ?>
<? $currentFilterSort .= ( $sf_params->has('sortDir') ) ? '&sortDir='.$sf_params->get('sortDir') : ''; ?>
<!-- End Filtering for URL -->

<!-- Sponsor Filtering -->
<div id="sponsorsFilter" class="filterRow big"> 
  <div class="filter">
    <form method="get" action="<?= url_for('@sponsors_index')?>">
      <input type="text" name="sponsorsName" class="filterInput" id="sponsorsNameInput" value="<?= !empty($sponsorsName) ? $sponsorsName : 'Sponsor Name' ?>" />
      <input type="submit" class="submit" id="sponsorsNameSubmit" value="Filter" />
    </form>
  </div>
</div>
<!-- End Sponsor Filtering -->

<? //Sort Method to change the sorting direction
function getSortDirection($sortDir){
   if (!is_null($sortDir)){
       if ($sortDir == 'ASC')
         return 'DESC';
       else
         return 'ASC';
     } else 
         return "ASC";
   }
?>

<!-- Slideshow Headings -->
<div id="sponsorsHeadings" class="headings big row">
  <ul>
    <li><span class="name <? if ($sort == 'name') { echo ($sortDir == 'ASC') ? "asc" : "desc"; } ?>"><?= link_to('Sponsor Name', '@sponsors_index?page=1'.$currentFilter.'&sort=name&sortDir='.getSortDirection($sf_params->get('sortDir')), 'class=name') ?></span></li>
    <li><span class="image nosort">Image</span></li>
    <li><span class="dateAdded <? if (($sort == 'dateAdded') || (!isset($sort))) { echo ($sortDir == 'ASC' || (!isset($sort))) ? "asc" : "desc"; } ?>"><?= link_to('Date Added', '@sponsors_index?page=1'.$currentFilter.'&sort=dateAdded&sortDir='.getSortDirection($sf_params->get('sortDir')), 'class=dateAdded') ?></span></li>
    <li><span class="active <? if ($sort == 'active') { echo ($sortDir == 'ASC') ? "asc" : "desc"; } ?>"><?= link_to('Active', '@sponsors_index?page=1'.$currentFilter.'&sort=active&sortDir='.getSortDirection($sf_params->get('sortDir')), 'class=active') ?></span></li>
  </ul>
</div> 
<!-- End Slideshow Headings -->

<!-- Sponsor Results -->
<? foreach ($pager->getResults() as $i => $sponsor): ?>
  <ul id="sponsorsRows" class="results">
    <li class="row <?= ($i % 2) == 0 ? "even" : "odd"; ?> big" id="<?= $sponsor->getId() ?>">
      <span class="name"><a href="<?= url_for('sponsors/detail?id='.$sponsor->getId()) ?>"><?= $sponsor->getName() ?></a></span>
      <span class="image"></span>
      <span class="dateAdded"><?= date('m-d-y g:ma', strtotime($sponsor->getCreatedAt()))?></span>
      <span class="active">
        <input type="checkbox" id="active" value="<?= ($sponsor->getIsActive() == 1) ? "1" : "0"; ?>" <?= $sponsor->getIsActive() ? "checked='checked'" : ""; ?> onchange="changeActive(this)" />
      </span>
    </li>
  </ul>    
<? endforeach; ?>
<!-- End Sponsor Results -->

<!-- Bottom Pagination -->
<div class="paginationRow">
  <? if ($pager->haveToPaginate()): ?>
    <div class="pagination">
      <div class="pagination_link">
        <?= link_to('<<', '@sponsors_index?page='.$pager->getPreviousPage().$currentFilterSort) ?>
      </div>
      <? $links = $pager->getLinks(); foreach ($links as $page): ?>   
        <div class="pagination_link">
          <?= ($page == $pager->getPage()) ? $page : link_to($page, '@sponsors_index?page='.$page.$currentFilterSort) ?> 
        </div>
      <? endforeach; ?>
      <div class="pagination_link">
        <?= link_to('>>', '@sponsors_index?page='.$pager->getNextPage().$currentFilterSort) ?>
      </div>
    </div>
  <? endif; ?>
</div>
<!-- End Pagination -->