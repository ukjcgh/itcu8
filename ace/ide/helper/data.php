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

	public function import($data, $clean = 1){
		if($clean) $this->clean();
		foreach ($data as $k=>$v) $this->$k = $v;
		return $this;
	}

	public function clean(){
		foreach ($this as $k=>$v) unset($this->$k);
		return $this;
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
		$hand = $this->hand();
		$result = call_user_func_array(array($hand, $method), $args);
		return $result === $hand ? $this : $result;
	}

	public function __get($name){
		return null;
	}

	public function __toString(){
		return (string)$this->hand();
	}

}

