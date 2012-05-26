<?php

$entity = $request->{0};

$model = object('xml/model')->init($entity);

var_dump($model->getConfig());
