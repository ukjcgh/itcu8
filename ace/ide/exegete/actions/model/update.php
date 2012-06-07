<?php

$model = object('xml\model')->init('websites');
$model->import($request)->update()->commit();
