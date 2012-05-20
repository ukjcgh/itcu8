<?php

$itemCode = $request->code;

$modelData = new AceXMLElement(file_get_contents(APP_DIR."websites.xml"));
$result = $modelData->xpath('item[./code=' . xpath_escape_var($itemCode) . ']');
$item = $result[0];

$modelConfig = new AceXMLElement(IDE_DIR.'config/models/websites.xml', 0, true);
foreach($modelConfig->forms->edit->fields->children() as $field=>$stuff) {
	$item->$field = trim($request->$field);
}

file_put_contents(APP_DIR."websites.xml", $modelData->asNiceXml());

