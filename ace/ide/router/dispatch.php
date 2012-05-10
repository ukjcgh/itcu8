<?php

$request = o('Request');
$response = o('Response');

$action_filename = IDE_DIR . 'router' . DS . 'actions' . DS . $request->getAction(). '.php';

if(is_readable($action_filename)) {
	include $action_filename;
} else {
	trigger_error('Action "' . $action_filename . '" Not Found', E_USER_ERROR);
}

if($request->isAjax()){
	if(!$request->meta('isActionLoaded')){
		$handler_filename = IDE_DIR . 'router' . DS . 'actions' . DS . $request->getAction() . '.js';
		if(is_readable($handler_filename)){
			$response->meta('handler', file_get_contents($handler_filename));
		} else {
			$response->meta('error', 'Handler "' . $handler_filename . '" is not readable.');
		}
	}
}

$response->send();
