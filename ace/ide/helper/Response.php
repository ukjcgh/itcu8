<?php

class Response extends \data\hand {

	protected $meta;
	protected $isAjax;

	public function __construct(){
		parent::__construct();
		$this->meta = new stdClass;
	}

	public function __toString(){
		if($this->isAjax){
			$post = $this->meta;
			$post->data = $this->data()->export(); // export to avoid recursion (stringify of itself)
			stringify_objects($post->data);
			return json_encode($post);
		} else {
			return (string)$this->data()->html;
		}
	}

	public function send($exit = true){
		//TODO: log and clean output from ob
		if($this->isAjax){
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

	public function isAjax($value){
		$this->isAjax = $value;
	}

}
