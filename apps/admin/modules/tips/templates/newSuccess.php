<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div id="mainHeading">
  <h1>New Tip</h1>
</div>

<?php include_partial('form', array('form' => $form, 'contests' => $contests )) ?>
