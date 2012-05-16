<?php

/**
 * Global object properties storage
 */

namespace object;

class property {

	static protected $properties = array();

	static public function set($object, $property, $value){
		self::$properties[ohash($object)][$property] = $value;
	}

	static public function get($object, $property){
		return self::$properties[ohash($object)][$property];
	}

	static public function delete($object, $property){
		unset(self::$properties[ohash($object)][$property]);
	}

}
