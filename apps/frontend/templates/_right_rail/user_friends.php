<?
/**
 * this should been a component and not a partial.
 * Components can handle the content retrieval and logic on their own vs partials need it passed on to them.
 * 
 * @see http://www.symfony-project.org/gentle-introduction/1_4/en/07-Inside-the-View-Layer#chapter_07_sub_components
 * 
 * - BK
 */
?>
<? if(isset($friends) && sizeof($friends)>0): ?>
<div id="my-friends">
    <p class="title">FRIENDS</p>
    <!--<a href="#" class="btn-grey28" title="Add as friend">ADD AS FRIEND</a>-->
    <ul>
    	<? for($i = 0; $i < count($friends['items']); $i++): ?>
      <? $subdir = $friends['items'][$i]['username'] ?>
        <li>
        	<a href="<?=getRoute('User', array('subdir' => $subdir))?>" title="<?=$subdir?>" class="imgmask50"><img src="<?=$friends['items'][$i]['user_avatar']?>" alt="<?=$friends['items'][$i]['display_name']?>" /></a>
          <p class="pt10"><a href="<?=getRoute('User', array('subdir' => $subdir))?>" title="<?=$friends['items'][$i]['display_name']?>"><?=$friends['items'][$i]['display_name']?></a></p>
        </li>
        <? endfor ?>
    </ul>
    <p class="cta-more"><a href="<?=getDomainUri().url_for('@cook_profile_friends?subdir='.$profile['subdir'])?>" title="See more" class="purple">see more&raquo;</a></p>
</div><!-- /#my-friends -->
<? endif; ?>