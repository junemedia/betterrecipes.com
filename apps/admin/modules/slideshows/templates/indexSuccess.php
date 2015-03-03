<script>
  $(document).ready(function(){    
    var placeholders = { slideshowName:"Slideshow Name" };
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

  //Sponsor Dropdown
  function addSponsor(obj){  
    var id = $(obj).parents("li").attr("id");
    $(obj).parent().html(function(){ $(obj).parent().load("<?= url_for('slideshows/addSponsor') ?>", {slideshowId:id})});
  }
  
  //Sponsor Update
  function updateSponsor(obj, slideshowId){ 
    var sponsorId = obj.options[obj.selectedIndex].value;    
    $(obj).parent().html(function(){
      $(obj).parent().load("<?= url_for('slideshows/updateSponsor')?>", {slideshowId:slideshowId, sponsorId:sponsorId});
    });    
  }
  
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
    var slideshow = $(obj).parents("li");
    var slideshowId = $(obj).parents("li").attr("id");
    
    //Recipe is Active - Change to inactive if user confirms
    var answer = confirm(msg);
    
    if (answer)      
      //Ajax to update active status
      $.get("<?= url_for('slideshows/updateActive')?>", {slideshowId:slideshowId, active:activeUpdate});      
    else 
      obj.checked = checked;      
  }
</script>

<div id="mainHeading">
  <h1>Slideshows</h1>
  <a href="<?php echo url_for('slideshows/new') ?>">Add Slideshow</a>
</div>

<!-- Filtering for URL -->
<? $currentFilter = ( $sf_params->has('slideshowName') ) ? '&slideshowName='.$sf_params->get('slideshowName') : ''; ?>
<? $currentFilterSort = $currentFilter; ?>
<? $currentFilterSort .= ( $sf_params->has('sort') ) ? '&sort='.$sf_params->get('sort') : ''; ?>
<? $currentFilterSort .= ( $sf_params->has('sortDir') ) ? '&sortDir='.$sf_params->get('sortDir') : ''; ?>
<!-- End Filtering for URL -->

<!-- Slideshow Filtering -->
<div id="slideshowFilter" class="filterRow big"> 
  <div class="filter">
    <form method="get" action="<?= url_for('@slideshows_index')?>">
      <!--<select name="mainCat" id="mainCatInput">
        <option value="">-- Category --</option>
        <? //if (sizeof($categories) > 0): ?>
          <? //foreach ($categories as $c): ?>
            <option value="<?//= $c->getId() ?>" <?//= ($mainCat == $c->getId()) ? "Selected" : ""; ?>><?//= $c->getName() ?></option>
          <? //endforeach; ?>
        <? //endif; ?>
      </select>
      -->
      <input type="text" name="slideshowName" class="filterInput" id="slideshowNameInput" value="<?= !empty($slideshowName) ? $slideshowName : 'Slideshow Name' ?>"/>
      <input type="submit" class="submit" id="slideshowNameSubmit" value="Filter"/>
    </form>
  </div>
</div>
<!-- End Slideshow Filtering -->

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
<div id="slideshowHeadings" class="headings big row">
  <ul>
    <li><span class="name <? if ($sort == 'title') { echo ($sortDir == 'ASC') ? "asc" : "desc"; } ?>"><?= link_to('Slideshow Name', '@slideshows_index?page=1'.$currentFilter.'&sort=title&sortDir='.getSortDirection($sf_params->get('sortDir')), 'class=name') ?></span></li>
    <li><span class="category <? if ($sort == 'category') { echo ($sortDir == 'ASC') ? "asc" : "desc"; } ?>"><?= link_to('Category', '@slideshows_index?page=1'.$currentFilter.'&sort=category&sortDir='.getSortDirection($sf_params->get('sortDir')), 'class=category') ?></span></li>
    <li><span class="startDate <? if (($sort == 'startDate') || (!isset($sort))) { echo ($sortDir == 'ASC' || (!isset($sort))) ? "asc" : "desc"; } ?>"><?= link_to('Start Date', '@slideshows_index?page=1'.$currentFilter.'&sort=startDate&sortDir='.getSortDirection($sf_params->get('sortDir')), 'class=startDate') ?></span></li>
    <li><span class="endDate <? if ($sort == 'endDate') { echo ($sortDir == 'ASC') ? "asc" : "desc"; } ?>"><?= link_to('End Date', '@slideshows_index?page=1'.$currentFilter.'&sort=endDate&sortDir='.getSortDirection($sf_params->get('sortDir')), 'class=endDate') ?></span></li>
    <li><span class="sponsor <? if ($sort == 'sponsor') { echo ($sortDir == 'ASC') ? "asc" : "desc"; } ?>"><?= link_to('Sponsor', '@slideshows_index?page=1'.$currentFilter.'&sort=sponsor&sortDir='.getSortDirection($sf_params->get('sortDir')), 'class=sponsor') ?></span></li>
    <li><span class="active <? if ($sort == 'active') { echo ($sortDir == 'ASC') ? "asc" : "desc"; } ?>"><?= link_to('Active', '@slideshows_index?page=1'.$currentFilter.'&sort=active&sortDir='.getSortDirection($sf_params->get('sortDir')), 'class=active') ?></span></li>
  </ul>
</div> 
<!-- End Slideshow Headings -->
    
<!-- Slideshow Results -->
<? foreach ($pager->getResults() as $i => $slideshow): ?>
  <ul id="slideshowRows" class="results">
    <li class="row <?= ($i % 2) == 0 ? "even" : "odd"; ?> big" id="<?= $slideshow->getId() ?>">
      <span class="name"><a href="<?= url_for('slideshows/detail?id='.$slideshow->getId()) ?>"><?php echo $slideshow->getName() ?></a></span>
      <span class="category"><?= $slideshow->getCategory() ?></span>
      <span class="startDate"><?= date('m-d-y', strtotime($slideshow->getStartDate()))?></span>
      <span class="endDate"><?= date('m-d-y', strtotime($slideshow->getEndDate()))?></span>
      <span class="sponsor">
      <? if(is_null($slideshow->getSponsorId())) { ?>
          <a onclick="addSponsor(this)">Add</a>
        <? } else { ?>
          <?= $slideshow->getSponsor()->getName() ?>
        <? } ?>
      </span>
      <span class="active">
        <input type="checkbox" id="active" value="<?= ($slideshow->getIsActive() == 1) ? "1" : "0"; ?>" <?= $slideshow->getIsActive() ? "checked='checked'" : ""; ?> onchange="changeActive(this)" />
      </span>
    </li>
  </ul>    
<? endforeach; ?>
<!-- End Slideshow Results -->

<!-- Bottom Pagination -->
<div class="paginationRow">
  <? if ($pager->haveToPaginate()): ?>
    <div class="pagination">
      <div class="pagination_link">
        <?= link_to('<<', '@slideshows_index?page='.$pager->getPreviousPage().$currentFilterSort) ?>
      </div>
      <? $links = $pager->getLinks(); foreach ($links as $page): ?>   
        <div class="pagination_link">
          <?= ($page == $pager->getPage()) ? $page : link_to($page, '@slideshows_index?page='.$page.$currentFilterSort) ?> 
        </div>
      <? endforeach; ?>
      <div class="pagination_link">
        <?= link_to('>>', '@slideshows_index?page='.$pager->getNextPage().$currentFilterSort) ?>
      </div>
    </div>
  <? endif; ?>
</div>
<!-- End Pagination -->

