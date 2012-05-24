<?php

$model = object('xml\model')->init('websites.xml');
if(!$model->load($request->code)){
	$model->import($request);
	$model->upload();
} else {
	$response->meta('user-error', 'Item with code "'.$request->code.'" already exists, try different one');
}