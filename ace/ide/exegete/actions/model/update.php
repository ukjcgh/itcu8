<?php

$model = object('xml\model')->init('websites');
if($model->load($request->code)){
	$model->import($request);
	$model->save();
	$model->commit();
} else {
	$response->meta('error', 'Can\'t update item with code "'.$request->code.'", not found');
}
