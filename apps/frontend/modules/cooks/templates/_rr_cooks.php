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
<? if(isset($rr_cooks) && sizeof($rr_cooks)>0): ?>
<div id="top-cooks">
    <p class="title">Top Cooks</p>
    <ul class="imgleft mt10">
    	<? for($i = 0; $i < count($rr_cooks['items']); $i++): ?>
        <li>
            <a href="<?=getRoute('User', array('subdir' => $rr_cooks['items'][$i]['username']))?>" title="<?=$rr_cooks['items'][$i]['username']?>" class="imgmask50"><img src="<?=$rr_cooks['items'][$i]['avatar']?>" alt="<?=$rr_cooks['items'][$i]['username']?>" /></a>
            <p class="pt10"><a href="<?=getRoute('User', array('subdir' => $rr_cooks['items'][$i]['username']))?>" title="<?=$rr_cooks['items'][$i]['username']?>"><?=$rr_cooks['items'][$i]['display_name']?></a></p>
            <!--<p class="fs11">New York, NY</p>-->
        </li>
        <? endfor; ?>
    </ul>
</div>
<!-- #top-cooks -->
<? endif; ?>