<?php

class data {

	public function __construct($hand){
		/**
		 * hide hand into global storage to clean object from own props to avoid conflicts
		 * also it is convenient for var_dump
		 */
		\object\property::set($this, 'hand', $hand);
	}

	public function hand(){
		return \object\property::get($this, 'hand');
	}

	public function import($data){
		foreach ($data as $k=>$v) $this->$k = $v;
	}
	

	public function export(){
		$data = new \stdClass;
		foreach ($this as $k=>$v) $data->$k = $v;
		return $data;
	}

	public function __destruct(){
		\object\property::delete($this, 'hand');
	}

	public function __call($method, $args){
		return call_user_func_array(array($this->hand(), $method), $args);
	}

	public function __get($name){
		return null;
	}

	public function __toString(){
		return (string)$this->hand();
	}

}

