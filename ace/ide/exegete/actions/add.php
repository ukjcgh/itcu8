<?php

$form = object('blocks\grid\form');
$modelConfig = new xml\element(IDE_DIR.'config/models/websites.xml', 0, true);
$form->config = $modelConfig->forms->add;

$response->form = $form;
