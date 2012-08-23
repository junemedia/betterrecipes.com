<script>
  $(document).ready(function() {
<? if ($sf_user->hasFlash('contestant_data')): ?>
      var contestant_data = JSON.parse('<?= $sf_user->getFlash('contestant_data') ?>');
      addEnteredContest(contestant_data.contestant_id, contestant_data.contest_title);
<? endif; ?>    
    setTimeout(function() {
      window.location.href = "<?= getUrl($recipe) ?>";
    }, 10000);
  });
</script>
<div class="article">
  <p>Thanks for submitting your recipe! Your recipe "<a href="<?= getUrl($recipe) ?>" title="View my recipe now"><?= $recipe->getName() ?></a>" has been successfully saved</p>
  <p class="mt10">
    <a href="<?= getUrl($recipe) ?>" title="View <?= $recipe->getName() ?>" class="btn-purple28 mr10">View Recipe</a>
    <a href="<?= getUrl('@edit_recipe', array('id' => $recipe->getId())) ?>" title="Edit <?= $recipe->getName() ?>" class="btn-purple28">Edit Recipe</a>
  </p>
</div>
