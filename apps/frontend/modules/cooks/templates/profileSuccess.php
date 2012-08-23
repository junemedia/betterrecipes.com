<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div class="article">
  <? include_partial('detail', compact('user', 'my_profile')) ?>
  <? include_partial('recent_recipes', compact('user', 'my_profile')) ?>
  <? if (!empty($polls['items'])): ?> 
    <div id="my-polls">
      <p class="title"><?= ($my_profile ? 'My' : $user->getDisplayName()) ?> POLLS</p>
      <ul class="border-bottom">
        <? for ($i = 0; $i < count($polls['items']); $i++): ?>
          <li>
            <p><a href="<?= getRoute('@group_detail_polls_detail', array('category' => $polls['items'][$i]['category'], 'slug' => $polls['items'][$i]['group_slug'], 'poll_slug' => $polls['items'][$i]['poll_slug'], 'id' => $polls['items'][$i]['poll_id'])) ?>" title="<?= $polls['items'][$i]['title'] ?>"><?= $polls['items'][$i]['title'] ?></a></p>
            <p class="meta"><span><?= $polls['items'][$i]['num_votes'] ?></span>  Votes</p>
            <p class="fs11">by: <a href="<?= getRoute('User', array('subdir' => $polls['items'][$i]['subdir'])) ?>" title="<?= $polls['items'][$i]['display_name'] ?>"><?= $polls['items'][$i]['display_name'] ?></a></p>
          </li>
        <? endfor; ?>
      </ul>      
      <p class="cta-more">
        <? if (count($polls['items']) >= 5): ?>
          <a href="<?= getRoute('cook_profile_polls', $user) ?>" title="See more" class="purple">see more&raquo;</a>
        <? endif; ?>
      </p>
    </div>
  <? endif; ?>
</div><!-- /.section -->
<? include_partial('global/right_rail/right_rail_loggedin', compact('groups', 'friends', 'contentId', 'comments', 'user', 'profile', 'user_id', 'my_profile')) ?>
