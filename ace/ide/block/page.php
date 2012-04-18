<?php

class block_page {
	
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

	public function __toString(){
		return templateXSL('page.xsl', $this->getXslData());
	}
}
