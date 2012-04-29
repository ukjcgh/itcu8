<?php

class block_grid extends block_abstract {

	public function getXslData(){
		$model = 'websites.xml';
		$data = new AceXMLElement('<data/>');
		$modelConfig = new AceXMLElement(ACE_DIR.'ide/'.$model, 0, true);
		$data->insertXmlElement($modelConfig->grid);
		$data->insertXmlFile(ACE_DIR."app/$model", 'items');
		return $data;
	}

}
