<?php

$model = object('xml\model')->init('websites.xml');
if($model->load($request->{0})){
	$form = object('blocks\grid\form');
	$form->item = $model->export();
	$form->config = $model->getConfig()->forms->edit;
	$response->form = $form;
} else {
	$response->meta('error', 'Item with code="'.$request->{0}.'" not found.');
}
