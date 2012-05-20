<?php

$itemCode = $request->{0};

$modelData = new XmlElement(file_get_contents(APP_DIR."websites.xml"));

//find position
$pos = 0;
$itemPosition = null;
foreach ($modelData->item as $item){
	if($item->code == $itemCode){
		$itemPosition = $pos;
		break;
	}
	$pos++;
}

if($itemPosition !== null){
	unset($modelData->item[$itemPosition]);
	file_put_contents(APP_DIR."websites.xml", $modelData->asNiceXml());
} else {
	$response->meta('error', 'Item not found');
}


