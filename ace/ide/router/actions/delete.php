<?php

$itemCode = $request->{0};

$modelData = new AceXMLElement(file_get_contents(ACE_DIR."app/websites.xml"));

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
	file_put_contents(ACE_DIR."app/websites.xml", $modelData->asNiceXml());
} else {
	$response->meta('error', 'Item not found');
}


