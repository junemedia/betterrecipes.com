<? if (isset($groups) && sizeof($groups) > 0): ?>
  <? $group = $groups['items'] ?>
  <div id="my-groups">
    <label>Share this recipe with your groups!</label>
    <ul>
      <?
      for ($i = 0; $i < count($group); $i++):
        if (!$sf_request->isMethod('get')) {
          $checked = array_key_exists($group[$i]['group_id'], $sf_request->getParameter('group_ids', array())) ? true : false;
        } else {
          if ($is_new_form) {
            $group_ids = $sf_request->getParameter('group_ids', array());
            if (!is_array($group_ids)) {
              $group_ids = explode('-', $group_ids);
            }
            $checked = in_array($group[$i]['group_id'], $group_ids) ? true : false;
          } else {
            $checked = $recipe->isInGroup($group[$i]['group_id']);
          }
        }
        ?>
        <li>
          <p class="group-title"><input type="checkbox" name="group_ids[<?= $group[$i]['group_id'] ?>]" <? if ($checked): ?> checked<? endif; ?>/>&nbsp;<a href="<?= getRoute('@group_detail', array('category' => $group[$i]['category'], 'slug' => $group[$i]['slug'])) ?>" title="<?= $group[$i]['group_display_name'] ?>"><?= Utilities::truncateHtml($group[$i]['group_display_name'], 20) ?></a></p>
          <p class="fs11 ml25"><?= $group[$i]['num_members'] ?> members</p>
        </li>
      <? endfor; ?>
    </ul>
  </div>
<? endif; ?>