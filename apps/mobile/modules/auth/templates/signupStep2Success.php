<script>
  function updateAddress(zipcode){
    $.getJSON("/geo?q="+zipcode, function(data) {
      $("#user_city, #hidden_user_city").val(data['city']);
      $("#user_state, #hidden_user_state").val(data['state']);
    })
  }
  
  function validateAddress(field){
    if($("#hidden_user_"+field).val()!="" && $("#hidden_user_"+field).val()!=$("#user_"+field).val()){
      var r=confirm("The "+field+" and the zipcode you entered don't match. Do you want to keep the "+field+" you entered?");
      if (r==false)
      {
        $("#user_"+field).val($("#hidden_user_"+field).val());
      }
    }
  }
</script>
<div class="article registration reg-two">
  <? //include_component('static', 'topper') ?>
  <h3 class="title green" style="margin-bottom: 1em;">Step 2: Your Information</h3>
  <?= $form->renderGlobalErrors() ?>
  <form id="signup_step_2" class="standard-form" action="<?= getRoute('signup_step2') ?>" method="post" enctype="multipart/form-data">
    <?= $form->renderHiddenFields() ?>
    <fieldset class="article">
      <fieldset class="first">
        <?= $form['firstname']->renderLabel() ?>
        <?= $form['firstname']->render() ?><span class="required">*</span>
        <?= $form['firstname']->renderError() ?>
      </fieldset>
      <fieldset class="second">
        <?= $form['lastname']->renderLabel() ?>
        <?= $form['lastname']->render() ?><span class="required">*</span>
        <?= $form['lastname']->renderError() ?>
      </fieldset>
      <fieldset class="first">
        <?= $form['address']->renderLabel() ?>
        <?= $form['address']->render() ?><span class="required">*</span>
        <?= $form['address']->renderError() ?>
      </fieldset>
      <fieldset class="second">
        <?= $form['address_2']->renderLabel() ?>
        <?= $form['address_2']->render() ?>
        <?= $form['address_2']->renderError() ?>
      </fieldset> 
      <fieldset class="first">
        <?= $form['zip']->renderLabel() ?>
        <?= $form['zip']->render() ?><span class="required">*</span>
        <?= $form['zip']->renderError() ?>
      </fieldset>     
      <fieldset class="second">
        <?= $form['state']->renderLabel() ?>
        <?= $form['state']->render() ?><span class="required">*</span>
        <?= $form['state']->renderError() ?>
        <input type="hidden" id="hidden_user_state" />
      </fieldset>
      <fieldset class="first">
        <?= $form['city']->renderLabel() ?>
        <?= $form['city']->render() ?><span class="required">*</span>
        <?= $form['city']->renderError() ?>
        <input type="hidden" id="hidden_user_city" />
      </fieldset>
      <fieldset class="second">
        <?= $form['country']->renderLabel() ?>
        <?= $form['country']->render() ?><span class="required">*</span>
        <?= $form['country']->renderError() ?>
      </fieldset>
    </fieldset><!-- /.article -->
    <fieldset class="sidebar">
      <!--      <fieldset>
              <label for="">Areas of Interest</label>
              <p class="fs11 mb10">This information will get you recommendations for recipes cooking tip and groups that may be of interest to you</p>
              <ul class="hornav">
                <li><label for="checkbox_1"><input type="checkbox" name="checkbox_1" />Baking</label></li>
                <li><label for="checkbox_2"><input type="checkbox" name="checkbox_2" />Cooking For Kids</label></li>
                <li><label for="checkbox_3"><input type="checkbox" name="checkbox_3" />Entertaining</label></li>
                <li><label for="checkbox_4"><input type="checkbox" name="checkbox_4" />Ethnic Cooking</label></li>
                <li><label for="checkbox_5"><input type="checkbox" name="checkbox_5" />Cooking for Two Beginners</label></li>
                <li><label for="checkbox_6"><input type="checkbox" name="checkbox_6" />Local Groups</label></li>
                <li><label for="checkbox_7"><input type="checkbox" name="checkbox_7" />No-Cook/Bake Recipes</label></li>
                <li><label for="checkbox_8"><input type="checkbox" name="checkbox_8" />Food &amp; Wine Pairings</label></li>
              </ul>
            </fieldset>-->
      <fieldset class="profile-photo">
        <label>Profile Photo:</label>
        <fieldset class="profile-photo-toggles">
          <span class="action">
            <span>
              <input type="radio" id="profile-photo-toggle-upload" class="profile-photo-toggle" name="profile-photo-toggle" value="upload" checked="true" />
              <label for="profile-photo-toggle-upload">Browse Computer</label>
            </span>
            <span>
              <input type="radio" id="profile-photo-toggle-choice" class="profile-photo-toggle" name="profile-photo-toggle" value="choice" />
              <label for="profile-photo-toggle-choice">Browse Gallery</label>
            </span>
          </span>
        </fieldset>
        <fieldset class="profile-photo-fields">
          <fieldset class="profile-photo-upload">
            <?= $form['profile_photo'] ?>
            <?= $form['profile_photo']->renderError() ?>
          </fieldset>
          <fieldset class="profile-photo-choices" style="display: none;">
            <?= $form['profile_photo_choice'] ?>
            <?= $form['profile_photo_choice']->renderError() ?>
          </fieldset>
        </fieldset>
      </fieldset>


    </fieldset><!-- /.sidebar -->
    <fieldset class="about-me">
      <?= $form['about_me']->renderLabel() ?>
      <?= $form['about_me']->render() ?>
      <?= $form['about_me']->renderError() ?>
      <fieldset class="action">
        <input type="submit" value="Continue" class="btn-purple28 mr20 flno" />
        <a href="<?= getRoute('signup_skip') ?>" title="Skip this step" class="mt5">Do this later</a>
     	</fieldset>
    </fieldset>

  </form>
</div><!-- /.article -->
<div class="clearfix"></div>