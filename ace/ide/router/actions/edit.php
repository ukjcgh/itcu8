<?php

$itemCode = $request->{0};

$form = o('blocks\grid\form');
$modelData = new AceXMLElement('<data/>');
$modelData->insertXmlFile(ACE_DIR."app/websites.xml", 'items');
$result = $modelData->xpath('items/item[./code=' . xpath_escape_var($itemCode) . ']');
$form->item = $result[0];

$modelConfig = new AceXMLElement(ACE_DIR.'ide/config/websites.xml', 0, true);
$form->config = $modelConfig->forms->edit;

$response->form = $form;
