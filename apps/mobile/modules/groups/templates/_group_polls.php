<? if (sizeof($polls) > 0): ?>
	<? for ($i = 0; $i < count($polls); $i++): ?>
		<?
    if( ($i + 1) % 3 == 0){
    echo '<li class="last all-copy">';
    } else {
    echo '<li class="all-copy">';
    }
    ?>
    <a href="<?= getRoute('@group_detail_polls_detail', array('category' => $polls[$i]['category'], 'slug' => $polls[$i]['group_slug'], 'poll_slug' => $polls[$i]['poll_slug'], 'id' => $polls[$i]['poll_id'])) ?>" title="<?= $polls[$i]['title'] ?>"><?= $polls[$i]['title'] ?></a>
    <p>by <a href="<?= getRoute('User', array('subdir' => $polls[$i]['subdir'])) ?>" title="<?= $polls[$i]['display_name'] ?>"><?= $polls[$i]['display_name'] ?></a> | <? if ($polls[$i]['num_votes'] != '') { echo $polls[$i]['num_votes']; } else { echo '0'; } ?> Votes</p>
    </li>
  <? endfor; ?>
<? endif; ?>

<? if ($polls_pager != ''): ?>
  <? if ($polls_pager->haveToPaginate()): ?>
  <? $currentPage = $polls_pager->getPage() ?>
  
  <? if ($currentPage < $polls_pager->getLastPage()): ?>
  <li class="pagination">
  <a onclick="ajaxPaginatePollsGroups('#polls', '<?= url_for(@group_paginate_polls) ?>', '<?= $polls_pager->getNextPage() ?>', '<?= $poll_blog ?>')" title="Load more polls" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more polls</a>
  </li>
  <? endif; ?>
  <? endif; ?>
<? endif; ?>
