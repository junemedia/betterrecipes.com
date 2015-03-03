<style>
#recipePhotosOuter { position: relative; width: 400px; height: 300px; margin: 0 auto; }
#recipePhotosInner { background: none; width: 400px; height: 300px; position: absolute; top: 0; left: 0; }
#recipePhotosInner.fade { background: transparent url('/img/pin_transparency.png') repeat 0 0; }

#pinButtonPhotos { position: absolute; top:0; right:0; display: none; width: 80px; height: 50px; z-index: 999999; }
#pinButtonPhotos a { cursor: pointer; }
#pinButtonPhotos a img { width: auto; height: auto; }
</style>

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
  
  function pinit(e) {
  		var url = 'http://pinterest.com/pin/create/button/?url=<?=getUrl($recipe)?>';
  		url += '&media=<?=getDomainUri()?>'+$("#photo").attr("src");
  		url += '&description=<?=$recipe->getName()?>';
		window.open(url, 'pinterest', 'screenX=100,screenY=100,height=580,width=730');
		e.preventDefault();
		e.stopPropagation();
}

  
  jQuery(document).ready(function($){
  
  $('#recipePhotosOuter').hover(
      function () {
        $('#pinButtonPhotos').show();
      }, 
      function () {
        $('#pinButtonPhotos').hide();
      }
  );
  
  $('#pinButtonPhotos a img').mouseover(function(){
	  $('#recipePhotosInner').addClass('fade');
  });
  $('#pinButtonPhotos a img').mouseout(function(){
  	$('#recipePhotosInner').removeClass('fade');
  });
  
  }); // END: doc ready
  
</script>
<div id="recipePhotosOuter">
  <div id="pinButtonPhotos"><a onclick="pinit(event)"><img src="/img/pinit_button.png" /></a></div>
  <div id="recipePhotosInner"></div>
  <img id="photo" alt="Recipe Image" src="<?= $photos[0]->getImgSrc() ?>" />
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