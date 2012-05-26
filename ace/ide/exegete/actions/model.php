<?php

$entity = $request->{0};

$model = object('xml\model')->init($entity);

$response->model = $model->getConfig();
