<?php

$model = object('xml\model')->init('websites.xml');
if($model->load($request->code)){
	$model->import($request);
	$model->upload();
} else {
	$response->meta('error', 'Can\'t update item with code "'.$request->code.'", not found');
}