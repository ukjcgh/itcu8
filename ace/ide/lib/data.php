<?php

class data {

	protected $hand;

	public function __construct($hand){
		$this->hand = $hand;
	}

	public function __call($method, $args){
		return call_user_func_array(array($this->hand, $method), $args);
	}

	public function __toString(){
		return (string)$this->hand;
	}

	public function hand(){
		return $this->hand;
	}

}