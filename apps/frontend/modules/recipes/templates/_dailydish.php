<? if (sizeof($dish_items)>0): ?>

<div class="daily-dish">
    <p class="title"><?=$category->getName()?> FROM THE DAILY DISH</p>
  
  <div class="sorting shift-right">
  	<ul class="pager hornav">
  		<? if ($dish_pager->haveToPaginate()): ?>
  			
  			<? $currentPage = $dish_pager->getPage() ?>
  			
  			<? if ($currentPage == 1): ?><li class="unavailable"><? else: ?><li><? endif; ?>
              <a style="cursor:pointer" onclick="ajaxPaginateDailyDishList('<?=url_for('@daily_dish_ajax_list')?>', <?=$dish_pager->getPreviousPage()?>, '<?=$dish_tag?>')">&laquo;</a>
            </li>

            <? $links = $dish_pager->getLinks();
            foreach ($links as $page): ?>
            	<?= ($page == $dish_pager->getPage()) ? '<li class="active"><a>' . $page . '</a></li>' : '<li><a style="cursor:pointer" onclick="ajaxPaginateDailyDishList(\''.url_for('@daily_dish_ajax_list').'\', '.$page.', \''.$dish_tag.'\')">' . $page . '</a></li>' ?>
            <? endforeach ?>

    <? if ($currentPage == $dish_pager->getCurrentMaxLink()): ?><li class="unavailable"><? else: ?><li><? endif; ?>
    		<a style="cursor:pointer" onclick="ajaxPaginateDailyDishList('<?=url_for('@daily_dish_ajax_list')?>', <?=$dish_pager->getNextPage()?>, '<?=$dish_tag?>')">&raquo;</a>
            </li>
  			
  		<? endif ?>
  	</ul>
  </div><!-- /.sorting -->	
	<ul class="dd-list-ajax">
		
		<? for ($i = 0; $i < count($dish_items); $i++): ?>
		<li>
			<p>
			<a href="<?=getRoute('@daily_dish_detail', array('year' => $dish_items[$i]['link'][0][0], 'month' => $dish_items[$i]['link'][0][1], 'day' => $dish_items[$i]['link'][0][2], 'slug' => $dish_items[$i]['link'][0][3]))?>">
			<?=$dish_items[$i]['title']?>
			</a>
			</p>
			<p class="fs11">
				Posted <?=$dish_items[$i]['pubDate']?> by <?=$dish_items[$i]['author']?>
					<? /* | <a href="<?=getRoute('@daily_dish_detail', array('comment' => 1, 'year' => $dish_items[$i]['link'][0][0], 'month' => $dish_items[$i]['link'][0][1], 'day' => $dish_items[$i]['link'][0][2], 'slug' => $dish_items[$i]['link'][0][3]))?>">Post a comment</a> */ ?>
			</p>
            <p><?=$dish_items[$i]['description']?></p>
            
            		<? /*
					<p>
						<a class="btn-grey28" title="Post A Comment" href="<?=getRoute('@daily_dish_detail', array('comment' => 1, 'year' => $dish_items[$i]['link'][0][0], 'month' => $dish_items[$i]['link'][0][1], 'day' => $dish_items[$i]['link'][0][2], 'slug' => $dish_items[$i]['link'][0][3]))?>">POST A COMMENT</a>
					</p>
					*/ ?>
            
		</li>
	<? endfor; ?>
					
    </ul>
  <div class="sorting">
  	<ul class="pager hornav">
  		<? if ($dish_pager->haveToPaginate()): ?>
  			
  			<? $currentPage = $dish_pager->getPage() ?>
  			
  			<? if ($currentPage == 1): ?><li class="unavailable"><? else: ?><li><? endif; ?>
              <a style="cursor:pointer" onclick="ajaxPaginateDailyDishList('<?=url_for('@daily_dish_ajax_list')?>', <?=$dish_pager->getPreviousPage()?>, '<?=$dish_tag?>')">&laquo;</a>
            </li>

            <? $links = $dish_pager->getLinks();
            foreach ($links as $page): ?>
            	<?= ($page == $dish_pager->getPage()) ? '<li class="active"><a>' . $page . '</a></li>' : '<li><a style="cursor:pointer" onclick="ajaxPaginateDailyDishList(\''.url_for('@daily_dish_ajax_list').'\', '.$page.', \''.$dish_tag.'\')">' . $page . '</a></li>' ?>
            <? endforeach ?>

    <? if ($currentPage == $dish_pager->getCurrentMaxLink()): ?><li class="unavailable"><? else: ?><li><? endif; ?>
    		<a style="cursor:pointer" onclick="ajaxPaginateDailyDishList('<?=url_for('@daily_dish_ajax_list')?>', <?=$dish_pager->getNextPage()?>, '<?=$dish_tag?>')">&raquo;</a>
            </li>
  			
  		<? endif ?>
  	</ul>
  </div><!-- /.sorting -->	
  
</div><!-- /.dail-dish -->

<? endif; ?>