<script>
  function updateKeywordVal(){
    keyword = "Enter " + $("#searchby option:selected").text();
    if ($("#keyword").val() == "" || $("#keyword").val().indexOf("Enter ") > -1){$("#keyword").val(keyword);}  
  }
  function updateUserStatus(obj){
    status = $(obj).is(':checked') ? 1 : 0;
    if($(obj).hasClass("is-active")){
      if(status == 1){
        answer = confirm("Are you sure? This will ENABLE the user")  
      } else {
        answer = confirm("Are you sure? This will DISABLE the user")
      }
      update_element = "is_active";
    } else {
      if(status == 1){
        answer = confirm("Are you sure? This will UPGRADE the user to PREMIUM level")  
      } else {
        answer = confirm("Are you sure? This will DOWNGRADE the user to REGULAR level")  
      }
      update_element = "is_premium";
    }
    if(answer){
      user_row = $(obj).parent().parent();
      user_row.load("<?= url_for('@update_user_status') ?>", {"user_id":user_row.attr("id"), "update_element":update_element, "status":status});  
    }
  }
  $(document).ready(function(){
    updateKeywordVal();
    $("#searchby").change(function(){
      updateKeywordVal();
    });
    $("#keyword").focus(function(){
      if($(this).val().indexOf("Enter ") > -1){$(this).val("");}
    });
    $("#search").click(function(){
      curr_keyword = $("#keyword").val();
      if(curr_keyword.indexOf("Enter ") > -1 || $.trim(curr_keyword) == ""){
        alert("Please enter a search criteria")
      } else {
        $(this).parent().submit();
      }
    });
    $("#keyword").blur(function(){
      if ($(this).val() == ""){$(this).val(keyword);}
    });
    $("#reset").click(function(){
      document.location.href = "<?= url_for('@users_index') ?>"
    });
  });    
</script>
<div id="mainHeading">
</div>
<!-- User Search -->
<div class="right">
  <form method="get" action="<?= url_for('@users_index') ?>" id="search_form">
    <label>Search Users: </label>
    <select name="searchby" id="searchby">
      <option value="email">Email</option>
      <option value="display_name"<? if ($sf_request->getParameter('searchby') == 'display_name'): ?> selected<? endif; ?>>Display Name</option>
    </select>
    <select name="method" id="method" >
      <option value="like">Contains</option>
      <option value="is"<? if ($sf_request->getParameter('method') == 'is'): ?> selected<? endif; ?>>Is Equal</option>
    </select>
    <input type="text" name="keyword" id="keyword"<? if ($sf_request->hasParameter('keyword')): ?> value="<?= $sf_request->getParameter('keyword') ?>"<? endif; ?> />
    <input type="button" class="submit" id="search" value="Search" />
    <input type="button" class="submit" id="reset" value="Reset" />
  </form>
</div>
<!-- End User Search -->
<? if (isset($query)): ?>
  <? include_partial('paginator', array('pager' => $pager, 'link_to' => '@users_index', 'query' => $query)) ?>
  <!-- User Headings -->
  <ul class="userSearchHeadings headings big row">
    <li><span class="nosort email">Email</span></li>
    <li><span class="nosort displayName">Display Name</span></li>
    <li><span class="nosort dateAdded">Date Added</span></li>
    <li><span class="nosort dateAdded">Date Edited</span></li>
    <li><span class="nosort active">Active</span></li>
    <li><span class="nosort active">Admin</span></li>
  </ul>
  <!-- End User Headings -->
  <!-- User Results -->
  <? $result = is_object($pager) ? $pager->getResults() : array() ?>
  <ul class="results userSearchHeadings">
    <? if (count($result) > 0): ?>
      <? foreach ($result as $i => $user): ?>
        <li class="row <?= ($i % 2) == 0 ? 'even' : 'odd'; ?> big" id="<?= $user->getId() ?>">
          <? include_partial('user_row', compact('user')) ?>
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
  <? include_partial('paginator', array('pager' => $pager, 'link_to' => '@users_index', 'query' => $query)) ?>
<? endif; ?>