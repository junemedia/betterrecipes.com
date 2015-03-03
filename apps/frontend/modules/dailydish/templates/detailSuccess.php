<? $slug = '&slug=' . $sf_params->get('slug'); ?>
<? $year = '&year=' . $sf_params->get('year'); ?>
<? $month = '&month=' . $sf_params->get('month'); ?>
<? $day = '&day=' . $sf_params->get('day'); ?>
<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div id="dailyDish" class="article daily-dish detail">
  
  <div class="header mb20">
    <img src="/img/br_dd_logo.png" height="100" width="660" alt="The Daily Dish" />
  </div>
  <? include_partial('dish_sharebar') ?>
  <?php if (sizeof($post) > 0): ?>
    <p class="title"><?= $post[0]['title'] ?></p>
    <p class="bylineText"><?= $post[0]['byline'] ?></p>
    <div id="dishContents">
    <?= $post[0]['contents'] ?>
    </div><!-- /#dishContents closing -->
  <?php endif; ?>

  <div id="recipe-comments">

    <p class="title">Comments <? if (sizeof($comments) > 0): ?> (<?= $comments_total ?>) <? else: ?> (0) <? endif; ?></p>
    <? if (sizeof($comments) > 0): ?>
      <ul class="comments">
        <? for ($i = 0; $i < count($comments); $i++): ?>
          <li>
            <img src="<?= $comments[$i]['avatar'] ?>" height="100" width="100" alt="<?= $comments[$i]['display_name'] ?>" />
            <div class="comment"><?= $comments[$i]['content'] ?></div>
            <p class="fs11 mt30 mb20">by <a href="<?= getRoute('User', array('subdir' => $comments[$i]['username'])) ?>" title="<?= $comments[$i]['username'] ?>"><?= $comments[$i]['display_name'] ?></a>, @ <?= $comments[$i]['created'] ?></p>
          </li>
        <? endfor; ?>
      </ul>
      <div class="sorting">
        <ul class="pager hornav">
          <? if ($comments_pager->haveToPaginate()): ?>

            <? $currentPage = $comments_pager->getPage() ?>

            <? if ($currentPage == 1): ?><li class="unavailable"><? else: ?><li><? endif; ?>
              <a href="<?= getDomainUri() . url_for('@daily_dish_detail?page=' . $comments_pager->getPreviousPage() . $slug . $year . $month . $day) ?>">&laquo;</a>
            </li>

            <? $links = $comments_pager->getLinks();
            foreach ($links as $page): ?>
              <?= ($page == $comments_pager->getPage()) ? '<li class="active"><a>' . $page . '</a></li>' : '<li><a href="' . url_for('@daily_dish_detail?page=' . $page . $slug . $year . $month . $day) . '">' . $page . '</a></li>' ?>
            <? endforeach ?>

    <? if ($currentPage == $comments_pager->getCurrentMaxLink()): ?><li class="unavailable"><? else: ?><li><? endif; ?>
              <a href="<?= getDomainUri() . url_for('@daily_dish_detail?page=' . $comments_pager->getNextPage() . $slug . $year . $month . $day) ?>">&raquo;</a>
            </li>

  <? endif ?>
        </ul>
      </div><!-- /.sorting -->
<? endif; ?>



  </div><!-- /#recipe-comments -->

<? if (isset($user_id)): ?>
	<a name="comment">&nbsp;</a> 
    <form id="addComment" name="add_comment" class="standard-form">
      <input type="hidden" name="user_id" value="<?= $user_id ?>" />
      <input type="hidden" name="type" value="dailydish" />
      <input type="hidden" name="content_id" value="<?= $contentId ?>" />
      <fieldset>
        <label style="float:none;">Your Comment</label>
        <textarea name="comment" id="userComment" class="wym-editor"></textarea>
      </fieldset>
      <input type="button" value="submit" class="btn-grey28 ajax-submit" style="margin-right:0;" onclick="addcomment('<?= getDomainUri() . url_for(@create_comment) ?>');" />
      <p id="message"></p>
    </form>
  <? else: ?>
  <? // not logged in  ?>
    <form name="comment_redirect" id="commentRedirect" class="standard-form" method="post" action="<?= getDomainUri() . url_for('@comment_auth') ?>">
      <input type="hidden" name="return_path" value="<?= getDomainUri() . url_for('@daily_dish_detail?slug=' . $sf_params->get('slug') . $year . $month . $day) ?>" />
      <fieldset>
        <label><a style="cursor:pointer;" onclick="$('#commentRedirect').submit();">Login To Comment</a></label>
      </fieldset>
    </form>
