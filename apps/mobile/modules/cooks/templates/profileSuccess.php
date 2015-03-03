<? //include_partial('cooks/detail', compact('user', 'my_profile', 'makeFriend', 'user_id', 'points'))    ?>
<? include_partial('cooks/detail', compact('user', 'my_profile', 'makeFriend', 'user_id')) ?>
<div class="recipebox">
  <? if (count($recipes) > 0): ?>
    <div class="recipes">
      <p class="header"><a href="<?= getRoute('cook_profile_recipes', $user) ?>#recipes" title="View all recipes" ><span class="green"><?= ($my_profile ? 'MY' : ($user->getDisplayName() . '\'s')) ?> RECIPES</span><span class="all">&gt;&gt; All</span></a></p>
      <!-- recipes -->
      <ul>
        <? foreach ($recipes->getResults() as $r): ?>
          <li>
            <p><a href="<?= getUrl($r) ?>"><?= $r->getName() ?></a></p>
            <p><?= $r->getDescription() ?></p>
            <p class="fs11"><?= date('m/d/Y h:i A', strtotime($r->getCreatedAt())) ?></p>
          </li>
        <? endforeach; ?>
      </ul>
    </div><!-- /.recipes -->
  <? endif; ?>
  <!-- discussions -->
  <? if (!empty($discussions['items'])): ?>
    <div class="discussions">
      <p class="header"><a href="<?= getRoute('cook_profile_discussions', $user) ?>#discussions" title="View all discussions" ><span class="green"><?= ($my_profile ? 'MY' : ($user->getDisplayName() . '\'s')) ?> DISCUSSIONS</span><span class="all">&gt;&gt; All</span></a></p>
      <ul class="divider">
        <? for ($i = 0; $i < count($discussions['items']); $i++): ?>
          <?
          $params = array(
            'category' => $discussions['items'][$i]['category'],
            'slug' => $discussions['items'][$i]['group_slug'],
            'title' => $discussions['items'][$i]['slug'],
            'id' => $discussions['items'][$i]['thread_id']
          );
          ?>
          <li>
            <p><a href="<?= getRoute('@group_detail_discussions_detail', $params) ?>"><?= $discussions['items'][$i]['title'] ?></a></p>
            <p><?= $discussions['items'][$i]['last_post_content'] ?></p>
            <p class="fs11">On <?= $discussions['items'][$i]['created'] ?></p>
          </li>
        <? endfor; ?>
      </ul>
    </div><!-- /.discussions -->
  <? endif; ?>
  <!-- photos -->
  <? if (!empty($photos['items'])): ?>
    <div class="photos">
      <p class="header"><a href="<?= getRoute('cook_profile_photos', $user) ?>#photos" title="View all photos" ><span class="green"><?= ($my_profile ? 'MY' : ($user->getDisplayName() . '\'s')) ?>'s PHOTOS</span><span class="all">&gt;&gt; All</span></a></p>
      <ul class="img100left">
        <? for ($i = 0; $i < count($photos['items']); $i++): ?>
          <li>
            <a href="<?= getDomainUri() . url_for('@photo_detail?slug=' . $photos['items'][$i]['slug'] . '&id=' . $photos['items'][$i]['photo_id']) ?>" class="img-wrap"><img src="<?= $photos['items'][$i]['thumb_url'] ?>" alt="<?= $photos['items'][$i]['caption'] ?>" width="75" height="75" /></a>
            <p class="desc"><a href="<?= getDomainUri() . url_for('@photo_detail?slug=' . $photos['items'][$i]['slug'] . '&id=' . $photos['items'][$i]['photo_id']) ?>"><?= $photos['items'][$i]['caption'] ?></a></p>
          </li>
        <? endfor; ?>
      </ul>
    </div><!-- /.photos -->
  <? endif; ?>
  <!-- videos -->
  <? if (!empty($videos['items'])): ?>
    <div class="videos">
      <p class="header"><a href="<?= getRoute('cook_profile_videos', $user) ?>#videos" title="View all videos" ><span class="green"><?= ($my_profile ? 'MY' : ($user->getDisplayName() . '\'s')) ?> VIDEOS</span><span class="all">&gt;&gt; All</span></a></p>
      <ul class="img100left">
        <? for ($i = 0; $i < count($videos['items']); $i++): ?>
          <li>
            <a href="<?= getDomainUri() . url_for('@video_detail?slug=' . $videos['items'][$i]['slug'] . '&id=' . $videos['items'][$i]['video_id']) ?>" class="img-wrap"><img src="<?= $videos['items'][$i]['preview_url'] ?>" alt="<?= $videos['items'][$i]['title'] ?>" width="75" height="75" /></a>
            <p class="desc"><a href="<?= getDomainUri() . url_for('@video_detail?slug=' . $videos['items'][$i]['slug'] . '&id=' . $videos['items'][$i]['video_id']) ?>"><?= $videos['items'][$i]['title'] ?></a></p>
          </li>
        <? endfor; ?>
      </ul>
    </div><!-- /.videos -->
  <? endif; ?>
  <!-- journals -->
  <? if (!empty($journals['items'])): ?>
    <div class="journals">
      <p class="header"><a href="<?= getRoute('cook_profile_journals', $user) ?>#journals" title="View all journals" ><span class="green"><?= ($my_profile ? 'MY' : ($user->getDisplayName() . '\'s')) ?> JOURNALS</span><span class="all">&gt;&gt; All</span></a></p>
      <ul>
        <? for ($i = 0; $i < count($journals['items']); $i++): ?>
          <li>
            <p><a href="<?= getRoute('@journal_detail', array('slug' => $journals['items'][$i]['title_url'], 'id' => $journals['items'][$i]['post_id'])) ?>" title="<?= $journals['items'][$i]['title'] ?>"><?= $journals['items'][$i]['title'] ?></a></p>
            <p><?= $journals['items'][$i]['summary'] ?></p>
            <p class="fs11">by <a href="<?= getRoute('User', array('subdir' => $journals['items'][$i]['username'])) ?>" title="<?= $journals['items'][$i]['username'] ?>"><?= $journals['items'][$i]['display_name'] ?></a> @ <?= $journals['items'][$i]['date_created'] ?></p>
          </li>
        <? endfor; ?>
      </ul>
    </div><!-- /.journals -->
  <? endif; ?>
  <!-- polls -->
  <? if (!empty($polls['items'])): ?>
    <div class="polls">
      <p class="header"><a href="<?= getRoute('cook_profile_polls', $user) ?>#polls" title="View all polls" ><span class="green"><?= ($my_profile ? 'MY' : ($user->getDisplayName() . '\'s')) ?> POLLS</span><span class="all">&gt;&gt; All</span></a></p>
      <ul>
        <? for ($i = 0; $i < count($polls['items']); $i++): ?>
          <li>
            <p><a href="<?= getRoute('@group_detail_polls_detail', array('category' => $polls['items'][$i]['category'], 'slug' => $polls['items'][$i]['group_slug'], 'poll_slug' => $polls['items'][$i]['poll_slug'], 'id' => $polls['items'][$i]['poll_id'])) ?>" title="<?= $polls['items'][$i]['title'] ?>"><?= $polls['items'][$i]['title'] ?></a></p>
            <p><?= $polls['items'][$i]['num_votes'] ?> votes</p>
            <p class="fs11">by <a href="<?= getRoute('User', array('subdir' => $polls['items'][$i]['subdir'])) ?>" title="<?= $polls['items'][$i]['display_name'] ?>"><?= $polls['items'][$i]['display_name'] ?></a></p>
          </li>
        <? endfor; ?>
      </ul>
    </div><!-- /.polls -->
  <? endif; ?>
  <!-- groups -->
  <? if (isset($groups['items']) && count($groups['items']) > 0): ?>
    <div class="groups">
      <p class="header"><a href="<?= getRoute('cook_profile_groups', $user) ?>#groups" title="View all groups" ><span class="green"><?= ($my_profile ? 'MY' : ($user->getDisplayName() . '\'s')) ?> GROUPS</span><span class="all">&gt;&gt; All</span></a></p>
      <ul class="hor-list">
        <? $grp_counter = 1; ?>
        <? foreach ($groups['items'] as $g): ?>
          <?
          if ($grp_counter == 3) {
            echo'<li class="last">';
          } else if ($grp_counter == 1) {
            echo'<li class="first">';
          } else {
            echo'<li>';
          }
          ?>
          <a class="img-wrap" href="<?= getRoute('@group_detail', array('category' => $g['category'], 'slug' => $g['slug'])) ?>" title="<?= $g['group_display_name'] ?>"><img src="<?= $g['group_photo'] ?>" alt="<?= $g['group_name'] ?>" /></a>
          <p><a href="<?= getRoute('@group_detail', array('category' => $g['category'], 'slug' => $g['slug'])) ?>" title="<?= $g['group_display_name'] ?>"><?= $g['group_display_name'] ?></a></p>
          </li>
          <?
          $grp_counter++;
          if ($grp_counter == 4) {
            $grp_counter = 1;
          }
          ?>
        <? endforeach; ?>
      </ul>
    </div><!-- /.groups -->
  <? endif; ?>
  <!-- friends -->
  <? if (!empty($friends['items'])): ?>
    <div class="friends">
      <p class="header"><a href="<?= getRoute('cook_profile_friends', $user) ?>#friends" title="View all friends" ><span class="green"><?= ($my_profile ? 'MY' : ($user->getDisplayName() . '\'s')) ?> FRIENDS</span><span class="all">&gt;&gt; All</span></a></p>
      <ul class="hor-list">
        <? for ($i = 0; $i < count($friends['items']); $i++): ?>
          <?
          if ($i % 3 == 2) {
            echo'<li class="last">';
          } else if ($i % 3 == 0) {
            echo'<li class="first">';
          } else {
            echo'<li>';
          }
          ?>
          <a href="<?= getRoute('User', array('subdir' => $friends['items'][$i]['username'])) ?>" title="Click to view friend"><img src="<?= $friends['items'][$i]['user_avatar'] ?>" alt="<?= $friends['items'][$i]['display_name'] ?>" height="75" width="75" /></a>
          <p><a href="<?= getRoute('User', array('subdir' => $friends['items'][$i]['username'])) ?>" title="<?= $friends['items'][$i]['display_name'] ?>"><?= $friends['items'][$i]['display_name'] ?></a></p>
          </li>
        <? endfor; ?>
      </ul>
    </div><!-- /.friends -->
  <? endif; ?>
  <!-- raves -->
  <? if (!empty($comments)): ?>
    <div class="raves">
      <p class="header"><a href="<?= getRoute('cook_profile_raves', $user) ?>#raves" title="View all raves" ><span class="green"><?= ($my_profile ? 'MY' : ($user->getDisplayName() . '\'s')) ?> RAVES</span><span class="all">&gt;&gt; All</span></a></p>
      <ul>
        <? for ($i = 0; $i < count($comments); $i++): ?>
          <li>
            <p><a href="<?= getRoute('User', array('subdir' => $comments[$i]['username'])) ?>" title="<?= $comments[$i]['display_name'] ?>"><img src="<?= $comments[$i]['avatar'] ?>" alt="<?= $comments[$i]['display_name'] ?>" height="75" width="75" /></a></p>
            <p><a href="<?= getRoute('User', array('subdir' => $comments[$i]['username'])) ?>" title="<?= $comments[$i]['display_name'] ?>"><?= $comments[$i]['display_name'] ?></a></p>
            <p class="fs11"><?= $comments[$i]['created'] ?></p>
            <p><?= $comments[$i]['content'] ?></p>
          </li>
        <? endfor; ?>
      </ul>
    </div><!-- /.raves -->
  <? endif; ?>
</div><!-- /.recipebox -->