<field><?php if (isset($ShowDescription) && $ShowDescription == 'on') { ?><ShowDescription position="<?php if (isset($DescriptionPosition) && !empty($DescriptionPosition)) { echo $DescriptionPosition; } else {echo 'bottom';} ?>"><![CDATA[<div <?php if (isset($DescriptionCSSClass) && !empty($DescriptionCSSClass)) {echo "class='$DescriptionCSSClass'";}; if (isset($DescriptionCSSStyle) && !empty($DescriptionCSSStyle)) {echo " style='$DescriptionCSSStyle'";}; ?>><?php if (isset($Description)) {echo $Description; }; ?></div>]]></ShowDescription><?php } ?><Input><![CDATA[<?php $query = "SELECT Users.Options, Users.id FROM #wp__easycontactforms_customformfields AS CustomFormFields  LEFT JOIN #wp__easycontactforms_customforms AS CustomForms  LEFT JOIN #wp__easycontactforms_users AS Users  ON CustomForms.ObjectOwner = Users.id  ON CustomFormFields.CustomForms = CustomForms.id WHERE CustomFormFields.id = '$id'";$objs = EasyContactFormsDB::getObjects($query);$uoptsxml = '<data></data>';if (count($objs) == 1 && !empty($objs[0]->Options)) {	$uoptsxml = $objs[0]->Options;}$uoptsxml = simplexml_load_string($uoptsxml);if (!isset($uoptsxml->vcita)) {	$uoptsxml->addChild('vcita');	$uoptsxml->vcita->vcid = 'ecf.demo';	$uoptsxml->vcita->Confirmed = 'true';}$uopts = $uoptsxml->vcita;if (isset($uopts->Confirmed) && $uopts->Confirmed == 'true') {	if (isset($UseLink) && $UseLink == 'on') { ?><a href='http://www.vcita.com/<?php echo $uopts->vcid;?>/set_meeting' <?php $class = array();if (isset($SetStyle) && $SetStyle == 'on' && isset($CSSClass) && !empty($CSSClass)) { $class[] = $CSSClass; };if (count($class) > 0) {echo " class='" . implode(' ', $class) . "'";};$style = array();if (isset($SetStyle) && $SetStyle == 'on' && isset($CSSStyle) && !empty($CSSStyle)) {echo " style='" . $CSSStyle . "'";; };?>><span><?php echo $Label;?></span></a><div style='height:1px;clear:both'></div><?php } else { ?><a href='#' <?php $class = array();if (isset($SetStyle) && $SetStyle == 'on' && isset($CSSClass) && !empty($CSSClass)) { $class[] = $CSSClass; };$class[] = 'vcita-set-meeting';if (count($class) > 0) {echo " class='" . implode(' ', $class) . "'";};$style = array();if (isset($SetStyle) && $SetStyle == 'on' && isset($CSSStyle) && !empty($CSSStyle)) {echo " style='" . $CSSStyle . "'";; };?>><span><?php echo $Label;?></span></a><script type='text/javascript' charset='utf-8'>window.vcita_options = {};window.vcita_options.active_engage = false;var vcHost = document.location.protocol == "https:" ? "https:" : "http:";document.write(unescape("%3Cscript src='" + vcHost + "//www.vcita.com/<?php echo $uopts->vcid;?>/loader.js' type='text/javascript'%3E%3C/script%3E"));</script><div style='height:1px;clear:both'></div><?php }} ?>]]></Input></field>