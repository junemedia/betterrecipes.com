<?/*
    <div id="cooks">
        <p class="title green">Cooks</p>
        <p class="mb20 summary"><a href="#" title="Add as friend" class="btn-grey28">INVITE FRIENDS</a>Whether you're looking for a friend who's already a member of the Mixing Bowl community or simply want to find a kindred soul to swap recipes and cooking tips with, you can do both here. Here at Mixing Bowl, food and friends are made fresh daily!</p>
        <div class="main-image">
            <img src="/img/img-profile1.jpg" height="205" width="280" alt="Group Name" />
        </div>
        <p class="title"><span class="green">Featured Cook: </span>Annie McMurphy</p>
        <p>New York, New York</p>
        <p class="ml325"><span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. consectetur adipiscing elit. Mauris mi sapien, lorem ipsum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris mi sapien, lorem ipsum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span></p>
        <ul class="hornav flare ml325">
            <li class="fs14 ttupp">Badges &amp; Trophies (3)</li>
            <li><img src="/img/img-badge1.png" height="21" width="19" alt="Badge Name" /></li>
            <li><img src="/img/img-badge1.png" height="21" width="19" alt="Badge Name" /></li>
            <li><img src="/img/img-badge1.png" height="21" width="19" alt="Badge Name" /></li>
        </ul>		 
    </div><!-- /#group-detail -->
*/?>
    <? if(isset($cooks) && sizeof($cooks)>0): ?>
    <div id="most-active-cooks" style="clear:both;">
        <p class="title">Most Active Cooks</p>
<?/*
        <ul class="pager hornav">
            <li class="unavailable"><a href="#" title="Previous">&laquo;</a></li>
            <li class="active"><a href="#" title="Page 1">1</a></li>
            <li><a href="#" title="Page 2">2</a></li>
            <li><a href="#" title="Page 3">3</a></li>
            <li><a href="#" title="Page 4">4</a></li>
            <li><a href="#" title="Page 5">5</a></li>
            <li><a href="#" title="Page 6">6</a></li>
            <li><a href="#" title="Previous">&raquo;</a></li>
        </ul>
*/?>        
        <ul class="hornav imgleft">
        	<? for($i = 0; $i < count($cooks['items']); $i++): ?>
            <li>
            	<span class="imgmask75">
                <img src="<?=$cooks['items'][$i]['avatar']?>" alt="<?=$cooks['items'][$i]['display_name']?>" />
              </span>
                <p class="mt20"><a href="<?=getRoute('User', array('subdir' => $cooks['items'][$i]['username']))?>" title="<?=$cooks['items'][$i]['display_name']?>"><?=Utilities::truncateHtml($cooks['items'][$i]['display_name'], 16)?></a>
                <!--<p class="fs11">New York, New York</p>-->
            </li>
            <? endfor; ?>
        </ul>
<?/*
        <ul class="pager hornav">
            <li class="unavailable"><a href="#" title="Previous">&laquo;</a></li>
            <li class="active"><a href="#" title="Page 1">1</a></li>
            <li><a href="#" title="Page 2">2</a></li>
            <li><a href="#" title="Page 3">3</a></li>
            <li><a href="#" title="Page 4">4</a></li>
            <li><a href="#" title="Page 5">5</a></li>
            <li><a href="#" title="Page 6">6</a></li>
            <li><a href="#" title="Previous">&raquo;</a></li>
        </ul>
*/?>
        <? //if (sizeof($cooks['items'])>20): ?>
        	<p class="cta-more"><a href="<?=getRoute('@search', array('page' => 'member'))?>" title="See all cooks" class="purple">see all cooks&raquo;</a></p>
        <? //endif; ?>
    </div><!-- /#my-discussions -->
    <? endif; ?>
</div><!-- /.section -->