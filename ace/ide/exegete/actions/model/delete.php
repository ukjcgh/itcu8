<?php

$model = object('xml\model')->init('websites');
$model->delete($request->{0});
$model->commit();
