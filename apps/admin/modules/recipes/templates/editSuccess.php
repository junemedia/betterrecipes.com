<? $recipe = $form->getObject() ?>
<script>
  $(document).ready(function(){
    //Sponsor Update
    $("#submitSponsor").click(function() { 
      var itemId = <?= $recipe->getId() ?>;
      var sponsorId = $("#sponsors option:selected").val();
      $("#currentSponsor").html(function(){
        $("#currentSponsor").load("<?= url_for('recipes/updateSponsor') ?>", {itemId:itemId, sponsorId:sponsorId});
      });          
    }); 
  });
</script>
<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div id="mainHeading">
  <h1><?= $recipe->getName() ?></h1>
</div>
<div id="recipeContainer" class="container small edit">
  <h2>General Details <a href="<?= UrlToolkit::getUrl($recipe, array('mode' => 'preview')) ?>" title="Preview '<?= $recipe->getName() ?>'" target="_blank" class="lp150">Preview "<?= $recipe->getName() ?>"</a></h2>
  <?php include_partial('form', compact('form', 'maincategories', 'subcategories')) ?>
</div>
<div id="recipeSidebarSponsor" class="container sidebar sponsor">
  <div id="subHeading">
    <h3>Sponsor</h3>
    <p class="text">Current Sponsor:</p>
    <p id="currentSponsor" class="test" ><?= !is_null($recipe->getSponsorId()) ? $recipe->getSponsor()->getName() : "None" ?></p>
    <? include_partial('sponsor', array('recipeId' => $recipe->getId(), 'sponsors' => $sponsors, 'edit' => true)) ?>
    <input type="submit" class="submit btn-grey28" name="submit" id="submitSponsor" value="Save" onclick="javascript:;" />
  </div>
</div>

