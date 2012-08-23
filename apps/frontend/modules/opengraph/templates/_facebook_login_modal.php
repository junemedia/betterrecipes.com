<script>
  $(document).ready(function(){
    $("#facebook_overlay_img").click(function(evt) {
      $("#gigya-auth div[gigid='facebook']").parent().click();
    }); 
  }); 
</script>
<section class="popup" id="popup-login" style="left: 0px; opacity: 1; display:none; ">
  <article>
    <a href="javascript:;" onclick="closePopup(true)" title="Close Popup" class="btn-close">CLOSE POPUP</a>
    <div>
      <img src="/img/facebook_overlay.png" alt="facebook_overlay.png" id="facebook_overlay_img" />
      <!-- container for Gigya socialize callout -->
      <div id="gigya-auth" class="gigya-popup-auth"></div>
    </div>
  </article>
</section>