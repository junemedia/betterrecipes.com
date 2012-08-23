<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div id="mainHeading">
  <h1><?= $form->getObject()->getTitle() ?></h1>
</div>
<?php include_partial('form_category', array('form' => $form)) ?>