<?php

class router {

	public function dispatch(){

		$request = single('Request');
		$response = single('Response');

		$action = $request->get('action');
		if(is_null($action)) $action = 'index';

		if(preg_match('~[^a-zA-Z/]~', $action)){
			trigger_error('Invalid action name "' . $action . '"', E_USER_ERROR);
		}

		$action_filename = IDE_DIR . 'exegete/actions/' . $action . '.php';

		if(is_readable($action_filename)) {
			include $action_filename;
		} else {
			trigger_error('Action "' . $action_filename . '" Not Found', E_USER_ERROR);
		}

		$response->isAjax($request->isAjax());
		$response->send();

	}

}
