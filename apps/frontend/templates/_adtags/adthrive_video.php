<div id="adthrive-desktop-video">
  <script defer src="https://content.jwplatform.com/libraries/3W0rKM02.js"></script>
  <div class="player-container" style="margin: 0px auto;">
    <div class="player-position">
      <p class="title">Our Latest Videos</p>
      <div id="player" data-plid="rJavETLV" data-sticky data-shuffle></div>
    </div>
  </div>
  <script defer src="https://ads.adthrive.com/video/5bae4a611b5c414750fdf2a3.js"></script>
</div>
<div id="adthrive-mobile-video" style="display:flex; justify-content:center;">
  <center>
    <div>
      <p class="title">Our Latest Videos</p>
      <script defer type="text/javascript" language="javascript" src="https://live.sekindo.com/live/liveView.php?s=87493&cbuster=%%CACHEBUSTER%%&pubUrl=%%REFERRER_URL_ESC_ESC%%&x=340&y=260&vp_contentFeedId=rJavETLV&subId=5bae4a611b5c414750fdf2a3"></script>
    </div>
  </center>
</div>
<script>
  if (!/Mobi|Android/i.test(navigator.userAgent)) {
    let player = document.getElementById('adthrive-mobile-video');
    player.remove();
  } else if (/Mobi|Android/i.test(navigator.userAgent)) {
    let player = document.getElementById('adthrive-desktop-video');
    player.remove();
  }
</script>
