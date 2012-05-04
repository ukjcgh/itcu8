<?php

trait pubCollector {

	protected $_pub = array();

	public function __set($name, $value) {
		$this->_pub[$name] = $value;
	}

	public function __get($name) {
		return isset($this->_pub[$name]) ? $this->_pub[$name] : null;
	}

	public function __isset($name) {
		return isset($this->_pub[$name]);
	}

	public function __unset($name) {
		unset($this->_pub[$name]);
	}

	public function import($data){
		if(is_scalar($data)){
			$this->data = $data;
		} else {
			foreach($data as $k=>$v){
				$this->{$k} = $v;
			}
		}
	}

}