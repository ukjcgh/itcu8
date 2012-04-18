<?php

class block_page_head extends block_abstract {

	public function __construct() {
		$this->_xslData = array(
				'styles' => new ArrayObject,
		);
	}

}