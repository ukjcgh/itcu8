<?php

class Request extends \data\hand {

	protected $isAjax;
	protected $meta;

	public function __construct(){
		parent::__construct();

		if(isset($_SERVER['HTTP_AJAX_TYPE'])){
			$this->isAjax = true;
			$requestJson = $this->post('request');
			$request = json_decode($requestJson);
			if(isset($request->data)){
				$this->data()->import($request->data);
				unset($request->data);
			}
			$this->meta = $request;
		}

	}

	public function isAjax(){
		return $this->isAjax;
	}

	public function meta($name){
		return isset($this->meta->$name) ? $this->meta->$name : null;
	}

	public function get($var = null){
		if(is_null($var)){
			return $_GET;
		} else {
			return isset($_GET[$var]) ? $_GET[$var] : null;
		}
	}

	public function post($var = null){
		if(is_null($var)){
			return $_POST;
		} else {
			return isset($_POST[$var]) ? $_POST[$var] : null;
		}
	}

}
