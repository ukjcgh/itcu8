<?php

class Response extends \data\hand {

	protected $meta;

	public function __construct(){
		parent::__construct();
		$this->meta = new stdClass;
	}

	public function __toString(){
		global $request;

		if($request->isAjax()){
			$post = $this->meta;
			$post->box = $this->box;
			return ace_json($post, get_class($this));
		} else {
			return (string)$this->box->html;
		}
	}

	public function send($exit = true){
		//TODO: log and clean output from ob
		global $request;

		if($request->isAjax()){
			header('Content-type: text/json');
		}

		echo $this;

		if($exit) exit;
	}

	public function meta($name){
		if(func_num_args() > 1){
			$value = func_get_arg(1);
			$this->meta->$name = $value;
		} else {
			return isset($this->meta->$name) ? $this->meta->$name : null;
		}
	}

}
