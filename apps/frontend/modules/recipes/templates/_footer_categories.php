<div class="nav pt20 pb20" id="ftr-reccats">
  <div class="title">RECIPE CATEGORIES</div>
  <div class="links">
    <? foreach ($footer_categories as $category_column): ?>
      <ul>
        <? foreach ($category_column as $key => $category): ?>
          <li><? if ($key > 0): ?>&nbsp;|&nbsp;<? endif; ?><a href="<?= getUrl($category) ?>" title="<?= $category->getName() ?>"><?= $category->getName() ?></a></li>
        <? endforeach; ?>
      </ul>
    <? endforeach; ?>
  </div>
</div><!-- /.nav -->
