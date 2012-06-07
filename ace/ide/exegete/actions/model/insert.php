<?php

$model = object('xml\model')->init('websites');
if(!$model->load($request->code)){
	$model->import($request);
	$model->save();
	$model->commit();
} else {
	$response->meta('user-error', 'Item with code "'. $request->code .'" already exists, try different one');
}