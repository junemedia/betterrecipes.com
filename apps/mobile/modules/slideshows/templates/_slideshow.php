<? $slide_count = count($slides) ?>
<script type="text/javascript">
  var slides = new Array();
  var curslide = 0;
  $(document).ready(function() {
    pageno = parseInt(window.location.hash.replace("#",""));
    if (!isNaN(pageno) && pageno > 1) {
      curslide = pageno - 1;
    }
    setImages();
  }); 
<? foreach ($slides as $key => $slide): ?>
    var slide = new Array();
    slide["url"] = "<?= $slide->getImgSrc() ?>";   
    slide["recipeurl"] = "<?= getUrl($slide->getImgParentObj()) ?>";   
    slide["recipeid"] = "<?= $slide->getImgParentObj()->getId() ?>";   
    slide["recipetitle"] = "<?= htmlspecialchars($slide->getImgParentObj()->getName()) ?>";   
    slide["title"] = "<?= htmlspecialchars($slide->getName()) ?>";   
    slide["content"] = "<?= htmlspecialchars(trim($slide->getContent())) ?>";   
    slides[<?= $key ?>] = slide;
<? endforeach; ?>
  function getPrevious(){
    if(curslide > 0){
      curslide--;
      window.location.hash = parseInt(curslide) + 1;
    }
    setImages();
  }
  function getNext(){
    if(curslide < slides.length-1){
      curslide++;
      window.location.hash = parseInt(curslide) + 1;
    }
    setImages();
  }
  function setImages(){
    $("#slide").fadeOut("fast");
    $("#page_no").html(curslide+1);
    $("#slide").attr("src", slides[curslide]["url"]);
    $("#sliderecipe").attr("href", slides[curslide]["recipeurl"]);
    $("#sliderecipe").attr("title", slides[curslide]["recipetitle"]);
    $("#title").html(slides[curslide]["title"]);
    $("#content").html(slides[curslide]["content"]);
    $("#slide").fadeIn("fast");
    if(curslide==0){
      $("#previous_arrow").addClass("inactive").removeAttr("onclick");
    } else {
      $("#previous_arrow").removeClass("inactive").attr("onclick","getPrevious()");
    }
    if(curslide==slides.length-1){
      $("#next_arrow").addClass("inactive").removeAttr("onclick");
    } else {
      $("#next_arrow").removeClass("inactive").attr("onclick","getNext()");
    }
    refreshAdtags('slide_show');
    updateOmniture();
  }
  function updateOmniture(){
    s.pageName=s.eVar9="Slideshow:<?= htmlspecialchars($slideshow->getName()) ?>:"+slides[curslide]["recipetitle"]+":Slide"+(curslide+1);
    s.t()
  }
</script>
<p class="header"><span class="green"><?= $slideshow->getName() ?></span></p>
<p class="mb20 summary ml10 mr10"><?= $slideshow->getDescription() ?></p>
<div id="slideshow">
  <ul class="hornav">
    <li class="btn-prev"><a id="previous_arrow" class="prev-slide gray-btn inactive" title="Previous Slide">PREV</a></li>
    <li><p id="caption1"><span id="page_no">1</span>/<?= $slide_count ?></p></li>
    <? if ($slide_count > 1): ?>
      <li class="btn-next"><a id="next_arrow" onclick="getNext()" class="next-slide gray-btn" title="NEXT Slide">NEXT</a></li>
    <? else: ?>
      <li class="btn-next"><a id="next_arrow" class="next-slide gray-btn inactive" title="NEXT Slide">NEXT</a></li>
    <? endif; ?>
  </ul>
  <div class="slides">
    <? if ($slide_count > 0): ?>
      <div class="slide">
        <img id="slide" src="/img/spinning-wheel-1.gif" height="225" width="300" alt="Recipe Title" />
        <p class="green pt20" id="title"></p>
        <p id="content"></p>
        <p class="pt10"><a id="sliderecipe">View Recipe &raquo;</a></p>
      </div>
    <? else: ?>
      <p class="mt10 ml10 mr10">Currently there are no slides for this slideshow</p>
    <? endif; ?>
  </div>
</div>

