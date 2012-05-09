<?php

$modelData = new AceXMLElement(file_get_contents(ACE_DIR."app/websites.xml"));
$modelConfig = new AceXMLElement(ACE_DIR.'ide/config/websites.xml', 0, true);

$item = $modelData->addChild('item');

foreach($modelConfig->forms->add->fields->children() as $field=>$stuff) {
	$item->$field = trim($request->$field);
}

file_put_contents(ACE_DIR."app/websites.xml", $modelData->asNiceXml());
