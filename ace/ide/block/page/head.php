<?php

class block_page_head extends block_abstract {

	public $title = 'no title';
	public $styles = array();
	public $scripts = array();

	public function getXslData(){
		$data = new AceXMLElement('<data/>');
		$data->title = $this->title;
		$stylesNode = $data->addChild('styles');
		foreach($this->styles as $style) $stylesNode->item[] = $style;
		return $data;
	}

}