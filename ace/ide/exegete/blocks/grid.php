<?php

namespace blocks;

class grid extends \blocks\master {

	public function getXmlElemement(){
		$model = 'websites.xml';
		$data = new \XmlElement('<data/>');
		$modelConfig = new \XmlElement(IDE_DIR.'config/models/'.$model, 0, true);
		$data->insertXmlElement($modelConfig->grid);
		$data->insertXmlFile(APP_DIR.$model, 'items');
		return $data;
	}

}
