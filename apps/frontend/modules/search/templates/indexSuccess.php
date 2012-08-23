<? $searchterm = ($sf_params->has('term')) ? '&term=' . $sf_params->get('term') : ''; ?>
<? $PageType = ($sf_params->has('PageType')) ? '&PageType=' . $sf_params->get('PageType') : ''; ?>
<? $Rating = ($sf_params->has('Rating')) ? '&Rating=' . $sf_params->get('Rating') : ''; ?>
<? $CategoryName = ($sf_params->has('CategoryName')) ? '&CategoryName=' . $sf_params->get('CategoryName') : ''; ?>
<? $Cats = ($sf_params->has('CategoryName')) ? $sf_params->get('CategoryName') . ',' : ''; ?>
<? $withParam = ($sf_params->has('with')) ? '&with=' . $sf_params->get('with') : ''; ?>
<? $withoutParam = ($sf_params->has('without')) ? '&without=' . $sf_params->get('without') : ''; ?>
<? $recipeOwner = ($sf_params->has('recipeOwner')) ? '&recipeOwner=' . $sf_params->get('recipeOwner') : ''; ?>
<p id="breadcrumbs"><a href="<?= UrlToolkit::getDomainUri() ?>" title="Breadcrumb 1">better recipes</a> / <a title="Breadcrumb 2" class="last">search results</a></p>
<div class="article serp-article">
  <div id="serp-results">
    <div class="header">
      <p class="title"><? if ($term == ''): ?>Please enter a search term<? else: ?>Search Results:</p><? endif; ?>
      <? if ($results_total != ''): ?>
        <p class="search-count"><? if ($term == '*'): ?>Number of Results<? else: ?>You searched for:  <?= $term ?><? endif; ?> (<?= $results_total ?> results)</p>
      <? else: ?>
        <?
        switch ($sf_params->get('PageType')) {
          case 'Recipe' :
            echo '<p class="search-count">Sorry, no recipes matched your search. Please try again.</p>';
            break;
          case 'member' :
            echo '<p class="search-count">Sorry, no cooks matched your search. Please try again.</p>';
            break;
          case 'group' :
            echo '<p class="search-count">Sorry, no groups matched your search. Please try again.</p>';
            break;
          case 'photo' :
            echo '<p class="search-count">Sorry, no photos matched your search. Please try again.</p>';
            break;
          case 'discussion' :
            echo '<p class="search-count">Sorry, no discussions matched your search. Please try again.</p>';
            break;
          case 'video' :
            echo '<p class="search-count">Sorry, no videos matched your search. Please try again.</p>';
            break;
          case 'journals' :
            echo '<p class="search-count">Sorry, no journals matched your search. Please try again.</p>';
            break;
          case 'poll' :
            echo '<p class="search-count">Sorry, no polls matched your search. Please try again.</p>';
            break;
          default :
            echo '<p class="search-count">Sorry, no recipes matched your search. Please try again.</p>';
        }
        ?>
      <? endif; ?>
      <ul class="hornav tabbednav fifty50">
        <?
        if ($sf_params->has('PageType') && $sf_params->get('PageType') == 'Recipe') {
          echo '<li class="active">';
        } else {
          echo '<li>';
        }
        ?>
        <a style="padding: 0 8px;" href="<?= getDomainUri() . url_for('@search?PageType=Recipe' . $searchterm) ?>" title="Recipes">Recipes</a>
        </li>
        <?
        if ($sf_params->has('PageType') && $sf_params->get('PageType') == 'blogs') {
          echo '<li class="active">';
        } else {
          echo '<li>';
        }
        ?>
        <a style="padding: 0 8px;" href="<?= getDomainUri() . url_for('@search?PageType=blogs' . $searchterm) ?>" title="The Daily Dish">Daily Dish</a>
        </li>
      </ul>
    </div><!-- /.header -->
    <div class="sorting">
      <ul class="pager hornav">
        <? if ($results_pager != ''): ?>
          <? if ($results_pager->haveToPaginate()): ?>
            <? $currentPage = $results_pager->getPage() ?>
            <? if ($currentPage == 1): ?><li class="unavailable"><? else: ?><li><? endif; ?>
              <a href="<?= getDomainUri() . url_for('@search?page=' . $results_pager->getPreviousPage() . $searchterm . $PageType . $Rating . $CategoryName . $withParam . $withoutParam . $recipeOwner) ?>">&laquo;</a>
            </li>
            <?
            $links = $results_pager->getLinks();
            foreach ($links as $page):
              ?>
              <?= ($page == $results_pager->getPage()) ? '<li class="active"><a>' . $page . '</a></li>' : '<li><a href="' . getDomainUri() . url_for('@search?page=' . $page . $searchterm . $PageType . $Rating . $CategoryName . $withParam . $withoutParam . $recipeOwner) . '">' . $page . '</a></li>' ?>
            <? endforeach ?>
            <? if ($currentPage == $results_pager->getCurrentMaxLink()): ?><li class="unavailable"><? else: ?><li><? endif; ?>
              <a href="<?= getDomainUri() . url_for('@search?page=' . $results_pager->getNextPage() . $searchterm . $PageType . $Rating . $CategoryName . $withParam . $withoutParam . $recipeOwner) ?>">&raquo;</a>
            </li>
          <? endif; ?>
        <? endif; ?>
      </ul>
    </div>
    <ul class="results-list">
      <? if (isset($results)): ?>
        <? for ($i = 0; $i < count($results); $i++): ?>
          <? if ($type == 'Recipe'): ?>
            <li>
              <? if ($results[$i]['image'] != ''): ?>
                <div style="float:left;"><span class="imgmask50 mr20"><img src="<?= $results[$i]['image'] ?>" /></span></div>
              <? endif; ?>
              <p><a baynote_bnrank="<?= $results[$i]['baynote_bnrank'] ?>" baynote_irrank="<?= $results[$i]['baynote_irrank'] ?>" href="<?= $results[$i]['url'] ?>" title="<?= $results[$i]['title'] ?>"><?= $results[$i]['title'] ?></a></p>
              <p class="rating"><span class="rate<?= $results[$i]['rating'] ?>"><?= $results[$i]['rating'] ?> Stars</span></p>
              <p><span><?= Utilities::truncateHtml($results[$i]['description'], 218, '...') ?></span></p>
              <p class="fs11"><? if ($results[$i]['subdir'] != ''): ?>by <a href="<?= getRoute('User', array('subdir' => $results[$i]['subdir'])) ?>" title="<?= $results[$i]['display_name'] ?>"><?= $results[$i]['display_name'] ?></a>, @<? endif; ?>  <?= $results[$i]['date'] ?></p>
            </li>
          <? elseif ($type == 'member'): ?>
            <li>
              <span class="imgmask75">
                <a baynote_bnrank="<?= $results[$i]['baynote_bnrank'] ?>" baynote_irrank="<?= $results[$i]['baynote_irrank'] ?>" href="<?= $results[$i]['url'] ?>" title="<?= $results[$i]['display_name'] ?>"><img src="<?= $results[$i]['avatar'] ?>" alt="<?= $results[$i]['display_name'] ?>" /></a>
              </span>
              <p class="mt20"><a baynote_bnrank="<?= $results[$i]['baynote_bnrank'] ?>" baynote_irrank="<?= $results[$i]['baynote_irrank'] ?>" href="<?= $results[$i]['url'] ?>" title="<?= $results[$i]['display_name'] ?>"><?= $results[$i]['display_name'] ?></a>
            </li>
          <? elseif ($type == 'group'): ?>
            <li style="min-height:105px;">
              <? if ($results[$i]['avatar'] != ''): ?>
                <div style="float:left;"><span class="imgmask50 mr20"><img src="<?= $results[$i]['avatar'] ?>" /></span></div>
              <? endif; ?>
              <p><a baynote_bnrank="<?= $results[$i]['baynote_bnrank'] ?>" baynote_irrank="<?= $results[$i]['baynote_irrank'] ?>" href="<?= $results[$i]['url'] ?>" title="<?= $results[$i]['title'] ?>"><?= $results[$i]['title'] ?></a></p>
              <p><span><?= Utilities::truncateHtml($results[$i]['description'], 172, '...') ?></span></p>
            </li>
          <? elseif ($type == 'photo'): ?>
            <li>
              <p><a baynote_bnrank="<?= $results[$i]['baynote_bnrank'] ?>" baynote_irrank="<?= $results[$i]['baynote_irrank'] ?>" href="<?= $results[$i]['url'] ?>" title="<?= $results[$i]['title'] ?>"><?= $results[$i]['title'] ?></a></p>
            </li>
          <? elseif ($type == 'discussion'): ?>
            <li>
              <p><a baynote_bnrank="<?= $results[$i]['baynote_bnrank'] ?>" baynote_irrank="<?= $results[$i]['baynote_irrank'] ?>" href="<?= $results[$i]['url'] ?>" title="<?= $results[$i]['title'] ?>"><?= $results[$i]['title'] ?></a></p>
            </li>
          <? elseif ($type == 'video'): ?>
            <li>
              <p><a baynote_bnrank="<?= $results[$i]['baynote_bnrank'] ?>" baynote_irrank="<?= $results[$i]['baynote_irrank'] ?>" href="<?= $results[$i]['url'] ?>" title="<?= $results[$i]['title'] ?>"><?= $results[$i]['title'] ?></a></p>
            </li>
          <? elseif ($type == 'journals'): ?>
            <li>
              <p><a baynote_bnrank="<?= $results[$i]['baynote_bnrank'] ?>" baynote_irrank="<?= $results[$i]['baynote_irrank'] ?>" href="<?= $results[$i]['url'] ?>" title="<?= $results[$i]['title'] ?>"><?= $results[$i]['title'] ?></a></p>
            </li>
          <? elseif ($type == 'poll'): ?>
            <li>
              <p><a baynote_bnrank="<?= $results[$i]['baynote_bnrank'] ?>" baynote_irrank="<?= $results[$i]['baynote_irrank'] ?>" href="<?= $results[$i]['url'] ?>" title="<?= $results[$i]['title'] ?>"><?= $results[$i]['title'] ?></a></p>
            </li>
          <? elseif ($type == 'blogs'): ?>
            <li style="min-height:105px;">
              <p><a baynote_bnrank="<?= $results[$i]['baynote_bnrank'] ?>" baynote_irrank="<?= $results[$i]['baynote_irrank'] ?>" href="<?= $results[$i]['url'] ?>" title="<?= $results[$i]['title'] ?>"><?= $results[$i]['title'] ?></a></p>
              <p<span>Published on: <?= $results[$i]['date'] ?></span></p>
              <p><span><?= Utilities::truncateHtml($results[$i]['description'], 200, '...') ?></span></p>
            </li>
          <? endif; ?>
        <? endfor; ?>
      <? endif; ?>
    </ul><!-- /.results-list -->
    <div class="sorting">
      <ul class="pager hornav">
        <? if ($results_pager != ''): ?>
          <? if ($results_pager->haveToPaginate()): ?>
            <? $currentPage = $results_pager->getPage() ?>
            <? if ($currentPage == 1): ?><li class="unavailable"><? else: ?><li><? endif; ?>
              <a href="<?= getDomainUri() . url_for('@search?page=' . $results_pager->getPreviousPage() . $searchterm . $PageType . $Rating . $CategoryName . $withParam . $withoutParam . $recipeOwner) ?>">&laquo;</a>
            </li>
            <?
            $links = $results_pager->getLinks();
            foreach ($links as $page):
              ?>
              <?= ($page == $results_pager->getPage()) ? '<li class="active"><a>' . $page . '</a></li>' : '<li><a href="' . getDomainUri() . url_for('@search?page=' . $page . $searchterm . $PageType . $Rating . $CategoryName . $withParam . $withoutParam . $recipeOwner) . '">' . $page . '</a></li>' ?>
            <? endforeach ?>
            <? if ($currentPage == $results_pager->getCurrentMaxLink()): ?><li class="unavailable"><? else: ?><li><? endif; ?>
              <a href="<?= getDomainUri() . url_for('@search?page=' . $results_pager->getNextPage() . $searchterm . $PageType . $Rating . $CategoryName . $withParam . $withoutParam . $recipeOwner) ?>">&raquo;</a>
            </li>
          <? endif; ?>
        <? endif; ?>
      </ul>
    </div>
  </div><!-- /#serp-results -->
