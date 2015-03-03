<div id="subHeading">
  <h2>Contest Winners</h2>
  <div id="contestWeek">    
    <select id="contestPeriod" onchange="contestPeriodChange(this)">
      <? foreach ($allContests as $c): ?>
        <option value="<?= $c->getId() ?>" <? if ($c->getWeekOffset() == $contestPeriod->getWeekOffset())
        echo 'selected="selected"' ?> >Week of <?= $c->getStartDate() . ' - ' . $c->getEndDate() ?></option>
              <? endforeach; ?>
    </select>
  </div>
</div>
<div id="userWinner" class="subSide">
  <div class="subHeading">
    <h2>User Selected</h2><br /><br />
    <? if ($contestPeriod->isPastContest()): ?>
      <a href="javascript:;" class="editWinner btn-grey28" id="user">Edit</a>
    <? endif; ?>
  </div>
  <div class="winner">
    <? $contestWinner = ''; ?>
    <? if ($contestPeriod->hasOfficialWinner()): ?>
      <? $contestWinner = $contestPeriod->getOfficialWinner() ?>
      <span class="mb10 dibl">Official Winner</span>
    <? else: ?>
      <? if ($contestPeriod->hasUnofficialWinner()): ?>
        <? $contestWinner = $contestPeriod->getUnofficialWinner() ?>
        <span class="mb10 dibl">Unofficial Winner</span>
      <? endif; ?>
    <? endif; ?>
    <span class="recipe"><?= ($contestWinner) ? $contestWinner->getRecipe()->getName() : 'No winner selected yet!'; ?></span>
    <span class="user"><?= ($contestWinner) ? 'Submitted by '.$contestWinner->getUser()->getDisplayName() : 'Choose Winner'; ?></span>
  </div>
</div>
<div id="editorWinner" class="subSide">
  <div class="subHeading">
    <h2>Editor Selected</h2>
    <? if ($contestPeriod->isPastContest()): ?>
      <a href="javascript:;" class="editWinner btn-grey28" id="editor">Edit</a>
    <? endif; ?>
  </div>
  <div class="winner">
    <? $contestEditorWinner = $contestPeriod->getEditorWinner(); ?>
    <span class="recipe"><?= ($contestEditorWinner) ? $contestEditorWinner->getRecipe()->getName() : 'No winner selected yet!'; ?></span>
    <span class="user"><?= ($contestEditorWinner) ? 'Submitted by '.$contestEditorWinner->getUser()->getDisplayName() : 'Choose Winner'; ?></span>
  </div>
</div>
<div id="edit">
  <?// include_partial('winnerForm', array('cpId' => $contestPeriod->getId(), 'contestWinner' => $contestWinner, 'contestEditorWinner' => $contestEditorWinner, 'contestId' => $contestPeriod->getContestId())) ?>
</div>
<script>
  $(document).ready(function(){
    
    //Editing Slides Modal Box    
    $(".editWinner").click(function(){
      $("#edit").load("<?= url_for('contests/winnerForm') ?>", { cpId: '<?= $contestPeriod->getId() ?>', contestId: <?= $contestPeriod->getContestId() ?>, winnerType: $(this).attr('id')});      
      var title;
      if ($(this).attr('id') == 'user') { title = 'Make Winner Official' } else { title = 'Choose a Winner' };
      $("#edit").dialog({ autoOpen: false, title: title, height:200, modal:true});
      $("#edit").css("display", "block");      
      $("#edit").dialog('open');
      $("#edit").css({"width" : "435px", "height" : "100px"});
      $(".ui-dialog").css({"width" : "460px", "height" : "180px", "position" : "fixed", "margin-top" : "-150px"});  
      $("#ui-dialog-title-edit").css("margin-left", "15px"); 
      
      return false;
    });
    
  });
</script> 