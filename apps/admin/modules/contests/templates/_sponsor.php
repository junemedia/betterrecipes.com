<select name="sponsors" id="sponsors" class="sponsors" onchange="<? if(!isset($edit)): ?> updateSponsor(this, '<?= url_for('contests/updateSponsor')?>', <?=$contestId?>) <? endif; ?>">
  <option value="">-- Select One --</option> 
  <? if($edit): ?>
    <option value="0">None</option> 
  <? endif; ?>
  <? foreach ($sponsors as $s): ?>
    <option value="<?= $s->getId() ?>" ><?= $s->getName() ?></option>
  <? endforeach; ?>
</select>

