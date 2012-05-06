<?php

trait propsCollector {

	protected $props = array();

	public function __set($name, $value) {
		if(!$this->isPropAccessible($name)) {
			trigger_error('Can\'t set protected property "' . $name . '"', E_USER_ERROR);
		}
		$this->props[$name] = $value;
	}

	public function __get($name) {
		// allow to read protected properties
		return isset($this->props[$name]) ? $this->props[$name] : null;
	}

	public function __isset($name) {
		return isset($this->props[$name]);
	}

	public function __unset($name) {
		if(!$this->isPropAccessible($name)) {
			trigger_error('Can\'t unset protected property "' . $name . '"', E_USER_ERROR);
		}
		unset($this->props[$name]);
	}

	public function import($data){
		if(is_scalar($data) || is_resource($data)){
			trigger_error('Can\'t import data. Data must be iterable', E_USER_ERROR);
		}
		foreach($data as $k=>$v){
			if(!$this->isPropAccessible($k)) {
				trigger_error('Can\'t import protected property "' . $k . '"', E_USER_ERROR);
			}
			$this->{$k} = $v;
		}
	}

	public function props($filter = 'pub'){
		switch($filter){
			case 'all':
				return $this->props;
				break;
			case 'prot':
				$props = array();
				foreach($this->props as $k=>$v){
					if($k{0} == '_'){
						$props[$k] = $v;
					}
				}
				return $props;
				break;
			case 'pub':
				$props = array();
				foreach($this->props as $k=>$v){
					if($k{0} != '_'){
						$props[$k] = $v;
					}
				}
				return $props;
				break;
			default:
				trigger_error('Invalid filter value', E_USER_ERROR);
				break;
		}
	}

	protected function isPropAccessible($name){
		if($name{0} == '_') {
			if(!is_a($this, @debug_backtrace()[2]['class'])) {
				return false;
			}
		}
		return true;
	}

}