<? $meta = $form->getObject() ?>
<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div id="mainHeading">
  <h1>"<?= $meta->getName() ?>" meta data</h1>
</div>
<form action="<?= url_for('meta/edit?id=' . $meta->getId()) ?>" method="post" >
  <div id="articleContainer" class="container small edit">
    <h2>General Details</h2>
    <?php echo $form->renderHiddenFields(false) ?>
    <?php echo $form->renderGlobalErrors() ?>
    <div id="articles" class="fields small">
      <div class="field small">
        <?= $form['title']->renderError() ?>
        <?= $form['title']->renderLabel() ?>      
        <?= $form['title'] ?>
      </div>
      <div class="field small">
        <?= $form['description']->renderError() ?>
        <?= $form['description']->renderLabel() ?>      
        <?= $form['description'] ?>
      </div>
      <div class="field small">
        <?= $form['keywords']->renderError() ?>
        <?= $form['keywords']->renderLabel() ?>      
        <?= $form['keywords'] ?>
      </div>
      <div class="field small">
        <div class="action small flri">
          <a href="<?= url_for('meta/detail?id=' . $meta->getId()) ?>">Back</a>
          &nbsp;&nbsp;or&nbsp;&nbsp;
          <input type="submit" class="submit btn-grey28" value="Save" />
        </div>
      </div>
    </div>
  </div>
</form>