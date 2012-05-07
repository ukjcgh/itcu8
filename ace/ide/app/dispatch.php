<?php

$request = new DataObject('Request');
$response = new Response;

$action_filename = IDE_DIR . 'app' . DS . 'actions' . DS . $request->getAction(). '.php';

if(is_readable($action_filename)) {
	include $action_filename;
} else {
	trigger_error('Action "' . $action_filename . '" Not Found', E_USER_ERROR);
}

if($request->isAjax()){
	if(!$request->actionIsLoaded){
		$handler_filename = IDE_DIR . 'app' . DS . 'actions' . DS . $request->_action . '.js';
		if(is_readable($handler_filename)){
			$response->handler = file_get_contents($handler_filename);
		} else {
			$response->error = 'Handler "' . $handler_filename . '" is not readable.';
		}
	}
}

$response->send();
