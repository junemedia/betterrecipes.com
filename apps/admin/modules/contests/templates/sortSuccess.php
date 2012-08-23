<div id="mainHeading">
  <h1>Active Contests</h1>  
</div>
<script>
  $(function() {
	$("#sortable").sortable();
  });    
</script>

<div id="categoryFilter" class="filterRow">
  <span><? if (isset($success)) echo $success ?></spam>
</div>

<div id="activeContests" class="container contests">
  <!-- Contest Headings -->
  <div id="activeHeadings" class="headings row contests">
    <ul>
       <li><span class="name nosort">Contest Name</span></li>
        <li><span class="startDate nosort">Start Date</span></li>                
        <li><span class="endDate nosort">End Date</span></li>
        <li><span class="sponsor nosort">Sponsor</span></li>
    </ul>
  </div>

  <!-- Contest Reordering Results -->
  <form id="sortContests" method="post" action="<?=url_for('contests/sort?sorted=true')?>">
    <div id="contestSorting">
      <ul id="sortable" class="contests">
        <? foreach ($pager->getResults() as $i => $c): ?>    
          <li>
            <input type="hidden" name="contest_ids[]" value="<?= $c->getId() ?>" />
            <span class="name"><?= $c->getName() ?></span>
            <span class="startDate"><?= date('m-d-y', strtotime($c->getStartDate()))?></span>
            <span class="endDate"><?= date('m-d-y', strtotime($c->getEndDate()))?></span>
            <span class="sponsor">
              <? if(is_null($c->getSponsorId())) { ?>
                <a onclick="addSponsor(this, '<?=url_for('contests/addSponsor')?>')">Add</a>
              <? } else { ?>
                <?= $c->getSponsor()->getName() ?>
              <? } ?>
            </span>
          </li>
        <? endforeach; ?>
      </ul> 
    </div>
    <input type="submit" id="saveSort" class="btn-grey28" value="Save"/>
  </form>
  <!-- End Contest Reordering Results -->
</div>