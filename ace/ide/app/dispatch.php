<?php

$request = new Request;
$response = new Response;

$action_filename = IDE_DIR . 'app' . DS . 'actions' . DS . $request->action . '.php';

if(is_readable($action_filename)) {
	include $action_filename;
} else {
	trigger_error('Action "' . $action_filename . '" Not Found', E_USER_ERROR);
}

if($request->isAjax()){
	if(!$request->data->actionIsLoaded){
		$response->handler = file_get_contents(IDE_DIR . 'app' . DS . 'actions' . DS . $request->action . '.js');
	}
}

$response->send();
