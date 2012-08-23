<div class="header">
  <p class="green">DISCUSSION DETAIL</p>
</div>

<!-- THREAD INFO START -->
<div class="thread-detail">
  <img src="<?= $thread['user_avatar'] ?>" alt="<?= $thread['display_name'] ?>" />
  <aside>
    <p><?= $thread['title'] ?></p>
    <div id="content" class="comment"><?= $thread['content'] ?></div>
    <p class="fs11">by <a href="<?= getRoute('User', array('subdir' => $thread['username'])) ?>"><?= $thread['display_name'] ?></a></p>
  </aside>
</div>
<!-- THREAD INFO END -->
