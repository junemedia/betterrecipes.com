<?
$qstr = '@premiums?page=' . $sf_request->getParameter('page', 1) . '&sortby=' . $name . '&order=';
if ($sf_request->getParameter('sortby', 'created') == $name) {
  $qstr .= $sf_request->getParameter('order', 'DESC') == 'DESC' ? 'ASC' : 'DESC';
  $class = trim($class . ' ' . strtolower($sf_request->getParameter('order', '')));
} else {
  $qstr .= $sf_request->getParameter('order', 'ASC');
}
?>
<span id="<?= $name ?>_header" class="<?= $class ?>"><a href="<?= url_for($qstr) ?>"><?= $title ?></a></span>
