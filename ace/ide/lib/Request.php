<?php

class Request extends DataInstance {
	
	protected $action;
	protected $isAjax;

	public function __construct($dataObj){

		parent::__construct($dataObj);

		if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
			$this->isAjax = true;
			$requestJson = isset($_POST['request']) ? $_POST['request'] : null;
			$request = json_decode($requestJson);
			$this->import($request);
		} else {
			$this->extract($_POST);
		}

		$this->action = isset($_GET['action']) ? $_GET['action'] : 'default';
		if(preg_match('~[^a-z]~', $this->action)){
			trigger_error('Invalid action name "' . $this->action . '"', E_USER_ERROR);
		}

	}
	
	public function getAction(){
		return $this->action;
	}
	
	public function isAjax(){
		return $this->isAjax;
	}

	public function extract($post){
	}

}
