<?php

function html($str){
	return htmlspecialchars($str);
}

function xpath_escape_var($var){
	if(strpos($var, '"') !== false) {
		$escaped = preg_replace('~("+)~', '",\'$1\',"', $var);
		$escaped = 'concat("' . $escaped . '")';
	} else {
		$escaped = "'$var'";
	}
	return $escaped;
}

function stringify_objects(&$data){
	if(is_iterable($data)){
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

function o($class){
	$o = new $class;
	if(is_a($o, 'data\hand')){
		return $o->data();
	}
	return $o;
}

function single($class){
	static $objects = array();
	if(!isset($objects[$class])){
		$objects[$class] = o($class);
	}
	return $objects[$class];
}
