<?php

$request = o('Request');
$response = o('Response');

$action_filename = ACE_IDE_DIR . 'router' . DS . 'actions' . DS . $request->getAction(). '.php';

if(is_readable($action_filename)) {
	include $action_filename;
} else {
	trigger_error('Action "' . $action_filename . '" Not Found', E_USER_ERROR);
}

$response->send();
