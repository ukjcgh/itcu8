<?php

class DataObject {

	protected $inst;

	public function __construct($class){
		if(!in_array('DataInstance', class_parents($class))){
			trigger_error('Can\'t create \\DataObject("'.$class.'"). Class "'.$class.'" should be an instance of \\DataInstance', E_USER_ERROR);
		}
		$this->inst = new $class($this);
	}

	public function inst(){
		return $this->inst;
	}

	public function __call($method, $args){
		return call_user_func_array(array($this->inst, $method), $args);
	}
	
	public function __toString(){
		return (string)$this->inst;
	}

}