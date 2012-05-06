<?php

class Request {

	use propsCollector;

	public function __construct(){

		if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
			$this->_isAjax = true;
			$requestJson = isset($_POST['request']) ? $_POST['request'] : null;
			$request = json_decode($requestJson);
			$this->import($request);
		} else {
			$this->import($_POST);
		}

		$this->_action = isset($_GET['action']) ? $_GET['action'] : 'default';
		if(preg_match('~[^a-z]~', $this->_action)){
			trigger_error('Invalid action name "' . $this->_action . '"', E_USER_ERROR);
		}

	}

}
