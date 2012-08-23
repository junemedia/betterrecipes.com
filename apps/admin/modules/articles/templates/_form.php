<? $article = $form->getObject() ?>
<script>
  $(document).ready(function(){
    $("#is_active_chkbox").change(function(){
      if($(this).attr("checked")){
        $("#article_is_active").val(1);
      } else {
        $("#article_is_active").val(0);
      }
    });    
  });
</script>
<? // var_dump($form->getErrorSchema()->getErrors()); ?>
<form action="<?= url_for('articles/' . ($article->isNew() ? 'create' : 'update') . (!$article->isNew() ? '?id=' . $article->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <? if (!$article->isNew()): ?>
    <input type="hidden" name="sf_method" value="put" />
  <? endif; ?>
  <div id="articleContainer" class="container small edit">
    <h2>General Details<? if (!$article->isNew()): ?> <a href="<?= UrlToolkit::getUrl($article, array('mode' => 'preview')) ?>" title="Preview '<?= $article->getName() ?>'" target="_blank" class="lp150">Preview "<?= $article->getName() ?>"</a><? endif; ?></h2>
    <? if (!$article->isNew()): ?>
      <?= link_to('Delete', 'articles/delete?id=' . $article->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?', 'id' => 'deleteArticle')) ?>
    <? endif; ?>
    <?php echo $form->renderHiddenFields(false) ?>
    <?php echo $form->renderGlobalErrors() ?>
    <div id="articles" class="fields small">
      <div class="field small">
        <?= $form['category_id']->renderError() ?>
        <?= $form['category_id']->renderLabel() ?>      
        <?= $form['category_id'] ?>
      </div>
      <div class="field small">
        <?= $form['name']->renderError() ?>
        <?= $form['name']->renderLabel() ?>      
        <?= $form['name'] ?>
      </div>
      <? if (!$article->isNew()): ?>      
        <div class="field small">
          <?= $form['slug']->renderError() ?>
          <?= $form['slug']->renderLabel() ?>      
          <?= $form['slug'] ?>
        </div>
      <? endif; ?>
      <div class="field small">
        <?= $form['description']->renderError() ?>
        <?= $form['description']->renderLabel(null, array('class' => "descript")) ?>      
        <?= $form['description'] ?>
      </div>
      <div class="field small">
        <?= $form['image']->renderError() ?>
        <?= $form['image']->renderLabel() ?>        
        <? if (!$article->isNew()) { ?>
          <div class="curImg" >
            <img src="<?= $article->getImgSrc('200x200') ?>" alt="" />
            <?= $form['image'] ?>
          </div>
        <? } else { ?>
          <?= $form['image'] ?>
        <? } ?>

      </div>
      <div class="field small">
        <?= $form['title_tag']->renderError() ?>
        <?= $form['title_tag']->renderLabel() ?>      
        <?= $form['title_tag'] ?>
      </div>
      <div class="field small">
        <?= $form['summary']->renderError() ?>
        <?= $form['summary']->renderLabel() ?>      
        <?= $form['summary'] ?>
      </div>
      <div class="field small">
        <?= $form['keywords']->renderError() ?>
        <?= $form['keywords']->renderLabel() ?>      
        <?= $form['keywords'] ?>
      </div>
      <div class="field small">
        <?= $form['is_active']->renderError() ?>
        <?= $form['is_active']->renderLabel() ?>      
        <?= $form['is_active'] ?>
        <input type="checkbox" id="is_active_chkbox" name="is_active_chkbox"<? if ($form['is_active']->getValue() == 1): ?> checked<? endif; ?> >
      </div>
      <div class="field small">
        <div class="action small flri">
          <a href="<?php echo url_for('articles/index') ?>">Cancel</a>
          &nbsp;&nbsp;or&nbsp;&nbsp;
          <input type="submit" class="submit btn-grey28" value="Save" />
        </div>
      </div>
    </div>
  </div>
  <?php if (!$article->isNew()): ?>
    <div id="articleSidebarSponsor" class="container sidebar sponsor">
      <div id="subHeading">
        <h3>Sponsor</h3>
        <p class="text">Current Sponsor:</p>
        <p id="currentSponsor" class="test" ><?= !is_null($article->getSponsorId()) ? $article->getSponsor()->getName() : "None" ?></p>
        <? include_partial('sponsor', array('articleId' => $article->getId(), 'sponsors' => $sponsors, 'edit' => true)) ?>
        <input type="submit" class="submit" name="submit" id="submitSponsor" value="Save" onclick="editUpdateSponsor('<?= url_for('articles/updateSponsor') ?>', <?= $article->getId() ?>)" />
      </div>
    </div>
  <? endif; ?>
  <div id="articleContentContainer" class="container edit">
    <h2>Article Body Content</h2>
    <div id="articleContent" class="fields">
      <?= $form['content']->renderError() ?>     
      <?= $form['content'] ?>
      <div class="field">
        <div class="action flri">
          <a href="<?php echo url_for('articles/index') ?>">Cancel</a>
          &nbsp;&nbsp;or&nbsp;&nbsp;
          <input type="submit" class="submit btn-grey28" value="Save" />
        </div>
      </div>
    </div>
  </div>
</form>