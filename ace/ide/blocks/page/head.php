<?php

namespace blocks\page;

class head extends \blocks\master {

	public function __construct() {
		$this->_xslData = array(
				'styles' => new \ArrayObject,
				'scripts' => new \ArrayObject,
		);
	}

}