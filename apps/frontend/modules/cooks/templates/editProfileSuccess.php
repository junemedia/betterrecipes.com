<? slot('gpt') ?>

unitValues: {
                	channel: 'profile', /* Set to the top level category id, if applicable */
                
                	parent: '', /* Set to the secondary level category id, if applicable */
                
                	child: '' /* Set to the tertiary level category id, if applicable */
                
            },
            pageTargetingValues: { /* Additional key-values can be added to this section if needed */
            		id: '<?php echo md5($sf_request->getUri())?>', /* Set to a page-specific unique id*/
                	type: '', /* Set the content type ( 'category', 'recipe', 'slideshow', etc.) */
                	search: '' /* On search results, set to the search term */
                
            }


<? end_slot() ?>

<script>
  var has_fb = <?= $user->hasFb() ? 1 : 0 ?>;
  var current_avatar = "<?= $user->getAvatarSrc() ?>";
  var alt_avatar = "<?= $user->getLocalAvatarSrc() ?>";
  $(document).ready(function() {
    $(".avatar-img").click(function() {
      if($("#user_fb_share").val() == 0 || !has_fb){
        $("#user_avatar").val("default_" + $(this).attr("avatar_id") + ".jpg");
        $("#user_avatar_image").attr("src", $(this).attr("src"));
      }
    });
    $("#fb_share_chk").change(function(){
      if($(this).attr("checked")){
        if(has_fb){
          $("#user_fb_share").val(1);
          $("#avatar_list").slideUp("fast");
          $("#user_avatar_image").attr("src", current_avatar);
        } else {
          alert("You don't have a Facebook account associated with Betterrecipes.com. Please logout then click on the Facebook button on the login screen and follow the steps to associate your Facebook account with Betterrecipes.com");
        }
      } else {
        $("#user_fb_share").val(0);
        $("#avatar_list").slideDown("fast");
        $("#user_avatar_image").attr("src", alt_avatar);
      }
    });
    $("#change_avatar").click(function(){
      if($(this).hasClass("show")){
        $(this).removeClass("show");
        $('.profile-photo-toggles.options').show();
        if($("#profile-photo-toggle-choice").attr('checked')){
          $('.profile-photo-toggles.avatars').slideDown("fast");
        } else {
          $('.upload_btn').slideDown("fast");
        }
      } else {
        $(this).addClass("show");
        $('.profile-photo-toggles.options').hide();
        if($("#profile-photo-toggle-choice").attr('checked')){
          $('.profile-photo-toggles.avatars').slideUp("fast");
        } else {
          $('.upload_btn').slideUp("fast");
        }
      }
    });
    $("#profile-photo-toggle-choice").click(function(){
      $('.upload_btn').slideUp("fast");
      $('.avatar-list').slideDown("fast");
    });
    $("#profile-photo-toggle-upload").click(function(){
      $('.avatar-list').slideUp("fast");
      $('.upload_btn').slideDown("fast");
    });
<? if ($userForm['profile_photo']->hasError()): ?>
      $("#change_avatar").click();
      $("#profile-photo-toggle-upload").click();
<? endif ?>
  });
