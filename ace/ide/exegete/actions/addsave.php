<?php

$modelData = new XmlElement(file_get_contents(APP_DIR."websites.xml"));
$modelConfig = new XmlElement(IDE_DIR.'config/models/websites.xml', 0, true);

$item = $modelData->addChild('item');

foreach($modelConfig->forms->add->fields->children() as $field=>$stuff) {
	$item->$field = trim($request->$field);
}

file_put_contents(APP_DIR."websites.xml", $modelData->asNiceXml());
