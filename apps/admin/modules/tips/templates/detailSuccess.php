<script>
$( function()
{
  $('#save_contests').click(function(e)
  {
    e.preventDefault();
    if( $('#contests').val() != -1 )
    {
      $('#contest_ids').val($('#contest_ids').val() + $('#contests').val() + ',' );
      $('#contest_list').append('<li>' + $('#contests :selected').text() + '<a href="#" class="remove_contest" onclick="remove_contest(this, ' + $('#contests').val() + '); return false;">Remove</a></li>' );
      $("#contests").val('-1');
    }
  });

});
function remove_contest(a_object, id)
{
    $(a_object).parent().remove();
    $('#contest_ids').val( $('#contest_ids').val().replace(id + ',', '') );
}
</script>

<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div id="mainHeading">
  <h1><?= $tip->getTitle() ?></h1>
</div>
<div id="tipContainer" class="container small">
  <div id="subHeading">
    <h2>General Details</h2>
    <form id="recipeSearch" action="<?= url_for('tips/edit?id=' . $tip->getId()) ?>">
      <input type="submit" class="detail btn-grey28" value="Edit" />
    </form>
  </div>
  <div class="list">
    <ul>
      <ul>
        <? foreach ($contests as $contest): ?>
          <li><span class="label">Contest</span><span class="data"><?= $contest->getName() ?></span></li>
        <? endforeach ?>
      </ul>
      <li><span class="label">Title</span><span class="data"><?= $tip->getTitle() ?></span></li>
      <li><span class="label">Url</span><span class="data"><?= $tip->getUrl() ?></span></li>
    </ul>      
  </div>
</div>