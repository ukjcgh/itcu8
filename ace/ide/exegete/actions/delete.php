<?php

$model = object('xml\model')->init('websites.xml');
$model->delete($request->{0});
