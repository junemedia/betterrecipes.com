<div class="article">
  <? include_partial('cooks/user_links', compact('user', 'my_profile')) ?>
  <p class="title green mt-40">Update E-mail Preferences</p>
  
  <? if ($form->hasGlobalErrors()): ?>
  <?= $form->renderGlobalErrors() ?>
  <? endif ?>
  <form class="standard-form email-settings" action="<?= getDomainUri().url_for('cook_profile_email_settings', $user) ?>" method="post">
    <?= $form->renderHiddenFields() ?>
    <table>
      <tbody>
        <tr>
          <td><?= $form['email_notification']->renderLabel() ?></td>
          <td>
            <table>
              <?= $form['email_notification'] ?>
            </table>
            <?= $form['email_notification']->renderError() ?>
          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="5">
            <input type="submit" name="submit" value="submit" class="btn-grey28 mr0" />
          </td>
        </tr>
      </tfoot>
    </table>
<!--    <table>
      <thead>
        <tr>
          <td width="200px"></td>
          <td width="100px">Immediately</td>
          <td width="100px">Daily</td>
          <td width="100px">Weekly</td>
          <td width="100px">Never</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Private Messages Sent to Me</td>
          <td><input type="radio" name="messages" value="one" /></td>
          <td><input type="radio" name="messages" value="two" /></td>
          <td><input type="radio" name="messages" value="three" /></td>
          <td><input type="radio" name="messages" value="four" /></td>
        </tr>
        <tr>
          <td>Replies to My Posts</td>
          <td><input type="radio" name="replies" value="one" /></td>
          <td><input type="radio" name="replies" value="two" /></td>
          <td><input type="radio" name="replies" value="three" /></td>
          <td><input type="radio" name="replies" value="four" /></td>
        </tr>
        <tr>
          <td>New Posts From:</td>
          <td><input type="radio" name="new" value="one" /></td>
          <td><input type="radio" name="new" value="two" /></td>
          <td><input type="radio" name="new" value="three" /></td>
          <td><input type="radio" name="new" value="four" /></td>
        </tr>
        <tr>
          <td>SE Cooking Club</td>
          <td><input type="radio" name="club" value="one" /></td>
          <td><input type="radio" name="club" value="two" /></td>
          <td><input type="radio" name="club" value="three" /></td>
          <td><input type="radio" name="club" value="four" /></td>
        </tr>
        <tr>
          <td>Tips for Tots</td>
          <td><input type="radio" name="tips" value="one" /></td>
          <td><input type="radio" name="tips" value="two" /></td>
          <td><input type="radio" name="tips" value="three" /></td>
          <td><input type="radio" name="tips" value="four" /></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="5">
            <input type="button" name="submit" value="submit" class="btn-grey28 mr0" />
          </td>
        </tr>
      </tfoot>
    </table>-->
  </form>
</div>
<? include_partial('global/right_rail/right_rail_loggedin', compact('groups', 'friends', 'contentId', 'comments', 'user_id', 'profile', 'user', 'my_profile')) ?>