<? for ($i = 0; $i < count($comments); $i++): ?>
  <?
  switch ($i) {
    case 2 :
      $class = 'class = "last"';
      break;
    case 5 :
      $class = 'class = "last"';
      break;
    case 8 :
      $class = 'class = "last"';
      break;
    default :
      $class = '';
  }
  ?>
  <li <?= $class ?>>
    <a href="<?= getRoute('User', array('subdir' => $comments[$i]['username'])) ?>" class="img-wrap"><img src="<?= $comments[$i]['avatar'] ?>" height="75" width="75" alt="<?= $comments[$i]['display_name'] ?>" /></a>
    <div class="desc">
      <?= $comments[$i]['content'] ?>
      <p class="fs11 pt10">by <a href="<?= getRoute('User', array('subdir' => $comments[$i]['username'])) ?>" title="<?= $comments[$i]['display_name'] ?>"><?= $comments[$i]['display_name'] ?></a>, @ <?= $comments[$i]['created'] ?></p>
    </div>
  </li>
<? endfor; ?>
<? if ($comments_pager != ''): ?>
  <? if ($comments_pager->haveToPaginate()): ?>
    <? $currentPage = $comments_pager->getPage() ?>

    <? if ($currentPage < $comments_pager->getLastPage()): ?>
      <li class="pagination">
        <a style="margin-left:2%" onclick="ajaxPaginateComments('/comment/getcomments', '<?= $comments_pager->getNextPage() ?>', '<?= $contentId ?>')" title="Load more comments" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more comments</a>
      </li>
    <? endif; ?>
  <? endif; ?>
<? endif; ?>

