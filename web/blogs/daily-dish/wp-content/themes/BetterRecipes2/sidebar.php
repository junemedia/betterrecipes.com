<style>
#linkcat-2{
	display:none;
}
</style>
<div class="sidebar">
	<div class="sidebar-search">
		<?php/* get_search_form( $echo );*/ ?> 
  </div>
  <? include('ad-300x250.php'); ?>
 <ul>
  <!-- Widgetized sidebar, -->
  <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
  <?php endif; ?>
 </ul>
 <? include('ad-vsw.php'); ?>
</div>
