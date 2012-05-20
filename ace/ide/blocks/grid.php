<?php

namespace blocks;

class grid extends \blocks\master {

	public function getXslData(){
		$model = 'websites.xml';
		$data = new \AceXMLElement('<data/>');
		$modelConfig = new \AceXMLElement(IDE_DIR.'config/'.$model, 0, true);
		$data->insertXmlElement($modelConfig->grid);
		$data->insertXmlFile(APP_DIR.$model, 'items');
		return $data;
	}

}
