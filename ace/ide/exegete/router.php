<?php

class router {

	public function dispatch(){

		$request = single('Request');
		$response = single('Response');

		$action_filename = IDE_DIR . 'exegete/actions/' . $request->getAction(). '.php';

		if(is_readable($action_filename)) {
			include $action_filename;
		} else {
			trigger_error('Action "' . $action_filename . '" Not Found', E_USER_ERROR);
		}

		$response->isAjax($request->isAjax());
		$response->send();

	}

}
