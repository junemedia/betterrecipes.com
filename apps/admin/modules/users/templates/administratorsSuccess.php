<script>
  $(document).ready(function(){    
    var placeholders = { email:"Enter Email" };
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
</script>

<div id="mainHeading">
  <h1>Admin Users</h1>
</div>


<!-- User Filtering -->
<div id="usersFilter" class="filterRow big"> 
  <div class="filter">
    <form method="get" action="<?= url_for('@administrators')?>">
      <input type="text" name="email" class="filterInput" id="emailInput" value="<?= !empty($email) ? $email : 'Enter Email' ?>" />
      <input type="submit" class="submit" id="emailSubmit" value="Filter" />
    </form>
  </div>
</div>
<!-- End User Filtering -->



<? if (isset($query)): ?>
	<? include_partial('paginator', array('pager' => $pager, 'link_to' => '@administrators', 'query' => $query)) ?>

<!-- User Headings -->
<div id="usersHeadings" class="headings big row">
  <ul>
    <li><span class="nosort email">Email</span></li>
    <li><span class="nosort dateAdded">Date Added</span></li>
    <li><span class="nosort active">Active</span></li>
    <li><span class="nosort active">Admin</span></li>
    <li><span class="nosort active">Super Admin</span></li>
  </ul>
</div> 
<!-- End User Headings -->

	<!-- User Results -->
	  <? $result = is_object($pager) ? $pager->getResults() : array() ?>
	  <ul class="results userSearchHeadings">
	    <? if (count($result) > 0): ?>
	      <? foreach ($result as $i => $user): ?>
	        <li class="row <?= ($i % 2) == 0 ? 'even' : 'odd'; ?> big" id="<?= $user->getId() ?>">
	          <? include_partial('admin_row', compact('user')) ?>
	        </li>
	      <? endforeach; ?>
	    <? else: ?>
	      <li class="row even big">
	        <span>
	          Your search has returned no results
	        </span>
	      </li>
	    <? endif; ?>
	  </ul>    
	  <!-- End User Results -->

	<? include_partial('paginator', array('pager' => $pager, 'link_to' => '@administrators', 'query' => $query)) ?>
<? endif; ?>



