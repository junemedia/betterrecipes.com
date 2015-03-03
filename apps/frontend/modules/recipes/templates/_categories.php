<div id="recland-list">
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