<?php


class block_page_head {
	
	public $title = '';
	
	protected $css = array();
	protected $js = array();
	
	public function addCss($relUrl){
		$this->css[] = $relUrl;
	}
	
	public function getXslData(){
		$data = new AceXMLElement('<data/>');
		$data->title = $this->title;
		$cssNode = $data->addChild('css');
		foreach($this->css as $css)	$cssNode->item[] = $css;
		return $data;
	}
}