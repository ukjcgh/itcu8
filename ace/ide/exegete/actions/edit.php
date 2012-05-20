<?php

$itemCode = $request->{0};

$form = o('blocks\grid\form');
$modelData = new XmlElement('<data/>');
$modelData->insertXmlFile(APP_DIR."websites.xml", 'items');
$result = $modelData->xpath('items/item[./code=' . xpath_escape_var($itemCode) . ']');
$form->item = $result[0];

$modelConfig = new XmlElement(IDE_DIR.'config/models/websites.xml', 0, true);
$form->config = $modelConfig->forms->edit;

$response->form = $form;
