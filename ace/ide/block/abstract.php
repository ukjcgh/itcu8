<?php

abstract class block_abstract {

	public function __toString() {
		return templateXSL($this->getTemplateFileName(), $this->getXslData());
	}

	public function getTemplateFileName(){
		$className = get_class($this);
		$blockName = substr($className, strpos($className, '_') + 1);
		$blockPath = str_replace('_', '/', $blockName);
		return $blockPath . '.xsl';
	}


	protected $_xslData = array();

	public function __set($name, $value) {
		$this->_xslData[$name] = $value;
	}

	public function __get($name) {
		return @$this->_xslData[$name];
	}

	public function getXslData(){
		$data = new AceXMLElement('<data/>');
		foreach ($this->_xslData as $key => $value) {
			if($value instanceof ArrayObject || gettype($value) == 'array') {
				$data->insertArray($key, $value);
			} elseif($value instanceof SimpleXMLElement) {
				$data->insertXmlElement($value, $key);
			} else {
				$data->$key = (string)$value;
			}
		}
		return $data;
	}

}
