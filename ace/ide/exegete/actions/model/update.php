<?php

$model = object('xml\model')->init('websites');
$model->import($request->data)->update($request->code)->commit();
