<div style="position:relative; width:100%; height:0px; display:inline-block"></div>
<div id="recland-list" style="margin-top:15px">
  <? if (@$categories): ?>
  <ul class="imgleft border-bottom">
    <? foreach ($categories as $category): ?>
    <li>
      <? include_partial('main_category_block', compact('category')) ?>
    </li>
    <? endforeach; ?>
  </ul>
  <? endif; ?>
</div><!-- /#recland-list -->