<?php

namespace blocks;

class page extends \blocks\master {

	public function __construct() {
		parent::__construct();
		
		$this->import(array(
				'doctype' => 'html',
		));
	}

}
