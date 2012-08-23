<? if ($sf_user->hasFlash('notice')): ?>
              <div class="flash notice" style="margin:20px 0; color:Red; float:left; display:block;">
                <?= $sf_user->getFlash('notice') ?>
              </div>
<? endif; ?>


<div id="mainHeading">
  <h1>Add New Poll</h1>
  <a href="<?= url_for("@polls_list") ?>">Back to Polls</a>
</div>
<br /><br />
<form name="savePoll" action="/admin/polls/new" method="post">
<table>
	<tr height="40px;">
		<td width="50%">Poll Title</td>
		<td><input type="text" style="width:250px" name="poll_title"></td>
	</tr>
	
	<?php
	/*
	<tr height="40px;">
		<td>Activate</td>
		<td><input type="checkbox" name="active" value="1" />
	</tr>
	<tr height="40px;">
		<td>Feature on Homepage</td>
		<td><input type="checkbox" name="homepage_featured" value="1" />
	</tr>
	*/
	?>
</table>
<div id="options_container">
  <table id="poll_options">
    <tr>
      <th>Option Title</th>
    </tr>
      <tr>
        <td>
        	Option Title: <input type="text" name="optionTitle[]" class="option_title" value="" /> 
        </td>
      </tr>
      
      
      <tr>
        <td>
        	Option Title: <input type="text" name="optionTitle[]" class="option_title" value="" /> 
        </td>
      </tr>


     <tr>
        <td>
        	Option Title: <input type="text" name="optionTitle[]" class="option_title" value="" /> 
        </td>
      </tr>



      <tr>
        <td>
        	Option Title: <input type="text" name="optionTitle[]" class="option_title" value="" /> 
        </td>
      </tr>

  </table>
</div>
<input class="detail btn-grey28" type="submit" value="Save And Go To Next Step">
</form>