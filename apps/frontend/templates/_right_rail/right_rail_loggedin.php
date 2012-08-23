<div class="sidebar">
  <div id="rr_user_area"></div>
  <div class="ad300x250">
    <? include_partial('global/adtags/300x250') ?>
  </div><!-- /.ad300x250 -->
  <? include_component('recipes', 'rr_recipes', compact('rr_recipes')) ?>
  <? include_partial('global/right_rail/contest') ?>
  
  <? /* include_partial('global/right_rail/user_raves', compact('contentId', 'comments', 'user_id', 'profile', 'my_profile')) REMOVED DURING OPEN-GRAPH PROJECT */ ?>
  <? /* include_partial('global/right_rail/user_groups', compact('groups', 'profile', 'my_profile')) REMOVED DURING OPEN-GRAPH PROJECT */ ?>
  <? /* include_partial('global/right_rail/user_friends', compact('friends', 'profile')) REMOVED DURING OPEN-GRAPH PROJECT */ ?>
</div><!-- /.sidebar -->
<div class="clearfix"></div>
