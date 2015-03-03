<div id="mainHeading">
  <h1 style="float:left;">Wonders</h1>
  <a href="/admin/wonders/new" style="float:right;margin: 10px 0 0 0;">Add New General Wonder</a>
  <a href="/admin/wonders/category_new" style="float:right;margin:10px 20px 0 0;">Add New Category Wonder</a>
</div> 

<!-- Article Filtering -->
<div id="articlesFilter" class="filterRow big"> 
  <div class="filter">
      <select name="filter_type" onchange="location = '/admin/wonders?filter_type=' + escape(this.options[this.selectedIndex].value);">
      	<option value="general" <? if($filter_type == 'general'): ?> selected="selected"<? endif; ?>>General Wonders</option>
      	<option value="category" <? if($filter_type == 'category'): ?> selected="selected"<? endif; ?>>Category Wonders</option>
      </select>
  </div>
</div>
<!-- End Article Filtering --> 


<? if ( $filter_type == 'general' ): ?>
	<? include_partial('general_list', compact('filter_type', 'pager')) ?>
<? else: ?>
	<? include_partial('category_list', compact('filter_type', 'pager')) ?>
<? endif; ?>

