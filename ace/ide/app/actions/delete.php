<?php

$modelData = new AceXMLElement(file_get_contents(ACE_DIR."app/websites.xml"));
$itemCode = $_POST['code'];

//find position
$pos = 0;
foreach ($modelData->item as $item){
	if($item->code == $itemCode){
		$itemPosition = $pos;
		break;
	}
	$pos++;
}

unset($modelData->item[$itemPosition]);

file_put_contents(ACE_DIR."app/websites.xml", $modelData->asNiceXml());


