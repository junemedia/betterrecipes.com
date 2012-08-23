<div id="sidebar-recipes">
  <p class="title">POPULAR RECIPES</p>
  <? if (@$rr_recipes): ?>
    <ul>
      <? foreach ($rr_recipes as $recipe): ?>
        <li>
          <p><a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>"><?= Utilities::truncateHtml($recipe->getName(), 45) ?></a></p>
        </li>
      <? endforeach; ?>
    </ul>
  <? endif; ?>
</div><!-- /#sidebar-recipes -->
