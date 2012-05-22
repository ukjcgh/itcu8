<?php

$code = $request->{0};

$item = object('model\xml');
$item->setSource(APP_DIR."websites.xml");
if($item->load($code)){
	$form = object('blocks\grid\form');
	$form->item = $item->export();
	$config = new XmlElement(IDE_DIR.'config/models/websites.xml', 0, true);
	$form->config = $config->forms->edit;
	$response->form = $form;
} else {
	$response->meta('error', 'Item with code="'.$request->{0}.'" not found.');
}