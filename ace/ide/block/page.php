<?php

class block_page extends block_abstract {
	
	public $doctype = 'html';
	public $head;
	public $body;

	public function getXslData(){
		$data = new AceXMLElement('<data/>');
		$data->doctype = $this->doctype;
		$data->head = (string)$this->head;
		$data->body = (string)$this->body;
		return $data;
	}
	
}
