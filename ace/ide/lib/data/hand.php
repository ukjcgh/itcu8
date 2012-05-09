<?php

namespace data;

class hand {

	protected $box;

	public function __construct(){
		$this->box = new box($this);
	}

	public function import($data){
		foreach ($data as $k=>$v){
			$this->box->$k = $v;
		}
	}

	public function box(){
		return $this->box;
	}

}
