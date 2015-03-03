<? $searchterm = ($sf_params->has('term')) ? '&term=' . $sf_params->get('term') : ''; ?>
<? $PageType = ($sf_params->has('PageType')) ? '&PageType=' . $sf_params->get('PageType') : ''; ?>
<? $Rating = ($sf_params->has('Rating')) ? '&Rating=' . $sf_params->get('Rating') : ''; ?>
<? $CategoryName = ($sf_params->has('CategoryName')) ? '&CategoryName=' . $sf_params->get('CategoryName') : ''; ?>
<? $SubcategoryName = ($sf_params->has('SubcategoryName')) ? '&SubcategoryName=' . $sf_params->get('SubcategoryName') : ''; ?>
<? $Cats = ($sf_params->has('CategoryName')) ? $sf_params->get('CategoryName') . ',' : ''; ?>
<? $withParam = ($sf_params->has('with')) ? '&with=' . $sf_params->get('with') : ''; ?>
<? $withoutParam = ($sf_params->has('without')) ? '&without=' . $sf_params->get('without') : ''; ?>
<? $attrList = ($sf_params->has('attrList')) ? '&attrList=' . $sf_params->get('attrList') : ''; ?>
<? $attrSort = ($sf_params->has('attrSort')) ? '&attrSort=' . $sf_params->get('attrSort') : ''; ?>

<? // params for partial ?>
<? $pagetype = ($sf_params->has('PageType')) ? $sf_params->get('PageType') : ''; ?>
<? $rating = ($sf_params->has('Rating')) ? $sf_params->get('Rating') : ''; ?>
<? $category = ($sf_params->has('CategoryName')) ? $sf_params->get('CategoryName') : ''; ?>
<? $subcategory = ($sf_params->has('SubcategoryName')) ? $sf_params->get('SubcategoryName') : ''; ?>
<? $attrlist = ($sf_params->has('attrList')) ? $sf_params->get('attrList') : ''; ?>
<? $attrsort = ($sf_params->has('attrSort')) ? $sf_params->get('attrSort') : ''; ?>

