<?php

class Request {

	protected $isAjax = false;

	public function __construct(){

		if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
			$this->isAjax = true;
			$requestData = isset($_POST['requestData']) ? $_POST['requestData'] : null;
			$this->data = json_decode($requestData);
		} else {
			$this->data = $_POST;
		}

		$this->action = isset($_GET['action']) ? $_GET['action'] : 'default';
		if(preg_match('~[^a-z]~', $this->action)){
			trigger_error('Invalid action name', E_USER_ERROR);
		}

	}

	public function isAjax(){
		return $this->isAjax;
	}

}
