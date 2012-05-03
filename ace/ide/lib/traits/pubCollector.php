<?php

trait pubCollector {

	protected $_pub = array();

	public function __set($name, $value) {
		$this->_pub[$name] = $value;
	}

	public function __get($name) {
		return @$this->_pub[$name];
	}

}