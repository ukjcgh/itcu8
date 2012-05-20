<?php

$form = o('blocks\grid\form');
$modelConfig = new XmlElement(IDE_DIR.'config/models/websites.xml', 0, true);
$form->config = $modelConfig->forms->add;

$response->form = $form;
