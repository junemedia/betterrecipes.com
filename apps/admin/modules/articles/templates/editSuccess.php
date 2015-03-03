<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div id="mainHeading">
  <h1><?= $form->getObject()->getName() ?></h1>
</div>
<?php include_partial('form', array('form' => $form, 'sponsors' => $sponsors)) ?>