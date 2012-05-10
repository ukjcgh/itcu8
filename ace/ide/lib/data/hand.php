<?php

namespace data;

class hand {

	protected $box;

	public function __construct(){
		$this->box = new box($this);
	}

	public function box(){
		return $this->box;
	}

	// this function should here but not in \data\box to make it not possible to averride protected props of box
	public function import($data){
		foreach ($data as $k=>$v){
			$this->box->$k = $v;
		}
	}

	public function export(){
		$data = new \stdClass;
		foreach ($this->box as $k=>$v){
			$data->$k = $v;
		}
		return $data;
	}
}
