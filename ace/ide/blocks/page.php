<?php

namespace blocks;

class page extends \blocks\master {

	public function __construct() {
		parent::__construct();
		
		$this->data()->import(array(
				'doctype' => 'html',
		));
	}

}
