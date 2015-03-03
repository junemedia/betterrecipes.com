<? $contest = $form->getObject() ?>
<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div id="mainHeading">
  <h1><? $contest->getName() ?></h1>
</div>
<div id="contestContainer" class="container small edit">
  <h2>General Details <a href="<?= UrlToolkit::getUrl('@contests_detail', array('slug' => $contest->getSlug(), 'mode' => 'preview')) ?>" title="Preview '<?= $contest->getName() ?>'" target="_blank" class="lp150">Preview "<?= $contest->getName() ?>"</a></h2>
  <? include_partial('form', array('form' => $form)) ?>
</div>
<script>
  $(document).ready(function(){
    //Sponsor Update
    $("#submitSponsor").click(function() { 
      var itemId = <?= $contest->getId() ?>;
      var sponsorId = $("#sponsors option:selected").val();
      $("#currentSponsor").html(function(){
        $("#currentSponsor").load("<?= url_for('contests/updateSponsor')?>", {itemId:itemId, sponsorId:sponsorId});
      });    
    }); 
  });
</script>
<div id="recipeSidebarSponsor" class="container sidebar sponsor">
  <div id="subHeading">
    <h3>Sponsor</h3>
    <p class="text">Current Sponsor:</p>
    <p id="currentSponsor" class="test" ><?= !is_null($contest->getSponsorId()) ? $contest->getSponsor()->getName() : "None" ?></p>    
      <? include_partial('sponsor', array('contestId' => $contest->getId(), 'sponsors' => $sponsors, 'edit' => true)) ?>
      <input type="submit" class="submit" name="submit" id="submitSponsor" value="Save" onclick="javascript:;" />    
  </div>
</div>