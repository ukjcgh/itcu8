<?php

trait pubCollector {

	protected $data = array();

	public function __set($name, $value) {
		$this->data[$name] = $value;
	}

	public function __get($name) {
		return @$this->data[$name];
	}

}