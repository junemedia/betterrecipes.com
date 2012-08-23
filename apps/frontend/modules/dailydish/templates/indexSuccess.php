<div class="article daily-dish">
	<div class="header">
    <img src="/img/header-dailydish.jpg" height="100" width="660" alt="The Daily Dish with Kristina Vanni" />
  </div>
    <div class="sorting">
		<? if (sizeof($items)>0): ?>
        <p class="pager"><?=$pager ?></p>
	</div><!-- /.sorting -->	
	<ul class="dd-list">
	<? for ($i = 0; $i < count($items); $i++): ?>
		<li>
			<p>
			<a href="<?=getRoute('@daily_dish_detail', array('year' => $items[$i]['link'][0][0], 'month' => $items[$i]['link'][0][1], 'day' => $items[$i]['link'][0][2], 'slug' => $items[$i]['link'][0][3]))?>">
			<?=$items[$i]['title']?>
			</a>
			</p>
			<p class="fs11">
				Posted <?=$items[$i]['pubDate']?> by <?=$items[$i]['author']?>
					| <a href="<?=getRoute('@daily_dish_detail', array('comment' => 1, 'year' => $items[$i]['link'][0][0], 'month' => $items[$i]['link'][0][1], 'day' => $items[$i]['link'][0][2], 'slug' => $items[$i]['link'][0][3]))?>">Post a comment</a>
			</p>
            <p><?=$items[$i]['contentencoded']?></p>
            
					<p>
						<a class="btn-grey28" title="Post A Comment" href="<?=getRoute('@daily_dish_detail', array('comment' => 1, 'year' => $items[$i]['link'][0][0], 'month' => $items[$i]['link'][0][1], 'day' => $items[$i]['link'][0][2], 'slug' => $items[$i]['link'][0][3]))?>">POST A COMMENT</a>
					</p>
            
		</li>
	<? endfor; ?>
	</ul>
    <div class="sorting">
    	<p class="pager"><?=$pager ?></p>
    </div>	
<? endif ?>
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
    <div id="dd-archive">
		<? if (sizeof($archive)>0): ?>
      <p class="title">Archive</p>
      <ul class="sb-underlines">
        <? foreach($archive as $c => $row): ?>
          <li>
          <a href="<?=getRoute('@daily_dish_archive', array('year' => $row['url']['year'], 'month' => $row['url']['month']))?>">
            <?=$row['title']?>
          </a>
          </li>
        <? endforeach; ?>
      </ul>
		<? endif; ?>
    </div>
    
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
      <!--
      <? // print_r($items) ?>
      -->
    </div>
    
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
	<div id="wp-badge">
		<a href="http://www.foodblogs.com">
		<img width="125" height="125" border="0" alt="Proud member of FoodBlogs" src="http://www.foodblogs.com/files/badges/foodblogs_badge2_125x125.jpg">
		</a>
	</div>
    <? /* ------
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
		*/?>
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