<?php

$model = object('xml\model')->init('websites');

// valiation
if($model->load($request->code)){
	$response->meta('user-error', 'Item with code "'. $request->code .'" already exists, try different one');
	return;
}

$model->import($request)->save()->commit();