<? endif; ?>


</div><!-- /.article -->
<div class="sidebar">
	<? include_partial('global/right_rail/right_rail_dailydish') ?>
	
	<div>
		<a href="mailto:kristina.vanni@meredith.com?subject=The Daily Dish"><img src="http://images.meredith.com/betterrecipes/images/blogs/email.jpg"></a>
		<a target="_blank" href="<?=UrlToolkit::getDomainUri()?>/blogs/daily-dish/feed"><img src="http://images.meredith.com/betterrecipes/images/blogs/subscribe.jpg"></a>
	</div>
	<? /*
    <div id="dd-cat">
		<? if (sizeof($cats)>0): ?>
        <p class="title">Categories</p>
        <ul class="sb-underlines">
            <? foreach($cats as $c => $row): ?>
                <li>
                <a href="<?=getRoute('@daily_dish_category', array('category' => $row['url']))?>">
                	<?=$row['title']?>
                </a>
                </li>
            <? endforeach; ?>
        </ul>
		<? endif; ?>
    </div>
    */ ?>
  <!--
    <div id="dd-archive">
		<? //if (sizeof($archive)>0): ?>
        <p class="title">Archive</p>
        <ul class="sb-underlines">
            <?// foreach($archive as $c => $row): ?>
                <li>
                <a href="<?//=getRoute('@daily_dish_archive', array('year' => $row['url']['year'], 'month' => $row['url']['month']))?>">
                	<?//=$row['title']?>
                </a>
                </li>
            <? //endforeach; ?>
        </ul>
		<? //endif; ?>
    </div>
  -->
    <? /*
    <? if (sizeof($blogroll)>0): ?>
    <div id="dd-blogroll">
        <p class="title">Blogroll</p>
        <ul class="sb-underlines">
            <? foreach($blogroll as $b => $row): ?>
                <li><a href="<?=$row['url']?>" target="_blank"><?=$row['title']?></a></li>
            <? endforeach; ?>
        </ul>
    <? endif; ?>
	</div>
	*/ ?>
	<div id="wp-badge">
		<a href="http://www.foodblogs.com">
		<img width="125" height="125" border="0" alt="Proud member of FoodBlogs" src="http://www.foodblogs.com/files/badges/foodblogs_badge2_125x125.jpg">
		</a>
	</div>
    <? /*
    <div id="dd-tag">
		<? if (sizeof($tags)>0): ?>
        <p class="title">Tags</p>
        <ul class="sb-underlines">
            <? foreach($tags as $c => $row): ?>
                <li>
                <a href="<?=getRoute('@daily_dish_tag', array('tag' => $row['url']))?>">
                	<?=ucwords($row['title'])?>
                </a>
                </li>
            <? endforeach; ?>
        </ul>
		<? endif; ?>
    </div>
    */ ?>
    
    
    
    
    <div>
    	<p class="title">Recent Articles</p>
    	<ul class="border-bottom">
        <? for ($i = 0; $i < 5; $i++): ?>
        <li>
          <p><a href="<?=getRoute('@daily_dish_detail', array('year' => $items[$i]['link'][0][0], 'month' => $items[$i]['link'][0][1], 'day' => $items[$i]['link'][0][2], 'slug' => $items[$i]['link'][0][3]))?>" title="<?=$items[$i]['title']?>"><?=$items[$i]['title']?></a></p>
          <p><?= substr($items[$i]['description'], 0 , 200) ?>...</p>
          <p><a href="<?=getRoute('@daily_dish_detail', array('year' => $items[$i]['link'][0][0], 'month' => $items[$i]['link'][0][1], 'day' => $items[$i]['link'][0][2], 'slug' => $items[$i]['link'][0][3]))?>" title="<?=$items[$i]['title']?>">Read more</a></p>
        </li>
      <? endfor; ?>
      </ul>
    </div>
    
    
    
    
    <div>
    	<!-- VSW ADS -->
			<script type="text/javascript" language="JavaScript">
      var era_rc = {
      ERADomain: 'as.vs4food.com',
      PubID: 'betterrecipes'
      };
      </script>
      <link rel="stylesheet" type="text/css" href="http://as.vs4food.com/ERA/Custom/VSW/CSS/HtmlRelatedLinks.css">
      <script type="text/javascript" language="JavaScript" src="http://as.vs4food.com/ERA/era_rl.aspx"></script>
      <!-- END VSW ADS -->
    </div>
</div><!-- /.sidebar -->

<div class="clearfix"></div>