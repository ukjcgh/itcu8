<?php

class router {

	public static function dispatch(){
		$request = o('Request');
		$response = o('Response');
		$response->setRequest($request);

		$action_filename = IDE_DIR . 'exegete/actions/' . $request->getAction(). '.php';

		if(is_readable($action_filename)) {
			include $action_filename;
		} else {
			trigger_error('Action "' . $action_filename . '" Not Found', E_USER_ERROR);
		}

		$response->send();
	}

}
