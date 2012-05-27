<?php

$entity = $request->{0};

$model = object('xml\model')->init($entity);

$response->config = $model->getConfig()->asXml();
$response->data = $model->getSource()->asXml();