<div class="findgroup">
        	<p class="fs15"><? if ($term == ''): ?>PLEASE ENTER A SEARCH TERM<? else: ?><? if ($term == '*'): ?>SEARCH RESULTS<? else: ?>YOU SEARCHED FOR: <span class="green">[<?=$term?>]</span><? endif; ?><? endif; ?></p>
            
            
            <? if ($results_total == ''): ?>
	        <?
	        switch ($sf_params->get('PageType')) {
	          case 'Recipe' :
	            echo '<p class="green">Sorry, no recipes matched your search.</p>';
	            break;
	          case 'member' :
	            echo '<p class="green">Sorry, no cooks matched your search.</p>';
	            break;
	          case 'group' :
	            echo '<p class="green">Sorry, no groups matched your search.</p>';
	            break;
	          case 'photo' :
	            echo '<p class="green">Sorry, no photos matched your search.</p>';
	            break;
	          case 'discussion' :
	            echo '<p class="green">Sorry, no discussions matched your search.</p>';
	            break;
	          case 'video' :
	            echo '<p class="green">Sorry, no videos matched your search.</p>';
	            break;
	          case 'journals' :
	            echo '<p class="green">Sorry, no journals matched your search.</p>';
	            break;
	          case 'poll' :
	            echo '<p class="green">Sorry, no polls matched your search.</p>';
	            break;
	          case 'blogs' :
	          	echo '<p class="green">Sorry, no Daily Dish blogs matched your search.</p>';
	          	break;
	          default :
	            echo '<p class="green">Sorry, no recipes matched your search.</p>';
	        }
	        ?>
	      <? endif; ?>
            
            <p>refine your search:</p>
            <form action="<?= getDomainUri() . '/search' ?>" method="get">
            	<input type="text" value="" placeholder="Search for" name="term" onFocus="clearText(this)" onBlur="clearText(this)" />
            	
            	<? if ($sf_params->has('PageType')): ?>
            		<input type="hidden" name="PageType" value="<?=$sf_params->get('PageType')?>" />
            	<? else: ?>
            		<input type="hidden" name="PageType" value="Recipe" />
            	<? endif; ?>
            	
            	<? if ($sf_params->has('CategoryName')): ?>
            		<input type="hidden" name="CategoryName" value="<?=$sf_params->get('CategoryName')?>" />
            	<? endif; ?>
            	
            	<? if ($sf_params->has('SubcategoryName')): ?>
            		<input type="hidden" name="SubcategoryName" value="<?=$sf_params->get('SubcategoryName')?>" />
            	<? endif; ?>
            	
                <input type="submit" value="SEARCH" />
                <!-- <p>Only show results in:</p> -->
                
            </form>
            
            <?php 
            /* as per ET #6086, client does not want user to search content other than recipes
            <? if ($sf_params->has('PageType')): ?>
            <select onchange="location = '<?=getDomainUri()?>/search?term=<?=$sf_params->get('term')?>&PageType=' + this.options[this.selectedIndex].value;">
                    <option value="">--Select A Category--</option>
                    <option value="Recipe" <? if ($sf_params->get('PageType') == 'Recipe'): ?>selected="selected"<? endif; ?>>Recipes</option>
                    <option value="member" <? if ($sf_params->get('PageType') == 'member'): ?>selected="selected"<? endif; ?>>Cooks</option>
                    <option value="group" <? if ($sf_params->get('PageType') == 'group'): ?>selected="selected"<? endif; ?>>Groups</option>
                    <option value="photo" <? if ($sf_params->get('PageType') == 'photo'): ?>selected="selected"<? endif; ?>>Photos</option>
                    <option value="video" <? if ($sf_params->get('PageType') == 'video'): ?>selected="selected"<? endif; ?>>Videos</option>
                    <option value="discussion" <? if ($sf_params->get('PageType') == 'discussion'): ?>selected="selected"<? endif; ?>>Discussions</option>
                    <option value="journals" <? if ($sf_params->get('PageType') == 'journals'): ?>selected="selected"<? endif; ?>>Journals</option>
                    <option value="poll" <? if ($sf_params->get('PageType') == 'poll'): ?>selected="selected"<? endif; ?>>Polls</option>
                    <option value="blogs" <? if ($sf_params->get('PageType') == 'blogs'): ?>selected="selected"<? endif; ?>>Daily Dish</option>
                </select>
            <? endif; ?>
            */
            ?>
            
            <? if ($sf_params->has('PageType') && $sf_params->get('PageType') == 'Recipe'): ?>
            	<? if ($categories): ?>
	            	<p class="searchHeading">Only show me results within:</p>
	            	<select onchange="location = '<?=getDomainUri()?>/search?term=<?=$sf_params->get('term')?>&PageType=<?=$sf_params->get('PageType')?>&CategoryName=' + this.options[this.selectedIndex].value;">
	            		<option value="">-- Select Recipe Category --</option>
	            		<? foreach ($categories as $cat): ?>
	            			<option value="<?=$cat->getName()?>" <? if ($sf_params->get('CategoryName') == $cat->getName()): ?>selected="selected"<? endif; ?>><?=$cat->getName()?></option>
	            		<? endforeach; ?>
	            	</select>
            	<? endif; ?>
            <? endif; ?>
            
            
            <? if ($sf_params->has('CategoryName')): ?>
            	<? if (sizeof($subcategories)>0): ?>
	            	<select onchange="location = '<?=getDomainUri()?>/search?term=<?=$sf_params->get('term')?>&PageType=<?=$sf_params->get('PageType')?>&CategoryName=<?=$sf_params->get('CategoryName')?>&SubcategoryName=' + this.options[this.selectedIndex].value;">
	            		<option value="">-- Select Recipe Sub-Category --</option>
	            		<? foreach ($subcategories as $cat): ?>
	            			<option value="<?=$cat->getName()?>" <? if ($sf_params->get('SubcategoryName') == $cat->getName()): ?>selected="selected"<? endif; ?>><?=$cat->getName()?></option>
	            		<? endforeach; ?>
	            	</select>
            	<? endif; ?>
            <? endif; ?>
            
        </div>
        

      
		<?
	        switch ($sf_params->get('PageType')) {
	          case 'Recipe' :
	            $label = 'Recipes';
	            break;
	          case 'member' :
	            $label = 'Cooks';
	            break;
	          case 'group' :
	            $label = 'Groups';
	            break;
	          case 'photo' :
	            $label = 'Photos';
	            break;
	          case 'discussion' :
	            $label = 'Discussions';
	            break;
	          case 'video' :
	            $label = 'Videos';
	            break;
	          case 'journals' :
	            $label = 'Journals';
	            break;
	          case 'poll' :
	            $label = 'Polls';
	            break;
	          case 'blogs' :
	          	$label = 'Daily Dish';
	          default :
	            $label = '&nbsp;';
	        }
	        ?>

        
        <? if (isset($results)): ?>
        <div id="result-list" class="results">
        	<p class="header">
            <span class="green"><?=$label?></span>
          </p>
          <p>Sort by: 
          <a href="<?= getDomainUri() . url_for('@search?attrSort=Rating:desc' .  $PageType . $CategoryName . $SubcategoryName . $searchterm) ?>" title="Sort by: Rating" <? if ($attrsort == 'Rating:desc') { echo ' class="current"'; } ?>>Rating</a> | 
          <a href="<?= getDomainUri() . url_for('@search?attrSort=PubDate:desc' . $PageType . $CategoryName . $SubcategoryName . $searchterm) ?>" title="Sort by: Date" <? if ($attrsort == 'PubDate:desc') { echo ' class="current"'; } ?>>Most Recent</a></p>
            
            <ul class="divider">
            	<? include_partial('result_list', compact('results', 'results_pager', 'term', 'pagetype', 'rating', 'category', 'subcategory', 'with', 'without', 'type', 'attrlist', 'attrsort')) ?>
            </ul>
            
        </div>
        <? endif; ?>
