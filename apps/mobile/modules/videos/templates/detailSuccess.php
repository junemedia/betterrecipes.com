<? if ($video): ?>
<? slot('video') ?>
    <script src="/js/video-js/video.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="/js/video-js/video-js.css" type="text/css" media="screen" title="Video JS" charset="utf-8">
    <script type="text/javascript">
      //<![CDATA[
      VideoJS.setupAllWhenReady();
      $(document).ready(function(){
        var myPlayer = VideoJS.setup("br_video");
        if (myPlayer.canPlaySource()) {
          myPlayer.play(); // Starts playing the video for this player.
        }
      });
      //]]>
    </script>
    <? end_slot() ?>
<div class="video-detail">
	<p class="header"><span class="green"><?= $video['title'] ?></span></p>
    
    <!-- Begin VideoJS -->
      <div class="video-js-box clear">
        <video id="br_video" class="video-js" width="<?= $video['width'] ?>" height="<?= $video['height'] ?>" controls="controls" preload="auto" poster="<?= $video['preview_url'] ?>">
          <source src="<?= $video['mp4'] ?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' />
          <!-- Flash Fallback. Use any flash video player here. Make sure to keep the vjs-flash-fallback class. -->
          <object id="flash_fallback_1" class="vjs-flash-fallback" width="<?= $video['width'] ?>" height="<?= $video['height'] ?>" type="application/x-shockwave-flash"
                  data="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf">
            <param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf" />
            <param name="allowfullscreen" value="true" />
            <param name="flashvars" value='config={"playlist":["<?= $video['preview_url'] ?>", {"url": "<?= $video['flv'] ?>","autoPlay":false,"autoBuffering":true}]}' />
            <!-- Image Fallback. Typically the same as the poster image. -->
            <img src="<?= $video['preview_url'] ?>" alt="Poster Image" title="No video playback capabilities." />
          </object>
        </video>
      </div>
      <!-- End VideoJS -->
      
      
    <p class="pt10 pb10"><img src="<?= $video['user_avatar'] ?>" alt="<?= $video['display_name'] ?>" width="75" height="75" />
        by: <a href="<?= getRoute('User', array('subdir' => $video['username'])) ?>"><?= $video['display_name'] ?></a> @ <?= $video['date_uploaded'] ?>
        <? if ($sponsored): ?>
        <div class="sponsor adsponsor">
          <? include_partial('global/adtags/sponsor', compact('sponsor')) ?>
        </div>
        <p>&nbsp;</p>
      <? endif; ?>
      
      <div class="badge20"><? include_component('cooks', 'badges', array('blog_id' => $video['user_site_id'], 'class' => 'hor-list')) ?></div>
    </p>
    
    <? include_partial("video_sharebar"); ?>

      
</div>
<? endif; ?>
<div id="comments">
	<p class="header"><span class="green">COMMENTS</span></p>
  <ul class="img100left">
	<? if (sizeof($comments) > 0): ?>
		<? include_partial('global/comments', compact('comments', 'comments_pager', 'contentId')) ?>
  <? endif; ?>
  </ul>
</div><!-- /#comments -->
            
            
      