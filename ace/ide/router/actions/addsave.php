<?php

$modelData = new AceXMLElement(file_get_contents(APP_DIR."websites.xml"));
$modelConfig = new AceXMLElement(IDE_DIR.'config/websites.xml', 0, true);

$item = $modelData->addChild('item');

foreach($modelConfig->forms->add->fields->children() as $field=>$stuff) {
	$item->$field = trim($request->$field);
}

file_put_contents(APP_DIR."websites.xml", $modelData->asNiceXml());
