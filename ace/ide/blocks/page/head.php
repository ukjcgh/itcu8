<?php

namespace blocks\page;

class head extends \blocks\master {

	public function __construct() {
		$this->data = array(
				'styles' => new \ArrayObject,
				'scripts' => new \ArrayObject,
		);
	}

}