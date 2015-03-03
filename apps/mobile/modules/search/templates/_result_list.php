<? for ($i = 0; $i < count($results); $i++): ?>
	<? if ($type == 'Recipe'): ?>
		
		<li>
	    	<p class="rating-wrap"><span class="rating"><span class="rate<?= $results[$i]['rating'] ?>"></span></span><a baynote_bnrank="<?=$results[$i]['baynote_bnrank']?>" baynote_irrank="<?=$results[$i]['baynote_irrank']?>" href="<?= $results[$i]['url'] ?>" title="<?= $results[$i]['title'] ?>"><?= $results[$i]['title'] ?></a></p>
	        <p class="fs11"><? if ($results[$i]['subdir'] != ''): ?>by <a href="<?= getRoute('User', array('subdir' => $results[$i]['subdir'])) ?>" title="<?= $results[$i]['display_name'] ?>"><?= $results[$i]['display_name'] ?></a><? endif; ?></p>
	    </li>
	    
	<? elseif ($type == 'member'): ?>
		<li>
	    	<p><a baynote_bnrank="<?=$results[$i]['baynote_bnrank']?>" baynote_irrank="<?=$results[$i]['baynote_irrank']?>" href="<?= $results[$i]['url'] ?>" title="<?= $results[$i]['display_name'] ?>"><img src="<?= $results[$i]['avatar'] ?>" alt="<?= $results[$i]['display_name'] ?>" /></a></p>
	        <p class="fs11"><a baynote_bnrank="<?=$results[$i]['baynote_bnrank']?>" baynote_irrank="<?=$results[$i]['baynote_irrank']?>" href="<?= $results[$i]['url'] ?>" title="<?= $results[$i]['display_name'] ?>"><?= $results[$i]['display_name'] ?></a></p>
	    </li>
	    
	<? elseif ($type == 'group'): ?>
		<li>
	    	<p><a baynote_bnrank="<?=$results[$i]['baynote_bnrank']?>" baynote_irrank="<?=$results[$i]['baynote_irrank']?>" href="<?= $results[$i]['url'] ?>" title="<?= $results[$i]['title'] ?>"><img src="<?= $results[$i]['avatar'] ?>" alt="<?= $results[$i]['title'] ?>" /></a></p>
	        <p class="fs11"><a baynote_bnrank="<?=$results[$i]['baynote_bnrank']?>" baynote_irrank="<?=$results[$i]['baynote_irrank']?>" href="<?= $results[$i]['url'] ?>" title="<?= $results[$i]['title'] ?>"><?= $results[$i]['title'] ?></a></p>
	    </li>
	    
	<? elseif ($type == 'photo'): ?>
		<li>
	    	<p><a baynote_bnrank="<?=$results[$i]['baynote_bnrank']?>" baynote_irrank="<?=$results[$i]['baynote_irrank']?>" href="<?= $results[$i]['url'] ?>" title="<?= $results[$i]['title'] ?>"><?= $results[$i]['title'] ?></a></p>
	    </li>
	    
	<? elseif ($type == 'discussion'): ?>
		<li>
	    	<p><a baynote_bnrank="<?=$results[$i]['baynote_bnrank']?>" baynote_irrank="<?=$results[$i]['baynote_irrank']?>" href="<?= $results[$i]['url'] ?>" title="<?= $results[$i]['title'] ?>"><?= $results[$i]['title'] ?></a></p>
	    </li>
	    
		<? elseif ($type == 'video'): ?>
			<li>
	    	<p><a baynote_bnrank="<?=$results[$i]['baynote_bnrank']?>" baynote_irrank="<?=$results[$i]['baynote_irrank']?>" href="<?= $results[$i]['url'] ?>" title="<?= $results[$i]['title'] ?>"><?= $results[$i]['title'] ?></a></p>
	    </li>
	    
	<? elseif ($type == 'journals'): ?>
		<li>
	    	<p><a baynote_bnrank="<?=$results[$i]['baynote_bnrank']?>" baynote_irrank="<?=$results[$i]['baynote_irrank']?>" href="<?= $results[$i]['url'] ?>" title="<?= $results[$i]['title'] ?>"><?= $results[$i]['title'] ?></a></p>
	    </li>
	    
	<? elseif ($type == 'poll'): ?>
		<li>
	    	<p><a baynote_bnrank="<?=$results[$i]['baynote_bnrank']?>" baynote_irrank="<?=$results[$i]['baynote_irrank']?>" href="<?= $results[$i]['url'] ?>" title="<?= $results[$i]['title'] ?>"><?= $results[$i]['title'] ?></a></p>
	    </li>
	    
	<? elseif ($type == 'blogs'): ?>
		<li>
	    	<p><a baynote_bnrank="<?=$results[$i]['baynote_bnrank']?>" baynote_irrank="<?=$results[$i]['baynote_irrank']?>" href="<?= $results[$i]['url'] ?>" title="<?= $results[$i]['title'] ?>"><?= $results[$i]['title'] ?></a></p>
	    </li>
	    
	<? endif; ?>
<? endfor; ?>




<? if ($results_pager != ''): ?>
	<? if ($results_pager->haveToPaginate()): ?>
		<? $currentPage = $results_pager->getPage() ?>
		<? if ($currentPage < $results_pager->getLastPage()): ?>	
			<li class="pagination">
				<a onclick="ajaxPaginateSearch('#result-list', '/search/paginate_search', '<?=$results_pager->getNextPage()?>', '<?=$term?>', '<?=$pagetype?>', '<?=$rating?>', '<?=$category?>', '<?=$subcategory?>', '<?=$with?>', '<?=$without?>', '<?=$type?>', '<?=$attrsort?>')" title="Load more search results">Load more search results</a>
			</li>
		<? endif; ?>
	<? endif; ?>
<? endif; ?>

