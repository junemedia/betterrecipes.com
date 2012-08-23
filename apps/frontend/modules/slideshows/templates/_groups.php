<? if (isset($groups['items'])): ?>
  <div id="popular-groups">
    <p class="title">POPULAR GROUPS</p>
    <ul>
      <? for ($i = 0; $i < count($groups['items']); $i++): ?>
        <li <? if (($i + 1) % 4 == false) {
      echo"class='mr0'";
    } ?>>
          <a href="<?= getRoute('@group_detail', array('category' => $groups['items'][$i]['category'], 'slug' => $groups['items'][$i]['slug'])) ?>" title="<?= $groups['items'][$i]['group_display_name'] ?>" class="imgmask150">
            <img src="<?= $groups['items'][$i]['group_photo'] ?>" alt="<?= $groups['items'][$i]['group_display_name'] ?>" />
          </a>
          <p><a href="<?= getRoute('@group_detail', array('category' => $groups['items'][$i]['category'], 'slug' => $groups['items'][$i]['slug'])) ?>" title="<?= $groups['items'][$i]['group_display_name'] ?>"><img src="/img/img-popgroups-arrow.png" height="23" width="8" /><?= Utilities::truncateHtml($groups['items'][$i]['group_display_name'], 20) ?><br />
              <span><?= $groups['items'][$i]['num_members'] ?> members</span></a></p>
          <div></div>
        </li>
  <? endfor; ?>
    </ul>
    <p class="cta-more"><a href="<?= getRoute('@search', array('page' => 'group')) ?>" title="See more popular groups" class="purple">see more&raquo;</a></p>
  </div><!-- /#popular-groups -->
<? endif; ?>