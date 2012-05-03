<?php

trait pubCollector {

	protected $_pub = array();

	public function __set($name, $value) {
		$this->_pub[$name] = $value;
	}

	public function __get($name) {
		return @$this->_pub[$name];
	}

	public function __isset($name) {
		return isset($this->_pub[$name]);
	}

	public function __unset($name) {
		unset($this->_pub[$name]);
	}

}