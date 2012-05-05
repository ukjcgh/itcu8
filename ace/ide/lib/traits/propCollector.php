<?php

trait propCollector {

	protected $_pub = array();
	protected $_prot = array();

	public function __set($name, $value) {
		if($this->isProt($name)) trigger_error('Can\'t set protected property "' . $name . '"', E_USER_ERROR);
		$this->_pub[$name] = $value;
	}

	public function __get($name) {
		if($this->isProt($name)){
			$name = substr($name, 1);
			return isset($this->_prot[$name]) ? $this->_prot[$name] : null;
		} else {
			return isset($this->_pub[$name]) ? $this->_pub[$name] : null;
		}
	}

	public function __isset($name) {
		if($this->isProt($name)){
			isset($this->_prot[$name]);
		} else {
			return isset($this->_pub[$name]);
		}
	}

	public function __unset($name) {
		if($this->isProt($name)) trigger_error('Can\'t unset protected property "' . $name . '"', E_USER_ERROR);
		unset($this->_pub[$name]);
	}

	public function import($data){
		if(is_scalar($data) || is_resource($data)){
			$this->data = $data;
		} else {
			foreach($data as $k=>$v){
				$this->{$k} = $v;
			}
		}
	}

	protected function isProt($name){
		return strpos($name, '_') === 0;
	}

}