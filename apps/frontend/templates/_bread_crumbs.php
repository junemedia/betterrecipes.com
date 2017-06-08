<? if (@$bread_crumbs): ?>
  <p id="breadcrumbs">
    <? foreach ($bread_crumbs as $title => $url): ?>
      <? if ($url): ?>
        <a href="<?= $url ?>" title="<?= $title ?>"><?= $title ?></a>&nbsp;/
      <? else: ?>
        <? $main_category = in_array($title, array('thanksgiving recipes', 'christmas recipes')) ? $title : null ?>
        <a title="Current page" class="last"><?= $title ?></a>
      <? endif; ?>
    <? endforeach; ?>
  </p>
<? endif; ?>
