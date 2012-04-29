<?php

$modelData = new AceXMLElement(file_get_contents(ACE_DIR."app/websites.xml"));

$item = $modelData->addChild('item');
$modelConfig = new AceXMLElement(ACE_DIR.'ide/config/websites.xml', 0, true);
foreach($modelConfig->forms->add->fields->children() as $field=>$stuff) {
	$item->$field = trim($_POST[$field]);
}

file_put_contents(ACE_DIR."app/websites.xml", $modelData->asNiceXml());
