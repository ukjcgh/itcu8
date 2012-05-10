<?php

$form = o('blocks\grid\form');
$modelConfig = new AceXMLElement(ACE_DIR.'ide/config/websites.xml', 0, true);
$form->config = $modelConfig->forms->add;

$response->form = $form;
