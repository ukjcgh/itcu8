<?php

namespace blocks;

abstract class master {

	use \propCollector;

	public function __toString() {
		return templateXSL($this->getTemplateFileName(), $this->getXslData());
	}

	public function getTemplateFileName(){
		$className = get_class($this);
		$blockName = substr($className, strpos($className, '\\') + 1);
		$blockPath = str_replace('\\', DS, $blockName);
		return $blockPath . '.xsl';
	}

	public function getXslData(){
		$data = new \AceXMLElement('<data/>');
		foreach ($this->_pub as $key => $value) {
			if($value instanceof \ArrayObject || gettype($value) == 'array') {
				$data->insertArray($key, $value);
			} elseif($value instanceof \SimpleXMLElement) {
				$data->insertXmlElement($value, $key);
			} else {
				$data->$key = (string)$value;
			}
		}
		return $data;
	}

}
