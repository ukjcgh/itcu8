<?php

class DataInstance {

	protected $data;

	public function __construct($dataObj){
		$this->data = $dataObj;
	}

	public function import($data){
		foreach ($data as $k=>$v){
			$this->data->$k = $v;
		}
	}

}