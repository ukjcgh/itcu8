<?php

namespace blocks;

class page extends \blocks\master {

	public function __construct($dataObj) {
		parent::__construct($dataObj);
		
		$this->import(array(
				'doctype' => 'html',
		));
	}

}