</script>
<div class="article">
  <? /* include_partial('cooks/user_links', compact('user', 'my_profile')) */ ?>
  <p class="title green">Edit Settings <a href="javascript:;" title="Edit your profile" id="open_editprofile" class="btn-grey28 ml20 cta_edit<? if (!$sf_user->hasFlash('notice')): ?> hidden<? endif ?>">edit information</a></p>
  <form autocomplete="off" class="standard-form profile-edit-form mt20" action="<?= getRoute('@cook_profile_edit', array('display_name' => $sf_user->getDisplayName())) ?>" method="post" enctype="multipart/form-data">
    <fieldset class="user-details flle inline-changes values<? if (!$sf_user->hasFlash('notice')): ?> hidden<? endif ?>">
      <fieldset>
        <label for="user_username">Display Name:</label>
        <p><?= $user->getDisplayName() ?></p>
        <input type="text" name="user[display_name]" class="start-hidden" />
      </fieldset>
      <fieldset>
        <label for="user_password">Password:</label>
        <p>**********</p>
      </fieldset>
      <fieldset>
        <label for="user_email">Email:</label>
        <p><?= $user->getEmail() ?></p>
      </fieldset>
      <fieldset>
        <label for="user_location">Location:</label>
        <p><?= $user->getLocation() ?></p>
      </fieldset>
      <fieldset>
        <label for="user_about">About me:</label>
        <p><?= $user->getAboutMe() ?></p>
      </fieldset>
    </fieldset>
    <fieldset class="user-details flle inline-changes editing<? if ($sf_user->hasFlash('notice')): ?> hidden<? endif ?>">
      <?= $userForm->renderHiddenFields() ?>
      <? if ($userForm->hasGlobalErrors()): ?>
        <?= $userForm->renderGlobalErrors() ?>
      <? endif ?>
      <br>
      <? /* <fieldset class="profile-photo<? if ($user->isSocial()): ?> hidden<? endif; ?>" id="avatar_list"> */ ?>
      <fieldset class="profile-photo" id="avatar_list">
        <label><a id="change_avatar" class="show">Change Avatar</a></label>
        <fieldset class="profile-photo-toggles hidden options">
          <span class="action">
            <span>
              <label>Browse</label>
            </span>
            <span>
              <input type="radio" id="profile-photo-toggle-choice" class="profile-photo-toggle" name="profile-photo-toggle" value="choice" checked="true" />
              <label for="profile-photo-toggle-choice">Gallery</label>
            </span>
            <span>
              <input type="radio" id="profile-photo-toggle-upload" class="profile-photo-toggle" name="profile-photo-toggle" value="upload" />
              <label for="profile-photo-toggle-upload">Computer</label>
            </span>
          </span>
        </fieldset>
      </fieldset>
      <? /* <fieldset class="profile-photo<? if ($user->isSocial()): ?> hidden<? endif; ?>" id="avatar_list"> */ ?>
      <fieldset class="profile-photo" id="avatar_list">
        <fieldset class="profile-photo-toggles hidden avatars">
          <ul class="avatar-list">
            <? for ($i = 1; $i <= 16; $i++): ?>
              <li><img src="<?= getDefaultAvatarSrc($i) ?>" alt="User Avatar" avatar_id="<?= $i ?>" class="avatar-img"/></li>
            <? endfor; ?>
          </ul>
        </fieldset>
        <fieldset class="upload_btn hidden">
          <?= $userForm['profile_photo'] ?>
          <?= $userForm['profile_photo']->renderError() ?>
        </fieldset>
      </fieldset>
      <br>
      <fieldset class="profile-photo">
        <label>Profile Photo</label>
        <p><img src="<?= $user->getAvatarSrc() . '?t=' . time() ?>" alt="User Avatar" id="user_avatar_image"/></p>
      </fieldset>
      <fieldset<? if (!$user->hasFb()): ?> class="hidden"<? endif ?>>
        <?= $userForm['fb_share']->renderLabel() ?>
        <?= $userForm['fb_share'] ?>
        <input type="checkbox" id="fb_share_chk" <? if ($user->getFbShare()): ?> checked<? endif; ?>> 
        <?= $userForm['fb_share']->renderError() ?>
      </fieldset>
      <fieldset>
        <?= $userForm['display_name']->renderLabel() ?>
        <?= $userForm['display_name'] ?><span class="required">*</span>
        <?= $userForm['display_name']->renderError() ?>
      </fieldset>
      <fieldset>
        <?= $userForm['first_name']->renderLabel() ?>
        <?= $userForm['first_name'] ?><span class="required">*</span>
        <?= $userForm['first_name']->renderError() ?>
      </fieldset>
      <fieldset>
        <?= $userForm['last_name']->renderLabel() ?>
        <?= $userForm['last_name'] ?><span class="required">*</span>
        <?= $userForm['last_name']->renderError() ?>
      </fieldset>
      <fieldset>
        <?= $userForm['password']->renderLabel() ?>
        <?= $userForm['password'] ?>
        <?= $userForm['password']->renderError() ?>
      </fieldset>
      <fieldset>
        <?= $userForm['password_again']->renderLabel() ?>
        <?= $userForm['password_again'] ?>
        <?= $userForm['password_again']->renderError() ?>
      </fieldset>
      <fieldset>
        <?= $userForm['email']->renderLabel() ?>
        <?= $userForm['email']->render() ?><span class="required">*</span>
        <?= $userForm['email']->renderError() ?>
      </fieldset>
      <fieldset>
        <?= $userForm['address1']->renderLabel() ?>
        <?= $userForm['address1']->render() ?><span class="required">*</span>
        <?= $userForm['address1']->renderError() ?>
      </fieldset>
      <fieldset>
        <?= $userForm['address2']->renderLabel() ?>
        <?= $userForm['address2']->render() ?>
        <?= $userForm['address2']->renderError() ?>
      </fieldset>
      <fieldset>
        <?= $userForm['city']->renderLabel() ?>
        <?= $userForm['city']->render() ?><span class="required">*</span>
        <?= $userForm['city']->renderError() ?>
      </fieldset>     
      <fieldset>
        <?= $userForm['state']->renderLabel() ?>
        <?= $userForm['state']->render() ?><span class="required">*</span>
        <?= $userForm['state']->renderError() ?>
      </fieldset>
      <fieldset>
        <?= $userForm['zipcode']->renderLabel() ?>
        <?= $userForm['zipcode']->render() ?><span class="required">*</span>
        <?= $userForm['zipcode']->renderError() ?>
      </fieldset>
      <fieldset>
        <?= $userForm['country']->renderLabel() ?>
        <?= $userForm['country']->render() ?><span class="required">*</span>
        <?= $userForm['country']->renderError() ?>
        <fieldset>
          <?= $userForm['about_me']->renderLabel() ?>
          <?= $userForm['about_me'] ?>
          <?= $userForm['about_me']->renderError() ?>
        </fieldset>
        <fieldset>
        	<?= $userForm['website_name']->renderLabel() ?>
        	<?= $userForm['website_name'] ?>
        	<?= $userForm['website_name']->renderError() ?>
        </fieldset>
        <fieldset>
        	<?= $userForm['website_address']->renderLabel() ?>
        	<?= $userForm['website_address'] ?>
        	<?= $userForm['website_address']->renderError() ?>
        </fieldset>
        <fieldset class="areas">
          <?= $userForm['interests_list']->renderLabel() ?>
          <?= $userForm['interests_list'] ?>
          <?= $userForm['interests_list']->renderError() ?>
        </fieldset>
        <fieldset>
          <input type="submit" name="submit" value="Save" class="btn-grey28 mr0" />
          <a href="javascript:;" title="Edit your profile" id="close_editprofile" class="flri mt5 mr20">cancel</a>
        </fieldset>
      </fieldset>
  </form>
</div><!-- /.section -->
<? include_partial('global/right_rail/right_rail_loggedin', compact('groups', 'friends', 'contentId', 'comments', 'user_id', 'profile', 'user', 'my_profile')) ?>