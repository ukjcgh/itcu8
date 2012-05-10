<?php

class Request extends \data\hand {
	
	protected $action;
	protected $isAjax;
	protected $meta;

	public function __construct(){
		parent::__construct();

		if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
			$this->isAjax = true;
			$requestJson = isset($_POST['request']) ? $_POST['request'] : null;
			$request = json_decode($requestJson);
			if(isset($request->data)){
				$this->import($request->data);
				unset($request->data);
			}
			$this->meta = $request;
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
	
	public function meta($name){
		return isset($this->meta->$name) ? $this->meta->$name : null;
	}

}
