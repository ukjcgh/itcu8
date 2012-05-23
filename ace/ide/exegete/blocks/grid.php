<?php

namespace blocks;

class grid extends \blocks\master {

	public function getXmlElemement(){
		$model = 'websites.xml';
		$data = new \xml\element('<data/>');
		$modelConfig = new \xml\element(IDE_DIR.'config/models/'.$model, 0, true);
		$data->insertXmlElement($modelConfig->grid);
		$data->insertXmlFile(APP_DIR.$model, 'items');
		return $data;
	}

}
