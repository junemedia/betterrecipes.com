<? include_partial('group_info', compact('my_group', 'group', 'blog_id', 'active', 'is_sponsor', 'sponsor')) ?>
<? //include_partial('jumpnav') ?>
<div class="mixingbowl">
  <div id="discussions-detail-list" class="group-discussion">
    <? include_partial('group_discussion_detail', compact('blog_id', 'thread_id', 'posts', 'posts_pager', 'posts_total', 'thread', 'group', 'user_id')) ?>
    <div id="discussion-replies">
    	<p>Comments:</p>
      <ul class="img50left">
        <? include_partial('group_discussion_detail_replies', compact('thread_id', 'posts', 'posts_pager', 'group')) ?>
      </ul>
    </div><!-- /#discussion-replies -->
  </div><!-- /#discussions-detail-list -->	
</div>