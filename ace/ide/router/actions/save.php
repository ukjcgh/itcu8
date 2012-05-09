<?php

$itemCode = $request->data->code;

$modelData = new AceXMLElement(file_get_contents(ACE_DIR."app/websites.xml"));
$result = $modelData->xpath('item[./code=' . xpath_escape_var($itemCode) . ']');
$item = $result[0];

$modelConfig = new AceXMLElement(ACE_DIR.'ide/config/websites.xml', 0, true);
foreach($modelConfig->forms->edit->fields->children() as $field=>$stuff) {
	$item->$field = trim($request->data->$field);
}

file_put_contents(ACE_DIR."app/websites.xml", $modelData->asNiceXml());

