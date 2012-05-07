<?php

namespace blocks\page;

class head extends \blocks\master {

	public function __construct($dataObj) {
		parent::__construct($dataObj);
		
		$this->import(array(
				'styles' => new \ArrayObject,
				'scripts' => new \ArrayObject,
		));
	}

}