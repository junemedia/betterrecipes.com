<div id="jumpbox">
  <form>
    <!--<input type="text" id="jumpbox-input" name="jumpbox-input" value="Jump to a page" />-->
    <select name="jumpbox-select" id="jumpbox-select" onchange="location=this.options[this.selectedIndex].value;">
      <option value="">Jump to a page</option>
      <option value="<?= getDomainUri() . '/recipes' ?>">Recipes</option>
      <option value="<?= getDomainUri() . '/blogs/daily-dish' ?>">The Daily Dish</option>
      <option value="<?= getDomainUri() . '/contests' ?>">Contests</option>
      <option value="http://win.betterrecipes.com">Sweepstakes</option>
      <option value="<?= getDomainUri() . '/groups' ?>">Groups</option>
    </select>
    <!-- <input type="button" id="jumpbox-button" class="gray-btn" value="GO" /> -->
  </form>
</div><!-- /#jumpbox -->