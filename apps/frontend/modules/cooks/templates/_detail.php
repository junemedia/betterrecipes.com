<div id="public-profile">
  <div class="main-image">
    <img src="<?= $user->getAvatarSrc() ?>" width="150" alt="<?= $user->getDisplayName() ?>" />
  </div>
  <h3 class="title green ml195">
    <?= $user->getDisplayName() ?>
  </h3>
  <? if ($sf_user->isAuthenticated()): ?>
  	<? if ( ! $sf_user->getRegSourceAttribute('auth_token') ): ?>
		<div id="upGigyaContainer">
			<div id="upGigya">
			
			</div><!-- // upGigya -->
		</div><!-- // upGigyaContainer -->  	
		<script>
		      $(document).ready(function() {
		        gigya.socialize.showLoginUI({ 
		          height: 30
		          ,width: 250
		          ,showTermsLink:false // remove 'Terms' link
		          ,hideGigyaLink:true // remove 'Gigya' link
		          ,buttonsStyle: 'signInWith' 
		          ,showWhatsThis: false // Pop-up a hint describing the Login Plugin, when the user rolls over the Gigya link.
		          ,containerID: 'upGigya' // The component will embed itself inside the loginDiv Div 
		          ,cid:''
		          ,redirectURL: 'http://' + document.domain + '/auth/socialize'
		          ,siteName: 'betterrecipes.com'
		          ,enabledProviders: 'facebook'
		        });
		      });
		    </script>
  	<? endif; ?>
  <? endif; ?>
  
  <? if ($my_profile): $action = $sf_request->getParameter('action'); ?>
    <p class="mt20 ml195">
      <?= ($action == 'editProfile' ? 'Edit Profile' : link_to('Edit Profile', getRoute('@cook_profile_edit', array('display_name' => $user->getDisplayName())))) ?>
    </p>
  <? endif; ?>
  <? if (($interests = $user->getInterests()) && $interests->count()): ?>
    <p class="fs14 ttupp mt20 ml195"><?= ($my_profile ? 'My' : $user->getDisplayName()) ?> Interests</p>
    <p class="interests ml195">
      <?
      $i = 0;
      foreach ($interests as $interest):
        ?><?= ($i++ > 0) ? ', ' : '' ?><?= $interest->getName() ?><? endforeach ?>
      <!-- </div> -->
    <? endif ?>
    <? if (isset($points) && sizeof($points) > 0): ?>
    <p class="interests ml195"><!-- -->
      Points earned: <strong><?= $points['points'] ?></strong>
    </p>
  <? endif; ?>
</div><!-- /#public-profile -->