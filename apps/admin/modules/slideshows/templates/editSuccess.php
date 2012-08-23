<? $slideshow = $form->getObject() ?>
<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div id="mainHeading">
  <h1><?= $slideshow->getName() ?></h1>
</div>
<div id="recipeContainer" class="container small edit">
  <h2>General Details <a href="<?= UrlToolkit::getUrl($slideshow, array('mode' => 'preview')) ?>" title="Preview '<?= $slideshow->getName() ?>'" target="_blank" class="lp150">Preview "<?= $slideshow->getName() ?>"</a></h2>
  <?php include_partial('form', array('form' => $form)) ?>
</div>
<script>
  $(document).ready(function(){
    //Sponsor Update
    $("#submitSponsor").click(function() { 
      var slideshowId = <?= $slideshow->getId() ?>;
      var sponsorId = $("#sponsors option:selected").val();
      $("#currentSponsor").html(function(){
        $("#currentSponsor").load("<?= url_for('slideshows/updateSponsor') ?>", {slideshowId:slideshowId, sponsorId:sponsorId});
      });    
    }); 
  });
</script>
<div id="recipeSidebarSponsor" class="container sidebar sponsor">
  <div id="subHeading">
    <h3>Sponsor</h3>
    <p class="text">Current Sponsor:</p>
    <p id="currentSponsor" class="test" ><?= !is_null($slideshow->getSponsorId()) ? $slideshow->getSponsor()->getName() : "None" ?></p>    
    <? include_partial('sponsor', array('slideshowId' => $slideshow->getId(), 'sponsors' => $sponsors, 'edit' => true)) ?>
    <input type="submit" class="submit" name="submit" id="submitSponsor" value="Save" onclick="javascript:;" />    
  </div>
</div>
<div class="container big edit slides">
  <h2>Slides</h2>
  <? include_partial('slides', array('edit' => true, 'slideshow' => $form->getObject(), 'slideshowId' => $sf_params->get('id'), 'slides' => $slides)) ?>
</div>

