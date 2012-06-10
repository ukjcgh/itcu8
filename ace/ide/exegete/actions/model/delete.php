<?php

$model = object('xml\model')->init('websites')
->delete($request->{0})
->commit();
