<div id="rr_user_area"></div>
<div class="ad300x250">
  <? include_partial('global/adtags/300x250') ?>
</div><!-- /.ad300x250 -->
<div class="side-bar">
      <form id="side-search">
        <input onKeyPress="return disableEnterKey(event)" type="text" value="Search the daily dish" name="dish-term" id="dishTerm" onFocus="clearText(this)" onBlur="clearText(this)" />
        <input type="button" value="SEARCH" class="btn-grey28" onclick="submitSearchDish();" />
      </form>
</div><!-- /.side-bar -->