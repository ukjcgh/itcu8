<?php

function html($str){
	return htmlspecialchars($str);
}

function stringify_objects(&$data){
	if(is_iterable($data)){
		if($data instanceof xml\element) return;
		if(is_callable(array($data, '__toString'))){
			$data = (string)$data;
		} else {
			foreach ($data as $k=>&$v){
				stringify_objects($v);
			}
		}
	}
}

function is_iterable($var){
	return is_array($var) || is_object($var);
}

function ohash($obj){
	return spl_object_hash($obj);
}

function object($class){
	$o = new $class;
	if(is_a($o, 'data\hand')){
		return $o->data();
	}
	return $o;
}

function single($class){
	static $objects = array();
	if(!isset($objects[$class])){
		$objects[$class] = object($class);
	}
	return $objects[$class];
}
