<? if ($my_profile): $action = $sf_request->getParameter('action'); ?>
  <p class="mt20 ml320">
    <?= ($action == 'editProfile' ? 'Edit Profile' : link_to('Edit Profile', getRoute('@cook_profile_edit', compact('display_name')))) ?>
  </p>
<? endif; ?>