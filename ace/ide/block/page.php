<?php

class block_page {
	
	public $head;
	public $body;
	
	public function getXslData(){
		$data = new AceXMLElement('<data/>');
		$data->head = (string)$this->head;
		$data->body = $this->body;
		return $data;
	}
}
