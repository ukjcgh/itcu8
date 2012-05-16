<?php

namespace data;

class hand {

	protected $data;

	public function __construct(){
		$this->data = new \data($this);
	}

	public function data(){
		return $this->data;
	}

	// this function should be here but not in \data to make it not possible to averride protected props of \data
	public function import($data){
		if(!is_iterable($data)){
			trigger_error('Can\'t import scalar value.', E_USER_ERROR);
		}
		foreach ($data as $k=>$v){
			$this->data->$k = $v;
		}
	}

	// this function should be here but not in \data to make it not possible to read protected props of \data
	public function export(){
		$data = new \stdClass;
		foreach ($this->data as $k=>$v){
			$data->$k = $v;
		}
		return $data;
	}
}
