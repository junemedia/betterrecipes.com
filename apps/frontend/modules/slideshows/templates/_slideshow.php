<? $slide_count = count($slides) ?>
<script type="text/javascript">
  var slides = new Array();
  var curslide = 0;
  $(document).ready(function() {
    pageno = parseInt(window.location.hash.replace("#", ""));
    if (!isNaN(pageno) && pageno > 1) {
      curslide = pageno - 1;
    }
    setImages(false);
    $("#view_thumbnails").bind("click", function() {
      toggleThumbnails(this)
    });
  });
  function toggleThumbnails(){
    if ($("#slidesshowthumbs").hasClass("display-none")) {
      $("#view_thumbnails").html("hide thumbnails");
      $("#slidesshowthumbs").removeClass("display-none");
    }
    else {
      $("#view_thumbnails").html("view all thumbnails");
      $("#slidesshowthumbs").addClass("display-none");
    }
  }

<? foreach ($slides as $key => $slide): ?>
  var slide = new Array();
  slide["url"] = "<?= $slide->getImgSrc() ?>";
  slide["recipeurl"] = "<?= getUrl($slide->getImgParentObj()) ?>";
  slide["recipeid"] = "<?= $slide->getImgParentObj()->getId() ?>";
  slide["recipetitle"] = "<?= htmlspecialchars($slide->getImgParentObj()->getName()) ?>";
  slide["title"] = "<?= htmlspecialchars($slide->getName()) ?>";
  slide["content"] = "<?= str_replace(array("\r\n","\r","\n") , '<br />', htmlspecialchars(trim($slide->getContent()))) ?>";
  slides[<?= $key ?>] = slide;
<? endforeach; ?>

  function getPrevious() {
    if (curslide > 0) {
      curslide--;
      window.location.hash = parseInt(curslide) + 1;
      location.reload();
    }
  }

  function getNext() {
    if (curslide < slides.length - 1) {
      curslide++;
      window.location.hash = parseInt(curslide) + 1;
      location.reload();
    }
  }

  function goToSlide(slide_no) {
    toggleThumbnails();
    curslide = parseInt(slide_no);
    window.location.hash = parseInt(curslide) + 1;
    setImages(true);
  }

  function setImages(refresh_ads) {
    $("#slide").fadeOut("fast");
    $("#page_no").html(curslide+1);
    $("#slide").attr("src", slides[curslide]["url"]);
    $("#sliderecipe").attr("href", slides[curslide]["recipeurl"]);
    $("#sliderecipe").attr("title", slides[curslide]["recipetitle"]);
    $("#title").html(slides[curslide]["title"]);
    $("#content").html(slides[curslide]["content"]);
    $("#slide").fadeIn("fast");

    if (curslide == 0) {
      $("#previous_arrow").addClass("inactive").removeAttr("onclick");
    }
    else {
      $("#previous_arrow").removeClass("inactive").attr("onclick", "getPrevious()");
    }

    if (curslide == slides.length - 1) {
      $("#next_arrow").addClass("inactive").removeAttr("onclick");
    }
    else {
      $("#next_arrow").removeClass("inactive").attr("onclick", "getNext()");
    }

    // refresh GPT ad tags (leaderboard / right rail)
    refreshAdFrame();
    // refresh VSW ad
    refreshVsw();
    updateOmniture();
  }

  function updateOmniture() {
    s.pageName = s.eVar9 = "Slideshow:<?= htmlspecialchars($slideshow->getName()) ?>:" + slides[curslide]["recipetitle"] + ":Slide" + (curslide+1);
    s.t()
  }

  function appendPageNo(obj) {
    if (window.location.hash != "") {
      $(obj).attr("href", $(obj).attr("href") + window.location.hash.replace("#", "/"));
    }
  }
</script>

<p class="title green"><?= $slideshow->getName() ?></p>
<p class="mb20 summary"><?= $slideshow->getDescription() ?></p>
<? include_partial('global/sharebar', compact('slideshow', 'showall')); ?>
<div id="slideshow">
  <ul class="hornav">
    <li class="cta">
      <a id="previous_arrow" class="prev-slide btn-grey28 inactive" title="Previous Slide">PREV</a>
    </li>
    <li>
      <p id="caption1"><span id="page_no">1</span>/<?= $slide_count ?></p>
    </li>

    <? if ($slide_count > 1): ?>
    <li class="cta">
      <a id="next_arrow" onclick="getNext()" class="next-slide btn-grey28" title="NEXT Slide">NEXT</a>
    </li>
    <? else: ?>
    <li class="cta">
      <a id="next_arrow" class="next-slide btn-grey28 inactive" title="NEXT Slide">NEXT</a>
    </li>
    <? endif; ?>
  </ul>

  <div class="slides">
  <? if ($slide_count > 0): ?>
    <div class="slide">
      <img id="slide" src="/img/spinning-wheel-1.gif" height="225" width="300" alt="Recipe Title" />

      <p class="green" id="title"></p>
      <p id="content"></p>
      <p class="mt10"><a  target="_blank" id="sliderecipe">View Recipe &raquo;</a></p>
    </div>
  <? else: ?>
    <p class="mt10">Currently there are no slides for this slideshow</p>
  <? endif; ?>
  </div>
</div>