</div><!-- /.article -->
<div class="sidebar serp-sidebar mt20">
  <? if ($sf_params->has('PageType') && $sf_params->get('PageType') == 'Recipe'): ?> <!-- Requested on ET 5710 -->
    <p>Narrow Your Search Results By: (select all that apply)</p>
    <p style="margin:10px 0"><a href="/search?PageType=Recipe<?= $searchterm ?>">Reset Filters</a></p>
  <? endif; ?>
  <?
  if ($sf_params->has('PageType') && $sf_params->get('PageType') == 'Recipe') {
    echo '<div id="recipe-filter">';
  } else {
    echo '<div id="recipe-filter" style="display:none;">';
  }
  ?>
  <p>CATEGORY</p>
  <ul id="withList">
    <? if (sizeof($cat_list) > 0): ?>
      <? foreach ($cat_list as $v): ?>
        <li><?= $v ?> <a href="javascript:;" onclick="deleteCategory('<?= $v ?>');">Delete</a></li>
      <? endforeach; ?>
    <? endif; ?>
  </ul>
  <br />
  <form>
    <input type="hidden" name="totalCats" id="totalCats" value="<?= $totalCats ?>" />
  </form>
  <ul class="underlined categories">
    <? if ($categories): ?>
      <? foreach ($categories as $cat): ?>
        <?
        if (in_array($cat->getName(), $cat_list)) {
          echo '<li class="current">';
        } else {
          echo '<li>';
        }
        ?>
        <a href="<?= getDomainUri() . url_for('@search?CategoryName=' . $Cats . $cat->getName() . $searchterm . $PageType . $Rating . $withParam . $withoutParam . $recipeOwner) ?>" title="<?= ucfirst($cat->getSlug()) ?>" ><?= ucfirst($cat->getSlug()) ?></a></li>
      <? endforeach; ?>
    <? endif; ?>
  </ul>
  <ul class="underlined mt40 stars">
    <li>RATINGS</li>
    <li class="fivestars <?
    if ($sf_params->has('Rating') && $sf_params->get('Rating') == 5) {
      echo 'current';
    }
    ?>"><a href="<?= getDomainUri() . url_for('@search?Rating=5' . $searchterm . $PageType . $CategoryName . $withParam . $withoutParam . $recipeOwner) ?>" title="5 stars"><span>5 stars</span></a></li>
    <li class="fourstars <?
        if ($sf_params->has('Rating') && $sf_params->get('Rating') == 4) {
          echo 'current';
        }
    ?>"><a href="<?= getDomainUri() . url_for('@search?Rating=4' . $searchterm . $PageType . $CategoryName . $withParam . $withoutParam . $recipeOwner) ?>" title="4 stars"><span>4 stars</span> &amp; up</a></li>
    <li class="threestars <?
        if ($sf_params->has('Rating') && $sf_params->get('Rating') == 3) {
          echo 'current';
        }
    ?>"><a href="<?= getDomainUri() . url_for('@search?Rating=3' . $searchterm . $PageType . $CategoryName . $withParam . $withoutParam . $recipeOwner) ?>" title="3 stars"><span>3 stars</span> &amp; up</a></li>
    <li class="twostars <?
        if ($sf_params->has('Rating') && $sf_params->get('Rating') == 2) {
          echo 'current';
        }
    ?>"><a href="<?= getDomainUri() . url_for('@search?Rating=2' . $searchterm . $PageType . $CategoryName . $withParam . $withoutParam . $recipeOwner) ?>" title="2 stars"><span>2 stars</span> &amp; up</a></li>
    <li class="onestar <?
        if ($sf_params->has('Rating') && $sf_params->get('Rating') == 1) {
          echo 'current';
        }
    ?>"><a href="<?= getDomainUri() . url_for('@search?Rating=1' . $searchterm . $PageType . $CategoryName . $withParam . $withoutParam . $recipeOwner) ?>" title="1 star"><span>1 star</span> &amp; up</a></li>
  </ul>
  <form class="mt40 mb10">
    <input type="hidden" name="current-params" id="current-params" value="<?= $searchterm . $PageType . $Rating ?>" />
    <fieldset class="mb10">
      <label for="serpwith_text">SHOW RECIPES WITH:</label>
      <input type="reset" value="clear all" name="serpwith_reset" class="no-style" style="cursor:pointer;" onclick="clearSearchIngredients('with');"  />
      <input type="hidden" name="with" id="with" value="<?= $with ?>" />
      <input type="text" value="Type ingredient" id="with-field" name="serpwith_text" onFocus="clearText(this)" onBlur="clearText(this)" />
      <input type="button" value="GO" name="serpwith_submit" onclick="doSearchWith();" />
    </fieldset>
    <ul id="withList">
      <? if (sizeof($with_list) > 0): ?>
        <? foreach ($with_list as $v): ?>
          <li><?= $v ?> <a href="javascript:;" onclick="deleteWith('<?= $v ?>');">Delete</a></li>
        <? endforeach; ?>
      <? endif; ?>
    </ul>
    <br />
    <fieldset>
      <label for="serpwo_text">SHOW RECIPES WITHOUT:</label>
      <input type="reset" value="clear all" name="serpwo_reset" class="no-style" style="cursor:pointer;" onclick="clearSearchIngredients('without');" />
      <input type="hidden" name="without" id="without" value="<?= $without ?>" />
      <input type="text" value="Type ingredient" name="serpwo_text" id="without-field" onFocus="clearText(this)" onBlur="clearText(this)" />
      <input type="button" value="GO" name="serpwo_submit" onclick="doSearchWithout();" />
    </fieldset>
    <ul id="withoutList">
      <? if (sizeof($without_list) > 0): ?>
        <? foreach ($without_list as $v): ?>
          <li><?= $v ?> <a href="javascript:;" onclick="deleteWithout('<?= $v ?>');">Delete</a></li>
        <? endforeach; ?>
      <? endif; ?>
    </ul>
    <br />
    <fieldset>
      <label>SHOW RECIPES BY:</label>
      <input type="reset" value="clear all" name="serp_recipe_owner_reset" class="no-style" style="cursor:pointer;" onclick="clearRecipeOwner();" />
      <input type="hidden" name="recipeOwner" id="recipeOwner" value="<?= $recipe_owner ?>" />
      <input type="text" value="Type recipe owner" name="serp_recipe_owner_text" id="recipeOwner-field" onFocus="clearText(this)" onBlur="clearText(this)" />
      <input type="button" value="GO" name="serp_recipe_owner_submit" onclick="doSearchRecipeOwner();" />
    </fieldset>
    <ul id="recipeOwnerList">
      <? if (sizeof($recipe_owner_list) > 0): ?>
        <? foreach ($recipe_owner_list as $v): ?>
          <li><?= $v ?> <a href="javascript:;" onclick="deleteRecipeOwner('<?= $v ?>');">Delete</a></li>
        <? endforeach; ?>
      <? endif; ?>
    </ul>
    <br />
  </form>
</div><!-- /#recipe-filter -->
</div><!-- /.sidebar -->
<div class="clearfix"></div>