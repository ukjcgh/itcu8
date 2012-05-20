<?php

namespace data;

class hand {

	public function data(){
		return \object\property::get($this, 'data');
	}

	public function __construct(){
		\object\property::set($this, 'data', new \data($this));
	}

	public function __destruct(){
		\object\property::delete($this, 'data');
	}

}
