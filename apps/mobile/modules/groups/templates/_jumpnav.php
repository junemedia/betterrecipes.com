<div id="group-jumpbox">
  <form>
    <!--<input type="text" id="group-jumpbox-input" name="group-jumpbox-input" value="Jump to a page within this group" />-->
    <select name="group-jumpbox-select" id="group-jumpbox-select" onchange="location=this.options[this.selectedIndex].value;">
    	<option value="">Jump to a page within this group</option>
    	<option value="<?= url_for('@group_detail_members?slug=' . $sf_params->get('slug')) ?>">People</option>
    	<option value="<?= url_for('@group_detail_discussions?slug=' . $sf_params->get('slug')) ?>">Discussions</option>
    	<option value="<?= url_for('@group_detail_recipes?slug=' . $sf_params->get('slug')) ?>">Recipes</option>
    	<option value="<?= url_for('@group_detail_polls?slug=' . $sf_params->get('slug')) ?>">Polls</option>
    	<option value="<?= url_for('@group_detail_photos?slug=' . $sf_params->get('slug')) ?>">Photos</option>
    	<option value="<?= url_for('@group_detail_videos?slug=' . $sf_params->get('slug')) ?>">Videos</option>
    </select>
    <!--<input type="button" id="group-jumpbox-button" class="gray-btn" value="GO" /> -->
  </form>
</div><!-- /#jumpbox -->