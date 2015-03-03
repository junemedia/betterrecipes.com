<script type="text/javascript">
  var photos = new Array();
  // note: Rusty Cage, found a bug here, JS arrays are zero based, curphoto was set to 1, now 0
  var curphoto = 0;
<? foreach ($photos as $key => $photo): ?>
    var photo = new Array();
    photo["url"] = "<?= $photo->getImgSrc() ?>";   
    photo["title"] = "<?= $photo->getName() ?>";   
    photo["description"] = "<?= $photo->getDescription() ?>";   
    photos[<?= $key ?>] = photo;
<? endforeach; ?>
  function getPrevious(){
    if(curphoto > 0){curphoto--;}
    setImages();
  }
  function getNext(){
    if(curphoto < photos.length-1){curphoto++;}  
    setImages();
  }
  function setImages(){
    $("#photo").fadeOut("fast");
    $("#photo").attr("src", photos[curphoto]["url"]);
    $("#title").html(photos[curphoto]["title"]);
    $("#description").html(photos[curphoto]["description"]);
    $("#photo").fadeIn("fast");
    if(curphoto==0){
      $("#previous_arrow").addClass("inactive").removeAttr("onclick");
    } else {
      $("#previous_arrow").removeClass("inactive").attr("onclick","getPrevious()");
    }
    if(curphoto==photos.length-1){
      $("#next_arrow").addClass("inactive").removeAttr("onclick");
    } else {
      $("#next_arrow").removeClass("inactive").attr("onclick","getNext()");
    }
  }
</script>
<div>
  <img id="photo" alt="Recipe Image" src="<?= $photos[0]->getImgSrc() ?>" width="430" />
</div>
<div id="title">
  <?= $photos[0]->getName() ?>  
</div>
<div id="description">
  <?= $photos[0]->getDescription() ?>  
</div>
<div id="nav_container">
  <ul class="image-nav">
    <li>
      <a id="previous_arrow" class="image-nav left-arrow inactive">Previous</a>
      <? if(count($photos)>1): ?>
      <a id="next_arrow" onclick="getNext()" class="image-nav right-arrow">Next</a>
      <? else: ?>
      <a id="next_arrow" class="image-nav right-arrow inactive">Next</a>
      <? endif; ?>
    </li>
  </ul>
  <p align="center">
  	<a style="cursor:pointer;" onclick="parent.cancelModal()">Cancel</a>
  </p>
</div>