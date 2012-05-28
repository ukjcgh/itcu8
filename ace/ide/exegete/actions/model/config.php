<?php

$model = object('xml\model')->init('websites');
$response->xml = file_get_contents($model->getConfigFile());